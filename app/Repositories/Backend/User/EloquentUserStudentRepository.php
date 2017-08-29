<?php namespace App\Repositories\Backend\User;
use Carbon\Carbon;
use App\Services\Access\Traits\UserStudentsAttributes;
use App\User;
use App\Repositories\Frontend\Auth\AuthenticationContract;
use App\Exceptions\GeneralException;
use App\Repositories\Backend\Role\RoleRepositoryContract;
use App\Exceptions\Backend\Access\User\UserNeedsRolesException;
use Mail;

/**
 * Class EloquentUserRepository
 * @package App\Repositories\User
 */
class EloquentUserStudentRepository implements UserStudentContract {

	/**
	 * @var RoleRepositoryContract
	 */
	protected $role;

	/**
	 * @var AuthenticationContract
	 */
	protected $auth;

	/**
	 * @param RoleRepositoryContract $role
	 * @param AuthenticationContract $auth
	 */
	public function __construct(RoleRepositoryContract $role, AuthenticationContract $auth) {
		$this->role = $role;
		$this->auth = $auth;
	}

	public function birthday(){
		return User::whereMonth('birthdate', '=', Carbon::now()->month)
				->whereDay('birthdate', '=', Carbon::now()->day)
				->whereDate('birthdate', '!=', "1990-01-01")
				->get();
	}

	public function sendEmail($users){
		foreach($users as $user){
			Mail::send('emails.usersendemail', [	'name' => $user->name,
	                                            	'email' => $user->email
	                                            ], function($message) use ($user)
	        {
	            $message->to('junnyorr.sirnandes@gmail.com', "Gilson de Melo");
	            $message->subject('Teste');
	        });
		}
	}

	/**
	 * @param $id
	 * @param bool $withRoles
	 * @return mixed
	 * @throws GeneralException
	 */
	public function findOrThrowException($id, $withRoles = false) {
		if ($withRoles)
			$user = User::with('roles')->withTrashed()->find($id);
		else
			$user = User::withTrashed()->find($id);

		if (! is_null($user)) return $user;

		throw new GeneralException('That user does not exist.');
	}

	/**
	 * @param $per_page
	 * @param string $order_by
	 * @param string $sort
	 * @param int $status
	 * @return mixed
	 */
	public function getUserStudentsPaginated($per_page, $f_UserStudentController_name, $status = 1, $order_by = 'id', $sort = 'asc') {
		return User::students()->where( function($query) use ($f_UserStudentController_name) {
			$query->where('name', 'like', '%' . $f_UserStudentController_name . '%')
				->orWhere('email', 'like', '%' . $f_UserStudentController_name . '%');
			})
			->orderBy($order_by, $sort)->paginate($per_page);
	}

	/**
	 * @param $per_page
	 * @return \Illuminate\Pagination\Paginator
	 */
	public function getDeletedUserStudentsPaginated($per_page) {
		return User::onlyTrashed()->paginate($per_page);
	}

	/**
	 * @param string $order_by
	 * @param string $sort
	 * @return mixed
	 */
	public function getAllUserStudents($order_by = 'id', $sort = 'asc') {
		return User::orderBy($order_by, $sort)->get();
	}

	/**
	 * @param $input
	 * @param $roles
	 * @param $permissions
	 * @return bool
	 * @throws GeneralException
	 * @throws UserNeedsRolesException
	 */
	public function create($input, $roles, $permissions) {
		$user = $this->createUserStub($input);

		if ($user->save()) {
			//User Created, Validate Roles
			$this->validateRoleAmount($user, $roles['assignees_roles']);

			//Attach new roles
			$user->attachRoles($roles['assignees_roles']);

			//Attach other permissions
			$user->attachPermissions($permissions['permission_user']);

			//Send confirmation email if requested
			if (isset($input['confirmation_email']) && $user->confirmed == 0)
				$this->auth->resendConfirmationEmail($user->id);

			return true;
		}

		throw new GeneralException('There was a problem creating this user. Please try again.');
	}

	/**
	 * @param $id
	 * @param $input
	 * @param $roles
	 * @return bool
	 * @throws GeneralException
	 */
	public function update($id, $input) {
		$user = $this->findOrThrowException($id);
		$this->checkUserStudentByEmail($input, $user);

		$input['cel'] = preg_replace('/\D/', '', $input['cel']);

		if ($user->update($input)) {
			//For whatever reason this just wont work in the above call, so a second is needed for now
			$user->birthdate   = parsebr($input['birthdate']);
			$user->status = isset($input['status']) ? 1 : 0;
			$user->confirmed = isset($input['confirmed']) ? 1 : 0;
			$user->is_newsletter_subscriber = isset($input['is_newsletter_subscriber']) ? 1 : 0;
			$user->save();

			return true;
		}

		throw new GeneralException('There was a problem updating this user. Please try again.');
	}

	/**
	 * @param $id
	 * @param $input
	 * @return bool
	 * @throws GeneralException
	 */
	public function updatePassword($id, $input) {
		$user = $this->findOrThrowException($id);

		//Passwords are hashed on the model
		$user->password = $input['password'];
		if ($user->save())
			return true;

		throw new GeneralException('There was a problem changing this users password. Please try again.');
	}

	/**
	 * @param $id
	 * @return bool
	 * @throws GeneralException
	 */
	public function destroy($id) {
		if (auth()->id() == $id)
			throw new GeneralException("You can not delete yourself.");

		$user = $this->findOrThrowException($id);
		if ($user->delete())
			return true;

		throw new GeneralException("There was a problem deleting this user. Please try again.");
	}

	/**
	 * @param $id
	 * @return boolean|null
	 * @throws GeneralException
	 */
	public function delete($id) {
		$user = $this->findOrThrowException($id, true);

		//Detach all roles & permissions
		$user->detachRoles($user->roles);
		$user->detachPermissions($user->permissions);

		try {
			$user->forceDelete();
		} catch (\Exception $e) {
			throw new GeneralException($e->getMessage());
		}
	}

	/**
	 * @param $id
	 * @return bool
	 * @throws GeneralException
	 */
	public function restore($id) {
		$user = $this->findOrThrowException($id);

		if ($user->restore())
			return true;

		throw new GeneralException("There was a problem restoring this user. Please try again.");
	}

	/**
	 * @param $id
	 * @param $status
	 * @return bool
	 * @throws GeneralException
	 */
	public function mark($id, $status) {
		if (auth()->id() == $id && ($status == 0 || $status == 2))
			throw new GeneralException("You can not do that to yourself.");

		$user = $this->findOrThrowException($id);
		$user->status = $status;

		if ($user->save())
			return true;

		throw new GeneralException("There was a problem updating this user. Please try again.");
	}



	public function selectStudents($term = '', $order_by = 'name', $sort = 'asc') {


		return User::students()->where('name', 'like', $term.'%')->orderBy($order_by, $sort)->get();
	}

	/**
	 * Check to make sure at lease one role is being applied or deactivate user
	 * @param $user
	 * @param $roles
	 * @throws UserNeedsRolesException
	 */
	private function validateRoleAmount($user, $roles) {
		//Validate that there's at least one role chosen, placing this here so
		//at lease the user can be updated first, if this fails the roles will be
		//kept the same as before the user was updated
		if (count($roles) == 0) {
			//Deactivate user
			$user->status = 0;
			$user->save();

			$exception = new UserNeedsRolesException();
			$exception->setValidationErrors('You must choose at lease one role. User has been created but deactivated.');

			//Grab the user id in the controller
			$exception->setUserID($user->id);
			throw $exception;
		}
	}

	/**
	 * @param $input
	 * @param $user
	 * @throws GeneralException
	 */
	private function checkUserStudentByEmail($input, $user)
	{
		//Figure out if email is not the same
		if ($user->email != $input['email'])
		{
			//Check to see if email exists
			if (User::where('email', '=', $input['email'])->first())
				throw new GeneralException('That email address belongs to a different user.');
		}
	}

	/**
	 * @param $roles
	 * @param $user
	 */
	private function flushRoles($roles, $user)
	{
		//Flush roles out, then add array of new ones
		$user->detachRoles($user->roles);
		$user->attachRoles($roles['assignees_roles']);
	}

	/**
	 * @param $permissions
	 * @param $user
	 */
	private function flushPermissions($permissions, $user)
	{
		//Flush permissions out, then add array of new ones if any
		$user->detachPermissions($user->permissions);
		if (count($permissions['permission_user']) > 0)
			$user->attachPermissions($permissions['permission_user']);
	}

	/**
	 * @param $roles
	 * @throws GeneralException
	 */
	private function checkUserRolesCount($roles)
	{
		//User Updated, Update Roles
		//Validate that there's at least one role chosen
		if (count($roles['assignees_roles']) == 0)
			throw new GeneralException('You must choose at least one role.');
	}

	/**
	 * @param $input
	 * @return mixed
	 */
	private function createUserStub($input)
	{
		$user = new User;
		$user->name = $input['name'];
		$user->email = $input['email'];
		$user->password = $input['password'];
		$user->cel = $input['cel'];
		$user->birthdate   = parsebr($input['date']);
		$user->personal_id = $input['personal_id'];
		$user->professional_number = $input['professional_number'];
		$user->zip = $input['zip'];
		$user->city_id = $input['city_id'];
		$user->address = $input['address'];
		$user->is_newsletter_subscriber = isset($input['is_newsletter_subscriber']) ? 1 : 0;
		$user->status = isset($input['status']) ? 1 : 0;
		$user->confirmation_code = md5(uniqid(mt_rand(), true));
		$user->confirmed = isset($input['confirmed']) ? 1 : 0;
		return $user;
	}
}