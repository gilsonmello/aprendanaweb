<?php namespace App\Repositories\Backend\Ticket;

use App\Ticket;
use App\TicketMessage;
use App\Enrollment;
use App\Content;
use App\Exceptions\GeneralException;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Repositories\Backend\Sector\SectorContract;

/**
 * Class EloquentTicketRepository
 * @package App\Repositories\Ticket
 */
class EloquentTicketRepository implements TicketContract {



    /**
     * @param TicketContract $tickets
     */
    public function __construct(SectorContract $sectors) {
        $this->sectors = $sectors;
    }

	/**
	 * @param $id
	 * @return mixed
	 * @throws GeneralException
	 */
	public function findOrThrowException($id) {
		$ticket = Ticket::withTrashed()->find($id);

		if (! is_null($ticket)) return $ticket;

		throw new GeneralException('That ticket does not exist.');
	}

	/**
	 * @param $per_page
	 * @param string $order_by
	 * @param string $sort
	 * @return mixed
	 */
	public function getTicketsPaginated($per_page, $id, $date_begin, $date_end, $dead_line_begin, $dead_line_end, $is_replied, $is_finished, $sector_id = null, $order_by = 'date_dead_line_reply', $sort = 'desc') {

        $query = Ticket::allIfResponsible();

        if (isset($id) && $id != "")
            $query->where('id', '=', $id);
        if (isset($date_begin) && $date_begin != "")
            $query->where('updated_at', '>=', parsebr($date_begin));
        if (isset($date_begin) && $date_end != "")
            $query->where('updated_at', '<', parsebr($date_end)->addDay());
        if (isset($dead_line_begin) && $dead_line_begin != "")
            $query->where('date_dead_line_reply', '>=', parsebr($dead_line_begin));
        if (isset($dead_line_end) && $dead_line_end != "")
            $query->where('date_dead_line_reply', '<', parsebr($dead_line_end)->addDay());
        if (isset($is_replied) && $is_replied != 2)
            $query->where('is_replied', '=', $is_replied);
        if (isset($is_finished) && $is_finished != 2)
            $query->where('is_finished', '=', $is_finished);
        if(isset($sector_id) && $sector_id != "")
            $query->where('sector_id', '=', $sector_id);

        $ticket = $query->orderBy($order_by, $sort)->paginate($per_page);
        return $ticket;
        
	}

    public function getTicketsStudentPaginated($per_page, $user_id, $order_by = 'id', $sort = 'desc'){
        return Ticket::where('user_student_id', '=', $user_id)->orderBy($order_by, $sort)->paginate($per_page);
    }


	/**
	 * @param $per_page
	 * @return \Illuminate\Pagination\Paginator
	 */
	public function getDeletedTicketsPaginated($per_page) {
		return Ticket::onlyTrashed()->paginate($per_page);
	}

	/**
	 * @param string $order_by
	 * @param string $sort
	 * @return mixed
	 */
	public function getAllTickets($order_by = 'id', $sort = 'asc') {
		return Ticket::orderBy($order_by, $sort)->get();
	}

    /**
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function create($input) {
        $ticket = $this->createTicketStub($input);
        if($ticket->save()) {
            $sector= $this->sectors->findOrThrowException($input['sectors'][0]);

            $users =$sector->users()->get(["name","email"]);

            $course = "";

            $enrollments = Enrollment::where("student_id", "=", $ticket->user_student_id)
                ->where("is_active", "=", 1)
                ->whereNotNull("course_id")
                ->orderBy("date_begin", "desc")->get();
            if (count($enrollments) != 0){
                $enrollment = $enrollments[0];
                if ($enrollment->course != null){
                    $course = $enrollment->course->title;
                } else {
                    $course = $enrollment->exam->title;
                }
            }

            Mail::send('emails.ticket_create', ['id' => $ticket->id,
                'ticket_message' => nl2br($ticket->message),
                'sector' => $ticket->sector->name,
                'from' => $ticket->userStudent->name,
                'fromemail' => $ticket->userStudent->email,
                'course' => $course,
                'reply_message' => ''
            ], function($message) use ($ticket, $sector, $users)
            {
                foreach($users as $user){
                    $message->to($user->email, $user->name);
                }
                $message->subject(app_name() . ': ' . trans('strings.ticket_reply_message') . $ticket->id );
            });

            return $ticket->id;
        }
        throw new GeneralException('There was a problem creating this ticket. Please try again.');
    }

    /**
     * @param $id
     * @param $input
     * @param $admins
     * @return bool
     * @throws GeneralException
     */
    public function update($id, $input, $admins) {
        $ticket = $this->findOrThrowException($id);
        if(isset($input['tags'])) $input['tags'] = implode(';', $input['tags']);

        if ($ticket->update($input)) {
            $ticket->name = $input['name'];
            $ticket->save();
            return true;
        }

        throw new GeneralException('There was a problem updating this ticket. Please try again.');
    }


    /**
     * @param $id
     * @return bool
     * @throws GeneralException
     */
    public function destroy($id) {
        $ticket = $this->findOrThrowException($id);
        if ($ticket->delete())
            return true;

        throw new GeneralException("There was a problem deleting this ticket. Please try again.");
    }

    /**
     * @param $input
     * @return mixed
     */
    private function createTicketStub($input)
    {
        $ticket = new Ticket;
        $ticket->user_student_id = auth()->id();
        $ticket->sector_id = $input['sectors'][0];
        $ticket->message = $input['message'];
        $ticket->created_at = Carbon::now();
        $ticket->updated_at = Carbon::now();
        $ticket->date_dead_line_reply = Carbon::now()->addHours( $ticket->sector->hours_to_reply );
        $ticket->is_replied = 0;
        $ticket->is_finished = 0;
        return $ticket;
    }

    /**
     * @param $id
     * @param $input
     * @return mixed
     */
    public function answered($input, $messageTicket){
        $ticket = $this->findOrThrowException($input['ticket_id']);
        $ticket->updated_at = Carbon::now();
        $ticket->date_dead_line_reply = Carbon::now()->addHours( $ticket->sector->hours_to_reply );
        $ticket->is_replied = 1;
        $ticket->save();

        Mail::send('emails.ticket_answer_to_student', ['id' => $ticket->id,
                                            'ticket_message' => nl2br($ticket->message),
                                            'from' => $messageTicket->user->name,
                                            'reply_message' => trans('strings.reply_message') . ': ' . nl2br($messageTicket->message)
                                            ], function($message) use ($ticket)
        {
            $message->to($ticket->userStudent->email, $ticket->userStudent->name);
            $message->subject(app_name() . ': ' . trans('strings.ticket_reply_message') . $ticket->id );
        });
        return true;

        throw new GeneralException('There was a problem updating this ticket. Please try again.');
    }

    /**
     * @param $id
     * @param $input
     * @return mixed
     */
    public function notAnswered($input, $messageTicket){
        $ticket = $this->findOrThrowException($input['ticket_id']);
        $ticket->updated_at = Carbon::now();
        $ticket->date_dead_line_reply = Carbon::now()->addHours( $ticket->sector->hours_to_reply );
        $ticket->is_replied = 0;
        $ticket->save();

        $sector= $ticket->sector;

        $users =$sector->users()->get(["name","email"]);

        $messages = TicketMessage::where('ticket_id', '=', $ticket->id)->orderBy("created_at", "desc")->get();

        $history = '';
        foreach ($messages as $message){
            $history = $history . ($message->user_id == auth()->id() ? "<b>Aluno: </b>" : "<b>Atendente: </b>");
            $history = $history . $message->user->name . ' [' . format_datetimebr( $message->created_at ) . ']<br>';
            $history = $history . nl2br($message->message) . '<br>________________________<br><br>';
        }

        Mail::send('emails.ticket_answer', ['id' => $ticket->id,
            'ticket_message' => nl2br($ticket->message),
            'from' => $ticket->userStudent->name,
            'fromemail' => $ticket->userStudent->email,
            'reply_message' => $history
        ], function($message) use ($ticket, $sector, $users)
        {
            foreach($users as $user){
                $message->to($user->email, $user->name);
            }
            $message->subject(app_name() . ': ' . trans('strings.ticket_reply_message') . $ticket->id );
        });

        return true;

        throw new GeneralException('There was a problem updating this ticket. Please try again.');
    }


    public function finish($input){
        $ticket = $this->findOrThrowException($input['ticket_id']);
        $ticket->updated_at = Carbon::now();
        $ticket->is_finished = 1;
        $ticket->is_replied = 1;
        $ticket->save();
        Mail::send('emails.ticket_finish', ['id' => $ticket->id,
            'ticket_message' => nl2br($ticket->message),
            'message_finish' => $ticket->sector->message_finish,
            'from' => auth()->user()->name,
        ], function($message) use ($ticket)
        {
            $message->to($ticket->userStudent->email, $ticket->userStudent->name)->subject(app_name() . ': ' . trans('strings.ticket_finish_message') . $ticket->id );
        });
        return true;

        throw new GeneralException('There was a problem updating this ticket. Please try again.');
    }

    /**
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function createTicket($sector_id, $message, $content_id, $enrollment_id) {

        //associar ticket a enrollment e content - nullables

        $ticket = new Ticket;
        $ticket->user_student_id = auth()->id();
        $ticket->sector_id = $sector_id;
        $ticket->content_id = $content_id;
        $ticket->enrollment_id = $enrollment_id;
        $ticket->message = $message;
        $ticket->created_at = Carbon::now();
        $ticket->updated_at = Carbon::now();
        $sector= $this->sectors->findOrThrowException($sector_id);
        $ticket->date_dead_line_reply = Carbon::now()->addHours( $sector->hours_to_reply );
        $ticket->is_replied = 0;
        $ticket->is_finished = 0;

        if($ticket->save()) {
            $course = "";
            $content = Content::find($content_id);
            if ($content != null) {
                $course = $content->lesson->module->course->title . " :: " .
                    $content->lesson->module->name . " :: Aula " .
                    $content->lesson->sequence . " :: Bloco " .
                    $content->sequence;
            }

            $users =$sector->users()->get(["name","email"]);

            Mail::send('emails.ticket_create', ['id' => $ticket->id,
                'ticket_message' => nl2br($ticket->message),
                'sector' => $ticket->sector->name,
                'from' => $ticket->userStudent->name,
                'fromemail' => $ticket->userStudent->email,
                'course' => $course,
                'reply_message' => ''
            ], function($message) use ($ticket, $sector, $users)
            {
                foreach($users as $user){
                    $message->to($user->email, $user->name);
                }
                $message->subject(app_name() . ': ' . trans('strings.ticket_open') . $ticket->id );
            });

            return $ticket->id;
        }
        throw new GeneralException('There was a problem creating this ticket. Please try again.');
    }

}