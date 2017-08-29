<?php namespace App\Repositories\Backend\User;

use App\Repositories\Backend\Role\EloquentRoleRepository;
use App\Services\Access\Traits\UserTeachersAttributes;
use App\User;
use App\Repositories\Frontend\Auth\AuthenticationContract;
use App\Exceptions\GeneralException;
use App\Repositories\Backend\Role\RoleRepositoryContract;
use App\Repositories\Backend\Tag\TagContract;
use App\Exceptions\Backend\Access\User\UserNeedsRolesException;

/**
 * Class EloquentUserRepository
 * @package App\Repositories\User
 */
class EloquentUserTeacherRepository implements UserTeacherContract {

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
	public function __construct(RoleRepositoryContract $role, AuthenticationContract $auth, TagContract $tags) {
		$this->role = $role;
		$this->auth = $auth;
		$this->tags = $tags;
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
	 * @param $paginate
	 * @param string $order_by
	 * @param string $sort
	 * @param int $status
	 * @return mixed
	 */
	public function getUserTeachersPaginated($per_page, $f_UserTeacherController_name, $f_UserTeacherController_desactived, $paginate = true, $status = 1, $order_by = 'id', $sort = 'asc') {

		$query = User::teachers();
		if(isset($f_UserTeacherController_desactived) && !empty($f_UserTeacherController_desactived)){
			$query->where('confirmed', '=', '0');
		}else{
			$query->where('confirmed', '=', '1');
		}

		if($paginate == true){
			return $query->where('name', 'like', '%'.$f_UserTeacherController_name.'%')->orderBy($order_by, $sort)->paginate($per_page);
		}
		return $query->where('name', 'like', '%'.$f_UserTeacherController_name.'%')->orderBy($order_by, $sort)->get();
	}

	/**
	 * @param $per_page
	 * @return \Illuminate\Pagination\Paginator
	 */
	public function getDeletedUserTeachersPaginated($per_page) {
		return User::onlyTrashed()->paginate($per_page);
	}

	/**
	 * @param string $order_by
	 * @param string $sort
	 * @return mixed
	 */
	public function getAllUserTeachers($order_by = 'name', $sort = 'asc') {
		return User::teachers()->orderBy($order_by, $sort)->get();
	}

	/**
	 * @param $input
	 * @param $roles
	 * @param $permissions
	 * @return bool
	 * @throws GeneralException
	 * @throws UserNeedsRolesException
	 */
	public function create($input) {
		if ((isset($input['tags'])) && ($input['tags'] > 0)) {
			$this->tags->createIfNew($input['tags']);
		}

		$user = $this->createUserStub($input);

		if ($user->save()) {
			//Attach new roles

			$role = (new EloquentRoleRepository())->findOrThrowException(2);
			$user->attachRole( $role );

			return $user->id;
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
		$this->checkUserTeacherByEmail($input, $user);

		$input['cel'] = preg_replace('/\D/', '', $input['cel']);

		if ((isset($input['tags'])) && ($input['tags'] > 0)) {
			$this->tags->createIfNew($input['tags']);
		}
		if(isset($input['tags'])) $input['tags'] = implode(';', $input['tags']);

		if ($user->update($input)) {
			//For whatever reason this just wont work in the above call, so a second is needed for now
			$user->birthdate   = parsebr($input['birthdate']);
			$user->city_id   = $input['city_id'];
			$user->status = isset($input['status']) ? 1 : 0;
			$user->confirmed = isset($input['confirmed']) ? 1 : 0;
			$user->list_on_site = isset($input['list_on_site']) ? 1 : 0;
			$user->featured = isset($input['featured']) ? 1 : 0;
			$user->is_newsletter_subscriber = isset($input['is_newsletter_subscriber']) ? 1 : 0;
			$user->has_children = isset($input['has_children']) ? 1 : 0;
			if(isset($input['tags'])) $user->tags = $input['tags'];
			if(isset($input['photo'])) $user->photo = $input['photo'];
			$user->meta_description = (isset($input['meta_description']) && !empty($input['meta_description'])) ? $input['meta_description'] : NULL;
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
	private function checkUserTeacherByEmail($input, $user)
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


	public function selectTeachers($term = '', $order_by = 'name', $sort = 'asc') {
		return User::teachers()->where('name', 'like', $term.'%')->orderBy($order_by, $sort)->get();
	}


	/**
	 * @param $input
	 * @return mixed
	 */
	private function createUserStub($input)
	{
		$user = new User;
		$user->name = $input['name'];
		$user->slug = $input['slug'];
		$user->email = $input['email'];
		$user->cel = $input['cel'];
		$user->birthdate   = parsebr($input['birthdate']);
		$user->personal_id = $input['personal_id'];
		$user->company_id = $input['company_id'];
		$user->professional_number = $input['professional_number'];
		$user->zip = $input['zip'];
		$user->city_id = $input['city_id'];
		$user->address = $input['address'];
		$user->is_newsletter_subscriber = isset($input['is_newsletter_subscriber']) ? 1 : 0;
		$user->has_children = isset($input['has_children']) ? 1 : 0;
		$user->linkcv = $input['linkcv'];
		$user->resume = $input['resume'];
		$user->educational_title = $input['educational_title'];
		$user->bank = $input['bank'];
		$user->agency = $input['agency'];
		$user->account = $input['account'];
		$user->password = $input['password'];

		$user->youtube = $input['youtube'];
		$user->facebook = $input['facebook'];
		$user->instagram = $input['instagram'];
		$user->twitter = $input['twitter'];
		$user->linkedin = $input['linkedin'];
		$user->jusbrasil = $input['jusbrasil'];
		$user->periscope = $input['periscope'];

		$user->status = isset($input['status']) ? 1 : 0;
		$user->confirmation_code = md5(uniqid(mt_rand(), true));
		$user->confirmed = isset($input['confirmed']) ? 1 : 0;
		$user->list_on_site = isset($input['list_on_site']) ? 1 : 0;
		$user->featured = isset($input['featured']) ? 1 : 0;
		if(isset($input['tags'])) $user->tags = implode(';', $input['tags']);
		if(isset($input['photo'])) $user->photo = $input['photo'];

		$user->meta_description = (isset($input['meta_description']) && !empty($input['meta_description'])) ? $input['meta_description'] : NULL;
		return $user;
	}

	/**
	 * @param $id
	 * @param $new_file_name
	 * @return bool
	 * @throws GeneralException
	 */
	public function updatePhoto($id, $new_file_name) {
		$user = $this->findOrThrowException($id);
		$user->photo = $new_file_name;
		if($user->save())
			return true;

		throw new GeneralException('There was a problem updating this article. Please try again.');
	}
}