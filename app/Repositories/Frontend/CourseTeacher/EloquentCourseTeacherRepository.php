<?php namespace App\Repositories\Frontend\CourseTeacher;

use App\CourseTeacher;
use App\Exceptions\GeneralException;
use App\Repositories\Backend\Tag\TagContract;

/**
 * Class EloquentCourseTeacherRepository
 * @package App\Repositories\CourseTeacher
 */
class EloquentCourseTeacherRepository implements CourseTeacherContract {


	public function __construct(TagContract $tags) {
        $this->tags = $tags;
	}

	/**
	 * @param $id
	 * @return mixed
	 * @throws GeneralException
	 */
	public function findOrThrowException($id) {
		$courseTeacher = CourseTeacher::withTrashed()->find($id);

		if (! is_null($courseTeacher)) return $courseTeacher;

		throw new GeneralException('That courseTeacher does not exist.');
	}

	/**
	 * @param $per_page
	 * @param string $order_by
	 * @param string $sort
	 * @return mixed
	 */
	public function getCourseTeachersPaginated($per_page, $order_by = 'id', $sort = 'asc') {
		return CourseTeacher::orderBy($order_by, $sort)->paginate($per_page);
	}

	/**
	 * @param $per_page
	 * @return \Illuminate\Pagination\Paginator
	 */
	public function getDeletedCourseTeachersPaginated($per_page) {
		return CourseTeacher::onlyTrashed()->paginate($per_page);
	}

	/**
	 * @param string $order_by
	 * @param string $sort
	 * @return mixed
	 */
	public function getAllCourseTeachers($order_by = 'id', $sort = 'asc') {
		return CourseTeacher::orderBy($order_by, $sort)->get();
	}

    public function getAllCourseTeachersPerCourse($course, $order_by = 'id', $sort = 'asc') {
        return CourseTeacher::where('course_id', '=', $course)->orderBy($order_by, $sort)->get();
    }

    public function getAllCourseTeachersPerTeacher($teacher) {
        $query = CourseTeacher::select('course_teachers.*');
        $query->join('courses', 'courses.id', '=', 'course_teachers.course_id');
        $query->where('courses.is_active', '=', 1);
        return  $query->where('course_teachers.teacher_id', '=', $teacher)->orderBy("courses.orders_count", "desc")->get();
    }


    /**
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function create($input) {
        if ((isset($input['tags'])) && ($input['tags'] > 0)) {
            $this->tags->createIfNew($input['tags']);
        }

        $courseTeacher = $this->createCourseTeacherStub($input);
        if($courseTeacher->save())
            return $courseTeacher;
        throw new GeneralException('There was a problem creating this courseTeacher. Please try again.');
    }

    /**
     * @param $id
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function update($id, $input) {
        $courseTeacher = $this->findOrThrowException($id);

        if ((isset($input['tags'])) && ($input['tags'] > 0)) {
            $this->tags->createIfNew($input['tags']);
        }
        if(isset($input['tags'])) $input['tags'] = implode(';', $input['tags']);

        if ($courseTeacher->update($input)) {



            $courseTeacher->save();

            return $courseTeacher;
        }

        throw new GeneralException('There was a problem updating this courseTeacher. Please try again.');
    }

    /**
     * @param $id
     * @param $new_file_name
     * @return bool
     * @throws GeneralException
     */
    public function updateImg($id, $new_file_name) {
        $courseTeacher = $this->findOrThrowException($id);
        $courseTeacher->featured_img  = $new_file_name;
        if($courseTeacher->save())
            return true;

        throw new GeneralException('There was a problem updating this article. Please try again.');
    }

    /**
     * @param $id
     * @return bool
     * @throws GeneralException
     */
    public function destroy($id) {
        $courseTeacher = $this->findOrThrowException($id);
        if ($courseTeacher->delete())
            return true;

        throw new GeneralException("There was a problem deleting this courseTeacher. Please try again.");
    }

    /**
     * @param $input
     * @return mixed
     */
    private function createCourseTeacherStub($input)
    {
        $courseTeacher = new CourseTeacher;
        return $courseTeacher;
    }

}