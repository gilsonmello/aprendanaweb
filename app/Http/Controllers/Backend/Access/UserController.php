<?php namespace App\Http\Controllers\Backend\Access;

use App\Http\Controllers\Controller;
use App\Repositories\Backend\User\UserContract;
use App\Repositories\Backend\Role\RoleRepositoryContract;
use App\Repositories\Backend\Permission\PermissionRepositoryContract;
use App\Http\Requests\Backend\Access\User\CreateUserRequest;
use App\Http\Requests\Backend\Access\User\UpdateUserRequest;
use App\Http\Requests\Backend\Access\User\UpdateUserPasswordRequest;
use App\Repositories\Frontend\Auth\AuthenticationContract;
use Illuminate\Http\Request;
use Matriphe\Imageupload\Imageupload;
use App\User;
use App\Course;
use App\Video;

/**
 * Class UserController
 */
class UserController extends Controller {

	/**
	 * @var UserContract
	 */
	protected $users;
	/**
	 * @var RoleRepositoryContract
	 */
	protected $roles;

	/**
	 * @var PermissionRepositoryContract
	 */
	protected $permissions;

	/**
	 * @param UserContract $users
	 * @param RoleRepositoryContract $roles
	 * @param PermissionRepositoryContract $permissions
	 */
	public function __construct(
		UserContract $users,
		RoleRepositoryContract $roles,
		PermissionRepositoryContract $permissions, Imageupload $upload) {
		$this->users = $users;
		$this->roles = $roles;
		$this->permissions = $permissions;
		$this->upload = $upload;
	}

	/**
	 * @return mixed
	 */
	public function index(Request $request) {
		$request->session()->put('lastpage', $request->only('page')['page']);


		$f_UserController_name = $request->input('f_UserController_name', '');
		$f_UserController_role = $request->input('f_UserController_role', '');
		$f_submit = $request->input('f_submit', '');
		if (($f_submit != '1') && ($f_UserController_name === '')){
			$f_UserController_name = $request->session()->get('f_UserController_name', '');
			$f_UserController_role = $request->session()->get('f_UserController_role', '');
		}
		$request->session()->put('f_UserController_name', $f_UserController_name );
		$request->session()->put('f_UserController_role', $f_UserController_role );


		return view('backend.access.index')
			->withUsers($this->users->getUsersPaginated(config('access.users.default_per_page'), $f_UserController_name, $f_UserController_role, 1))
			->withUsercontrollername($f_UserController_name)
			->withUsercontrollerrole($f_UserController_role);
	}

    /**
     * @return string
     */
    public function selectUser()
    {
        $users = $this->users->selectUsers( $_POST['term'] );

        $list = [];
        foreach ($users as $user) {
            $list[] = ['id' => $user->id, 'text' => $user->name];
        }

        return json_encode($list);
    }

	/**
	 * @return mixed
	 */
	public function create() {
		return view('backend.access.create')
			->withRoles($this->roles->getAllRoles('id', 'asc', true))
			->withPermissions($this->permissions->getPermissionsNotAssociatedWithRole());
	}

	/**
	 * @param CreateUserRequest $request
	 * @return mixed
	 */
	public function store(CreateUserRequest $request) {
		$id_incremented = $this->users->create(
			$request->except('assignees_roles', 'permission_user'),
			$request->only('assignees_roles'),
			$request->only('permission_user')
		);

		if ($request->hasFile('photo')){
			$new_file_name = $request['name'] . '_' . str_random(4);

			$imgResult = $this->upload->upload($request->file('photo'), $new_file_name, '/users/'.$id_incremented);
			if(!isset($imgResult['error'])) $this->users->updatePhoto($id_incremented, $imgResult['filename']);

		}

		return redirect()->route('admin.access.users.index')->withFlashSuccess(trans("alerts.users.created"));
	}

	/**
	 * @param $id
	 * @return mixed
	 */
	public function edit($id) {
		$user = $this->users->findOrThrowException($id, true);

		$photooriginal = imageurl("users/", $id, $user->photo);
		$photoresize = imageurl("users/", $id, $user->photo, 50);

		return view('backend.access.edit')
			->withUser($user)
			->withUserRoles($user->roles->lists('id')->all())
			->withRoles($this->roles->getAllRoles('id', 'asc', true))
			->withUserPermissions($user->permissions->lists('id')->all())
			->withPermissions($this->permissions->getPermissionsNotAssociatedWithRole())
			->withPhotooriginal($photooriginal)
			->withPhotoresize($photoresize);
	}

	/**
	 * @param $id
	 * @param UpdateUserRequest $request
	 * @return mixed
	 */
	public function update($id, UpdateUserRequest $request) {
		$this->users->update($id,
			$request->except('assignees_roles', 'permission_user'),
			$request->only('assignees_roles'),
			$request->only('permission_user')
		);

		if ($request->hasFile('photo')){
			$new_file_name = $request['name'] . '_' . str_random(4);

			$imgResult = $this->upload->upload($request->file('photo'), $new_file_name, '/users/'.$id);
			if(!isset($imgResult['error'])) $this->users->updatePhoto($id, $imgResult['filename']);
		}

		return redirect()->route('admin.access.users.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.users.updated"));
	}

	/**
	 * @param $id
	 * @return mixed
	 */
	public function destroy($id) {
		$this->users->destroy($id);
		return redirect()->back()->withFlashSuccess(trans("alerts.users.deleted"));
	}

	/**
	 * @param $id
	 * @return mixed
	 */
	public function delete($id) {
		$this->users->delete($id);
		return redirect()->back()->withFlashSuccess(trans("alerts.users.deleted_permanently"));
	}

	/**
	 * @param $id
	 * @return mixed
	 */
	public function restore($id) {
		$this->users->restore($id);
		return redirect()->back()->withFlashSuccess(trans("alerts.users.restored"));
	}

	/**
	 * @param $id
	 * @param $status
	 * @return mixed
	 */
	public function mark($id, $status) {
		$this->users->mark($id, $status);
		return redirect()->back()->withFlashSuccess(trans("alerts.users.updated"));
	}

	/**
	 * @return mixed
	 */
	public function deactivated() {
		return view('backend.access.deactivated')
			->withUsers($this->users->getUsersPaginated(25, '', '', 0));
	}

	/**
	 * @return mixed
	 */
	public function deleted() {
		return view('backend.access.deleted')
			->withUsers($this->users->getDeletedUsersPaginated(25, '', ''));
	}

	/**
	 * @return mixed
	 */
	public function banned() {
		return view('backend.access.banned')
			->withUsers($this->users->getUsersPaginated(25, '', '', 2));
	}

	/**
	 * @param $id
	 * @return mixed
	 */
	public function changePassword($id) {
		return view('backend.access.change-password')
			->withUser($this->users->findOrThrowException($id));
	}

	/**
	 * @param $id
	 * @param UpdateUserPasswordRequest $request
	 * @return mixed
	 */
	public function updatePassword($id, UpdateUserPasswordRequest $request) {
		$this->users->updatePassword($id, $request->all());
		return redirect()->route('admin.access.users.index')->withFlashSuccess(trans("alerts.users.updated_password"));
	}

	/**
	 * @param $user_id
	 * @param AuthenticationContract $auth
	 * @return mixed
	 */
	public function resendConfirmationEmail($user_id, AuthenticationContract $auth) {
		$auth->resendConfirmationEmail($user_id);
		return redirect()->back()->withFlashSuccess(trans("alerts.users.confirmation_email"));
	}

/*	public function importPhotos(){
		$users = User::where('id', '>', 200)->where('id', '<', 300)->get();
		foreach ($users as $user) {
			if (($user->photo != null) && ($user->photo !== '')) {
				if (!file_exists('C:/Users/adhemar/bj20/brasiljuridico/public/uploads/courses/' . $user->id)) {
					mkdir('C:/Users/adhemar/bj20/brasiljuridico/public/uploads/courses/' . $user->id, 0777, true);
				}
				copy('C:/Users/adhemar/bj20/brasiljuridico/public/uploads/tp/cursos/' . $user->photo,
					'C:/Users/adhemar/bj20/brasiljuridico/public/uploads/courses/' . $user->id . '/' . $user->photo);

				copy('C:/Users/adhemar/bj20/brasiljuridico/public/uploads/tp/cursos/' . $user->photo,
					'C:/Users/adhemar/bj20/brasiljuridico/public/uploads/courses/' . $user->id . '/' . substr( $user->photo, 0, -4 ) . '_size50' . substr( $user->photo, -4, 4 ));
				copy('C:/Users/adhemar/bj20/brasiljuridico/public/uploads/tp/cursos/' . $user->photo,
					'C:/Users/adhemar/bj20/brasiljuridico/public/uploads/courses/' . $user->id . '/' . substr( $user->photo, 0, -4 ) . '_size100' . substr( $user->photo, -4, 4 ));
				copy('C:/Users/adhemar/bj20/brasiljuridico/public/uploads/tp/cursos/' . $user->photo,
					'C:/Users/adhemar/bj20/brasiljuridico/public/uploads/courses/' . $user->id . '/' . substr( $user->photo, 0, -4 ) . '_size200' . substr( $user->photo, -4, 4 ));
				copy('C:/Users/adhemar/bj20/brasiljuridico/public/uploads/tp/cursos/' . $user->photo,
					'C:/Users/adhemar/bj20/brasiljuridico/public/uploads/courses/' . $user->id . '/' . substr( $user->photo, 0, -4 ) . '_size400' . substr( $user->photo, -4, 4 ));

				copy('C:/Users/adhemar/bj20/brasiljuridico/public/uploads/tp/cursos/' . $user->photo,
					'C:/Users/adhemar/bj20/brasiljuridico/public/uploads/courses/' . $user->id . '/' . substr( $user->photo, 0, -4 ) . '_square50' . substr( $user->photo, -4, 4 ));
				copy('C:/Users/adhemar/bj20/brasiljuridico/public/uploads/tp/cursos/' . $user->photo,
					'C:/Users/adhemar/bj20/brasiljuridico/public/uploads/courses/' . $user->id . '/' . substr( $user->photo, 0, -4 ) . '_square100' . substr( $user->photo, -4, 4 ));
				copy('C:/Users/adhemar/bj20/brasiljuridico/public/uploads/tp/cursos/' . $user->photo,
					'C:/Users/adhemar/bj20/brasiljuridico/public/uploads/courses/' . $user->id . '/' . substr( $user->photo, 0, -4 ) . '_square200' . substr( $user->photo, -4, 4 ));
				copy('C:/Users/adhemar/bj20/brasiljuridico/public/uploads/tp/cursos/' . $user->photo,
					'C:/Users/adhemar/bj20/brasiljuridico/public/uploads/courses/' . $user->id . '/' . substr( $user->photo, 0, -4 ) . '_square400' . substr( $user->photo, -4, 4 ));

			}
		}
	}*/

	/*public function importPhotos(){
		$courses = Course::get();
		foreach ($courses as $course) {
			if (($course->featured_img != null) && ($course->featured_img !== '')) {
				if (!file_exists('C:/Users/adhemar/bj20/brasiljuridico/public/uploads/courses/' . $course->id)) {
					mkdir('C:/Users/adhemar/bj20/brasiljuridico/public/uploads/courses/' . $course->id, 0777, true);
				}
				copy('C:/Users/adhemar/bj20/brasiljuridico/public/uploads/tp/cursos/' . $course->featured_img,
					'C:/Users/adhemar/bj20/brasiljuridico/public/uploads/courses/' . $course->id . '/' . $course->featured_img);

				copy('C:/Users/adhemar/bj20/brasiljuridico/public/uploads/tp/cursos/' . $course->featured_img,
					'C:/Users/adhemar/bj20/brasiljuridico/public/uploads/courses/' . $course->id . '/' . substr( $course->featured_img, 0, -4 ) . '_size50' . substr( $course->featured_img, -4, 4 ));
				copy('C:/Users/adhemar/bj20/brasiljuridico/public/uploads/tp/cursos/' . $course->featured_img,
					'C:/Users/adhemar/bj20/brasiljuridico/public/uploads/courses/' . $course->id . '/' . substr( $course->featured_img, 0, -4 ) . '_size100' . substr( $course->featured_img, -4, 4 ));
				copy('C:/Users/adhemar/bj20/brasiljuridico/public/uploads/tp/cursos/' . $course->featured_img,
					'C:/Users/adhemar/bj20/brasiljuridico/public/uploads/courses/' . $course->id . '/' . substr( $course->featured_img, 0, -4 ) . '_size200' . substr( $course->featured_img, -4, 4 ));
				copy('C:/Users/adhemar/bj20/brasiljuridico/public/uploads/tp/cursos/' . $course->featured_img,
					'C:/Users/adhemar/bj20/brasiljuridico/public/uploads/courses/' . $course->id . '/' . substr( $course->featured_img, 0, -4 ) . '_size400' . substr( $course->featured_img, -4, 4 ));

				copy('C:/Users/adhemar/bj20/brasiljuridico/public/uploads/tp/cursos/' . $course->featured_img,
					'C:/Users/adhemar/bj20/brasiljuridico/public/uploads/courses/' . $course->id . '/' . substr( $course->featured_img, 0, -4 ) . '_square50' . substr( $course->featured_img, -4, 4 ));
				copy('C:/Users/adhemar/bj20/brasiljuridico/public/uploads/tp/cursos/' . $course->featured_img,
					'C:/Users/adhemar/bj20/brasiljuridico/public/uploads/courses/' . $course->id . '/' . substr( $course->featured_img, 0, -4 ) . '_square100' . substr( $course->featured_img, -4, 4 ));
				copy('C:/Users/adhemar/bj20/brasiljuridico/public/uploads/tp/cursos/' . $course->featured_img,
					'C:/Users/adhemar/bj20/brasiljuridico/public/uploads/courses/' . $course->id . '/' . substr( $course->featured_img, 0, -4 ) . '_square200' . substr( $course->featured_img, -4, 4 ));
				copy('C:/Users/adhemar/bj20/brasiljuridico/public/uploads/tp/cursos/' . $course->featured_img,
					'C:/Users/adhemar/bj20/brasiljuridico/public/uploads/courses/' . $course->id . '/' . substr( $course->featured_img, 0, -4 ) . '_square400' . substr( $course->featured_img, -4, 4 ));

			}
		}
	}*/

	public function importPhotos(){
//		$videos = Video::get();
//		foreach ($videos as $video) {
//			if (($video->img != null) && ($video->img !== '')) {
//				if (!file_exists('C:/Users/adhemar/bj20/brasiljuridico/public/uploads/videos/' . $video->id)) {
//					mkdir('C:/Users/adhemar/bj20/brasiljuridico/public/uploads/videos/' . $video->id, 0777, true);
//				}
//				copy('C:/Users/adhemar/bj20/brasiljuridico/public/uploads/tp/videos/' . $video->img,
//					'C:/Users/adhemar/bj20/brasiljuridico/public/uploads/videos/' . $video->id . '/' . $video->img);
//
//				copy('C:/Users/adhemar/bj20/brasiljuridico/public/uploads/tp/videos/' . $video->img,
//					'C:/Users/adhemar/bj20/brasiljuridico/public/uploads/videos/' . $video->id . '/' . substr( $video->img, 0, -4 ) . '_size50' . substr( $video->img, -4, 4 ));
//				copy('C:/Users/adhemar/bj20/brasiljuridico/public/uploads/tp/videos/' . $video->img,
//					'C:/Users/adhemar/bj20/brasiljuridico/public/uploads/videos/' . $video->id . '/' . substr( $video->img, 0, -4 ) . '_size100' . substr( $video->img, -4, 4 ));
//				copy('C:/Users/adhemar/bj20/brasiljuridico/public/uploads/tp/videos/' . $video->img,
//					'C:/Users/adhemar/bj20/brasiljuridico/public/uploads/videos/' . $video->id . '/' . substr( $video->img, 0, -4 ) . '_size200' . substr( $video->img, -4, 4 ));
//				copy('C:/Users/adhemar/bj20/brasiljuridico/public/uploads/tp/videos/' . $video->img,
//					'C:/Users/adhemar/bj20/brasiljuridico/public/uploads/videos/' . $video->id . '/' . substr( $video->img, 0, -4 ) . '_size400' . substr( $video->img, -4, 4 ));
//
//				copy('C:/Users/adhemar/bj20/brasiljuridico/public/uploads/tp/videos/' . $video->img,
//					'C:/Users/adhemar/bj20/brasiljuridico/public/uploads/videos/' . $video->id . '/' . substr( $video->img, 0, -4 ) . '_square50' . substr( $video->img, -4, 4 ));
//				copy('C:/Users/adhemar/bj20/brasiljuridico/public/uploads/tp/videos/' . $video->img,
//					'C:/Users/adhemar/bj20/brasiljuridico/public/uploads/videos/' . $video->id . '/' . substr( $video->img, 0, -4 ) . '_square100' . substr( $video->img, -4, 4 ));
//				copy('C:/Users/adhemar/bj20/brasiljuridico/public/uploads/tp/videos/' . $video->img,
//					'C:/Users/adhemar/bj20/brasiljuridico/public/uploads/videos/' . $video->id . '/' . substr( $video->img, 0, -4 ) . '_square200' . substr( $video->img, -4, 4 ));
//				copy('C:/Users/adhemar/bj20/brasiljuridico/public/uploads/tp/videos/' . $video->img,
//					'C:/Users/adhemar/bj20/brasiljuridico/public/uploads/videos/' . $video->id . '/' . substr( $video->img, 0, -4 ) . '_square400' . substr( $video->img, -4, 4 ));
//
//			}
//		}
	}
}