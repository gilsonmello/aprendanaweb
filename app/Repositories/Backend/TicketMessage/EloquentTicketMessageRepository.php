<?php namespace App\Repositories\Backend\TicketMessage;

use App\TicketMessage;
use App\Exceptions\GeneralException;
use Carbon\Carbon;

/**
 * Class EloquentTicketMessageRepository
 * @package App\Repositories\TicketMessage
 */
class EloquentTicketMessageRepository implements TicketMessageContract {


//	public function __construct() {
//	}

	/**
	 * @param $id
	 * @return mixed
	 * @throws GeneralException
	 */
	public function findOrThrowException($id) {
		$ticketMessage = TicketMessage::withTrashed()->find($id);

		if (! is_null($ticketMessage)) return $ticketMessage;

		throw new GeneralException('That ticketMessage does not exist.');
	}

	/**
	 * @param $per_page
	 * @param string $order_by
	 * @param string $sort
	 * @return mixed
	 */
	public function getTicketMessagesPaginated($per_page, $order_by = 'id', $sort = 'asc') {
		return TicketMessage::orderBy($order_by, $sort)->paginate($per_page);
	}

	/**
	 * @param $per_page
	 * @return \Illuminate\Pagination\Paginator
	 */
	public function getDeletedTicketMessagesPaginated($per_page) {
		return TicketMessage::onlyTrashed()->paginate($per_page);
	}

	/**
	 * @param string $order_by
	 * @param string $sort
	 * @return mixed
	 */
	public function getAllTicketMessages($ticket, $order_by = 'created_at', $sort = 'asc') {
		return TicketMessage::where('ticket_id', '=', $ticket)->orderBy($order_by, $sort)->get();
	}

    /**
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function create($input) {
        $ticketMessage = $this->createTicketMessageStub($input);
        if($ticketMessage->save()) {
            return $ticketMessage;
        }
        throw new GeneralException('There was a problem creating this ticketMessage. Please try again.');
    }

    /**
     * @param $id
     * @param $input
     * @param $admins
     * @return bool
     * @throws GeneralException
     */
    public function update($id, $input, $admins) {
        throw new GeneralException('There was a problem updating this ticketMessage. Please try again.');
    }


    /**
     * @param $id
     * @return bool
     * @throws GeneralException
     */
    public function destroy($id) {
        $ticketMessage = $this->findOrThrowException($id);

        if (Carbon::parse($ticketMessage->created_at)->addMinutes(15) < Carbon::now()){
            throw new GeneralException('Após 15 minutos, a mensagem não pode ser mais apagada.');
        }

        if ($ticketMessage->delete())
            return true;

        throw new GeneralException("There was a problem deleting this ticketMessage. Please try again.");
    }

    /**
     * @param $input
     * @return mixed
     */
    private function createTicketMessageStub($input)
    {
        $ticketMessage = new TicketMessage;
        $ticketMessage->message = $input['message'];
        $ticketMessage->ticket_id = $input['ticket_id'];
        $ticketMessage->user_id = auth()->id();
        $ticketMessage->created_at = Carbon::now();
        $ticketMessage->updated_at = Carbon::now();
        return $ticketMessage;
    }

}