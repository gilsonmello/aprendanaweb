<?php namespace App\Repositories\Backend\Order;

/**
 * Interface UserContract
 * @package App\Repositories\Article
 */
interface OrderContract {

    /**
     * @param $id
     * @return mixed
     */
    public function findOrThrowException($id);

    /**
     * Função para deletar todos os pedidos de usuários do brasil jurídico
     *
     */
    public function deleteOrdersBrasilJuridico();

    /**
     * @param $per_page
     * @param $date_begin
     * @param $date_end
     * @param $id
     * @param $status
     * @param $withUser
     * @param $withoutEnrollment
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getOrdersPaginated($per_page, $date_begin, $date_end, $id, $status, $withUser, $withoutEnrollment, $only_paid, $order_by = 'id', $sort = 'asc');

    /**
     * @param string $date_begin
     * @param string $date_end
     * @param int $id
     * @param string $status
     * @param string $withoutEnrollment
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAllOrders($date_begin, $date_end, $id, $status, $withoutEnrollment, $order_by = 'id', $sort = 'asc');

    /**
     * @param string $date_begin
     * @param string $date_end
     * @return mixed
     */
    public function getOrdersForPayment($datebegin, $dateend = null);

    /**
     * @param int $user_id
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getOrdersStudent($user_id, $order_by = 'id', $sort = 'desc');

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
    public function update($id, $input);

    /**
     * @param $dataXml
     * @return mixed
     */
    public function updateFromPagseguroFeedback($dataXml);

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id);

    /**
     * @param $id
     * @return mixed
     */
    public function deactivated($id);

    /**
     * @param $id
     * @return mixed
     */
    public function activated($id);

}