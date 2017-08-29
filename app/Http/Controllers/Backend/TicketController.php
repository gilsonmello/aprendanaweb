<?PHP namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Ticket\CreateTicketRequest;
use App\Http\Requests\Backend\TicketMessage\CreateTicketMessageRequest;
use App\Http\Requests\Backend\Ticket\UpdateTicketRequest;
use App\Repositories\Backend\Notification\NotificationContract;
use App\Repositories\Backend\Ticket\TicketContract;
use App\Repositories\Backend\TicketMessage\TicketMessageContract;
use App\Repositories\Backend\Sector\SectorContract;
use App\Repositories\Backend\User\UserContract;
use Illuminate\Http\Request;
use Carbon\Carbon;
/**
 * Class DashboardController
 * @package App\Http\Controllers\Backend
 */
class TicketController extends Controller {

    /**
     * @param TicketContract $tickets
     */
    public function __construct(TicketContract $tickets, TicketMessageContract $ticketMessage,NotificationContract $notification, SectorContract $sectors ) {
        $this->tickets = $tickets;
        $this->ticketMessage = $ticketMessage;
        $this->notification = $notification;
        $this->sectors = $sectors;
    }

    /**
     * @return mixed
     */
    public function index(Request $request) {

        $request->session()->put('lastpage', $request->only('page')['page']);

        $f_submit = $request->input('f_submit', '');

        $sector = $this->sectors->getSectors();

        $f_TicketController_id = get_parameter_or_session( $request, 'f_TicketController_id', '', $f_submit, '' );

        $f_TicketController_date_begin = get_parameter_or_session( $request, 'f_TicketController_date_begin', '', $f_submit, format_datebr(Carbon::now()->addDays(-30) ));

        $f_TicketController_date_end = get_parameter_or_session( $request, 'f_TicketController_date_end', '', $f_submit, format_datebr(Carbon::now() ));

        $f_TicketController_dead_line_begin = get_parameter_or_session( $request, 'f_TicketController_dead_line_begin', '', $f_submit, format_datebr(Carbon::now() ));

        $f_TicketController_dead_line_end = get_parameter_or_session( $request, 'f_TicketController_dead_line_end', '', $f_submit, format_datebr(Carbon::now()->addDays(7) ));

        $f_TicketController_is_replied = get_parameter_or_session( $request, 'f_TicketController_is_replied', '', $f_submit, '0' );

        $f_TicketController_is_finished = get_parameter_or_session( $request, 'f_TicketController_is_finished', '', $f_submit, '0' );

        $f_TicketController_sector_id = get_parameter_or_session( $request, 'f_TicketController_sector_id', '', $f_submit, '' );

        $f_TicketController_export_to_csv = get_parameter_or_session( $request, 'f_TicketController_export_to_csv', '', '1', '0' );


        if ($f_TicketController_id != ''){
            $f_TicketController_date_begin = '';
            $f_TicketController_date_end = '';
            $f_TicketController_dead_line_begin = '';
            $f_TicketController_dead_line_end = '';
            $f_TicketController_is_replied = '2';
            $f_TicketController_is_finished = '2';
            $f_TicketController_sector_id = "";
        }


        $tickets = $this->tickets->getTicketsPaginated(config('access.users.default_per_page'), $f_TicketController_id,
            $f_TicketController_date_begin, $f_TicketController_date_end,
            $f_TicketController_dead_line_begin, $f_TicketController_dead_line_end,
            $f_TicketController_is_replied, $f_TicketController_is_finished, $f_TicketController_sector_id);

        if($f_TicketController_export_to_csv == '1') {
            $this->tickets_to_csv_download($tickets);
        }else{
            return view('backend.tickets.index')
                ->withTickets($tickets)
                ->withTicketcontrollerid($f_TicketController_id)
                ->withTicketcontrollerdatebegin($f_TicketController_date_begin)
                ->withTicketcontrollerdateend($f_TicketController_date_end)
                ->withTicketcontrollerdeadlinebegin($f_TicketController_dead_line_begin)
                ->withTicketcontrollerdeadlineend($f_TicketController_dead_line_end)
                ->withTicketcontrollerisreplied($f_TicketController_is_replied)
                ->withTicketcontrollerisfinished($f_TicketController_is_finished)
                ->withTicketcontrollersectorid($f_TicketController_sector_id)
                ->withSectors($sector);
        }
    }

    function tickets_to_csv_download($tickets, $delimiter=",") {
        // open raw memory as file so no temp files needed, you might run out of memory though
        $f = fopen('php://output', 'w');

        $filename = "exportacao_ticket_" . time()  . ".csv";
        fputs($f, $bom =( chr(0xEF) . chr(0xBB) . chr(0xBF) ));
        header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename="'.$filename.'";');

        fputcsv(
            $f,
            [
                trans('strings.student'),
                "E-mail",
                trans('strings.sector'),
                trans('crud.tickets.message'),
                trans('crud.tickets.date_dead_line_reply'),
                trans('crud.tickets.updated_at'),
                trans('crud.tickets.is_replied'),
                trans('crud.tickets.is_finished'),
            ],
            ',');

        foreach ($tickets as $result) {
            // generate csv lines from the inner arrays
            $line = [
                (!empty($result->userStudent)) ? $result->userStudent->name : "",
                (!empty($result->userStudent)) ? $result->userStudent->email: "",
                (!empty($result->sector->name)) ? $result->sector->name : "",
                (!empty($result->message)) ? preg_replace( "/\r|\n/", " ", $result->message ) : "",
                ($result->date_dead_line_reply != null) ? format_datebr($result->date_dead_line_reply) : "",
                ($result->updated_at != null) ? format_datebr($result->updated_at) : "",
                ($result->is_replied == 1) ? "Sim" : "Não",
                ($result->is_finished == 1) ? "Sim" : "Não"
            ];
            fputcsv($f, $line, $delimiter);
        }
        fpassthru($f);
    }

    public function listTicket() {
        return view('backend.tickets.list')
            ->withTickets($this->tickets->getAllTickets( ))
            ->withUsers($this->users->getUsersTickets( ));
    }

    /**
     * @return mixed
     */
    public function create() {
        return view('backend.tickets.create');
    }

    /**
     * @param CreateTicketRequest $request
     * @return mixed
     */
    public function store(CreateTicketRequest $request) {
        $this->tickets->create($request);
        return redirect()->route('admin.tickets.index')->withFlashSuccess(trans("alerts.tickets.created"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit($id) {
        $ticket = $this->tickets->findOrThrowException($id, true);

        $messages = $this->ticketMessage->getAllTicketMessages($ticket->id);

        return view('backend.tickets.edit')
            ->withTicket($ticket)
            ->withMessages($messages);
    }

    /**
     * @param $id
     * @param UpdateTicketRequest $request
     * @return mixed
     */
    public function update($id, UpdateTicketRequest $request) {
        $this->tickets->update($id, $request->all());
        return redirect()->route('admin.tickets.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.tickets.updated"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id) {
        $this->tickets->destroy($id);
        return redirect()->back()->withFlashSuccess(trans("alerts.tickets.deleted"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function messageDestroy($id) {
        $this->ticketMessage->destroy($id);
        return redirect()->back()->withFlashSuccess(trans("alerts.tickets.deleted"));
    }

    /**
     * @param CreateTicketRequest $request
     * @return mixed
     */
    public function messageStore(CreateTicketMessageRequest $request) {
        $ticketMessage = $this->ticketMessage->create($request);
        if ($ticketMessage != null){
            $this->tickets->answered($request, $ticketMessage);
            $this->notification->save_and_broadcast(array($ticketMessage->ticket->userStudent),'Seu ticket foi respondido.', '/student/ticketstudents/'. $ticketMessage->ticket->id . '/edit','fa-ticket bg-info');

        }
        return redirect()->back()->withFlashSuccess(trans("alerts.tickets.message_replied"));
    }

    public function finish(Request $request) {
        $this->tickets->finish($request);
        $ticket = $this->tickets->findOrThrowException($request['ticket_id']);
        $this->notification->save_and_broadcast(array($ticket->userStudent),'Seu ticket foi encerrado.', '/student/ticketstudents/'. $ticket->id . '/edit','fa-ticket bg-danger');
        return redirect()->route('admin.tickets.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.tickets.finish"));
    }

}