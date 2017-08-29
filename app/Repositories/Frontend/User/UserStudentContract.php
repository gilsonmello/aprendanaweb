<?php namespace App\Repositories\Frontend\User;

/**
 * Interface UserContract
 * @package App\Repositories\User
 */
interface UserStudentContract {

	/**
	 * @param $id
	 * @param bool $withRoles
	 * @return mixed
	 */
	public function findOrThrowException($id, $withRoles = false);

	/**
	 * @param $per_page
	 * @param string $order_by
	 * @param string $sort
	 * @param $status
	 * @return mixed
	 */
	public function getUserStudentsPaginated($per_page, $f_UserStudentController_name, $status = 1, $order_by = 'id', $sort = 'asc');

	/**
	 * @param $per_page
	 * @return \Illuminate\Pagination\Paginator
	 */
	public function getDeletedUserStudentsPaginated($per_page);

	/**
	 * @param string $order_by
	 * @param string $sort
	 * @return mixed
	 */
	public function getAllUserStudents($order_by = 'id', $sort = 'asc');

	/**
	 * @param $input
	 * @param $roles
	 * @return mixed
	 */
	public function create($input, $roles, $permissions);

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

	/**
	 * @param $id
	 * @param $input
	 * @return mixed
	 */
	public function updatePassword($id, $input);

	/**
	 * @param $id
	 * @param $input
	 * @return mixed
     */
	public function updateProfile($id, $input);

	/**
	 * @param $id
	 * @param $new_file_name
	 * @return mixed
     */
	public function updatePhoto($id, $new_file_name);

	public function getStudentByEmail($email);

	/**
	 * @param $id
	 * @param $input
	 * @param $roles
	 * @return mixed
	 */
	public function updateOccupation($id, $input);

}