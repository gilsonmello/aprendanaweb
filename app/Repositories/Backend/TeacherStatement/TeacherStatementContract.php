<?php namespace App\Repositories\Backend\TeacherStatement;

/**
 * Interface UserContract
 * @package App\Repositories\Article
 */
interface TeacherStatementContract {

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
    public function getTeacherStatementsPaginated($per_page, $order_by = 'id', $sort = 'asc');

    public function getTeacherStatementsWithBalancePaginated($per_page, $date_begin, $date_end, $user, $order_by = 'id', $sort = 'asc');

    public function getTeacherStatementsForPayment($date, $dateend = null);

    public function deleteTeacherStatementsFromOrder($datebegin, $dateend = null);

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAllTeacherStatements($order_by = 'id', $sort = 'asc');

    /**
     * @param $input
     * @return mixed
     */
    public function create($input, $user);

    /**
     * @param $id
     * @param $input
     * @return mixed
     */
    public function update($id, $input);

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id);


}