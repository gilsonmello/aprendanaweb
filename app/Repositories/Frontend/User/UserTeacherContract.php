<?php namespace App\Repositories\Frontend\User;

/**
 * Interface UserContract
 * @package App\Repositories\User
 */
interface UserTeacherContract {

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
	public function getUserTeachersPaginated($per_page, $search, $social, $order_by = 'name', $sort = 'asc');

	public function getUserTeachers($search, $social, $order_by = 'name', $sort = 'asc');

	public function getOrderCount($id);

	/**
	 * @param string $order_by
	 * @param string $sort
	 * @return mixed
	 */
	public function getAllUserTeachers($order_by = 'id', $sort = 'asc');

}