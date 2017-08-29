<?php namespace App\Repositories\Frontend\User;

use App\User;
use App\Course;
use App\Repositories\Frontend\Auth\AuthenticationContract;
use App\Exceptions\GeneralException;
use Illuminate\Support\Collection;

/**
 * Class EloquentUserRepository
 * @package App\Repositories\User
 */
class EloquentUserTeacherRepository implements UserTeacherContract {

	/**
	 * @var AuthenticationContract
	 */
	protected $auth;

	/**
	 * @param AuthenticationContract $auth
	 */
	public function __construct(AuthenticationContract $auth) {
		$this->auth = $auth;
	}

	/**
	 * @param $id
	 * @return mixed
	 * @throws GeneralException
	 */
	public function findOrThrowException($id) {
        $user = User::withTrashed()->find($id);

		if (! is_null($user)) return $user;

		throw new GeneralException('That user does not exist.');
	}

	/**
	 * @param $per_page
	 * @param string $order_by
	 * @param string $sort
	 * @return mixed
	 */
	public function getUserTeachersPaginated($per_page, $search, $social, $order_by = 'name', $sort = 'asc') {

		$query = User::teachers();
		$query->where('list_on_site', '=', 1);
		if ((isset($search)) && ($search != '')) {
			$query->where('name', 'like', '%' . $search . '%');
			$query->orWhere('tags', 'like', '%' . $search . '%');
		}

		if ($social === 'instagram'){
			$query->whereNotNull('instagram');
			$query->where('instagram', 'not like', '');
		} else if ($social === 'youtube'){
			$query->whereNotNull('youtube');
			$query->where('youtube', 'not like', '');
		} else if ($social === 'facebook'){
			$query->whereNotNull('facebook');
			$query->where('facebook', 'not like', '');
		} else if ($social === 'linkedin'){
			$query->whereNotNull('linkedin');
			$query->where('linkedin', 'not like', '');
		} else if ($social === 'twitter'){
			$query->whereNotNull('twitter');
			$query->where('twitter', 'not like', '');
		} else if ($social === 'jusbrasil'){
			$query->whereNotNull('jusbrasil');
			$query->where('jusbrasil', 'not like', '');
		} else if ($social === 'periscope'){
			$query->whereNotNull('periscope');
			$query->where('periscope', 'not like', '');
		}

		return $query->orderBy($order_by, $sort)->paginate($per_page);
	}

	/**
	 * @param $per_page
	 * @param string $order_by
	 * @param string $sort
	 * @return mixed
	 */
	public function getUserTeachers($search, $social, $order_by = 'name', $sort = 'asc') {

		$query = User::teachers();
		if ((isset($search)) && ($search != '')) {
			if ( substr($search, 0, 1) === '"' ){
				$search = substr($search, 1, strlen($search) - 2);
			}
			$query->where('name', 'like', '%' . $search . '%');
			$query->orWhere('tags', 'like', '%' . $search . '%');
		}

		if ($social === 'instagram'){
			$query->whereNotNull('instagram');
			$query->where('instagram', 'not like', '');
		} else if ($social === 'youtube'){
			$query->whereNotNull('youtube');
			$query->where('youtube', 'not like', '');
		} else if ($social === 'facebook'){
			$query->whereNotNull('facebook');
			$query->where('facebook', 'not like', '');
		}

		return $query->orderBy($order_by, $sort)->get();
	}


	public function getOrderCount($id){
		return Course::
			join('course_teachers', 'courses.id', '=', 'course_teachers.course_id')
			->where('course_teachers.teacher_id', '=', $id)
			->sum('orders_count');
	}

	/**
	 * @param string $order_by
	 * @param string $sort
	 * @return mixed
	 */
	public function getAllUserTeachers($order_by = 'id', $sort = 'asc') {
		return User::orderBy($order_by, $sort)->get();
	}

	/**
	 * @param $slug
	 * @return mixed
	 * @throws GeneralException
	 */
	public function findBySlug($slug) {
		$user = User::where('slug', $slug)->first();
		if (! is_null($user)) return $user;
	}
}