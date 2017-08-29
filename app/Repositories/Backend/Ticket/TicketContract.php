<?php namespace App\Repositories\Backend\Ticket;

/**
 * Interface UserContract
 * @package App\Repositories\Ticket
 */
interface TicketContract {

    /**
     * @param $id
     * @return mixed
     */
    public function findOrThrowException($id);

    /**
     * @param $per_page
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getTicketsPaginated($per_page, $id, $date_begin, $date_end, $dead_line_begin, $dead_line_end, $is_replied, $is_finished, $sector_id = null, $order_by = 'id', $sort = 'asc');

    public function getTicketsStudentPaginated($per_page, $user_id, $order_by = 'id', $sort = 'asc');

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAllTickets($order_by = 'id', $sort = 'asc');

    /**
     * @param $input
     * @return mixed
     */
    public function create($input);

    /**
     * @param $id
     * @param $input
     * @return mixed
     */
    public function update($id, $input, $teachers);

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id);

    /**
     * @param $id
     * @param $input
     * @return mixed
     */
    public function answered($input, $messageTicket);

    /**
     * @param $id
     * @param $input
     * @return mixed
     */
    public function notAnswered($input, $messageTicket);

    /**
     * @param $id
     * @param $input
     * @return mixed
     */
    public function finish($input);

    /**
     * @param $input
     * @return mixed
     */
    public function createTicket($sector_id, $message, $content_id, $enrollment_id);

}