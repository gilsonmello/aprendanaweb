<?php namespace App\Repositories\Backend\User;

/**
 * Interface UserContract
 * @package App\Repositories\User
 */
interface UserTeacherContract {

	/**
	 * @param $id
	 * @param bool $withRoles
	 * @return mixed
	 */
	public function findOrThrowException($id, $withRoles = false);

	/**
	 * @param $per_page
	 * @param $paginate
	 * @param string $order_by
	 * @param string $sort
	 * @param $status
	 * @return mixed
	 */
	public function getUserTeachersPaginated($per_page, $f_UserTeacherController_name, $f_UserTeacherController_desactived, $paginate = true, $status = 1, $order_by = 'id', $sort = 'asc');

	/**
	 * @param $per_page
	 * @return \Illuminate\Pagination\Paginator
	 */
	public function getDeletedUserTeachersPaginated($per_page);

	/**
	 * @param string $order_by
	 * @param string $sort
	 * @return mixed
	 */
	public function getAllUserTeachers($order_by = 'id', $sort = 'asc');

	/**
	 * @param $input
	 * @param $roles
	 * @return mixed
	 */
	public function create($input);

	/**
	 * @param $id
	 * @param $input
	 * @param $roles
	 * @return mixed
	 */
	public function update($id, $input);

	/**
	 * @param $id
	 * @return mixed
	 */
	public function destroy($id);

	/**
	 * @param $id
	 * @return mixed
	 */
	public function delete($id);

	/**
	 * @param $id
	 * @return mixed
	 */
	public function restore($id);

	/**
	 * @param $id
	 * @param $status
	 * @return mixed
	 */
	public function mark($id, $status);



	public function selectTeachers($term = '', $order_by = 'name', $sort = 'asc');
	/**
	 * @param $id
	 * @param $input
	 * @return mixed
	 */
	public function updatePassword($id, $input);
}