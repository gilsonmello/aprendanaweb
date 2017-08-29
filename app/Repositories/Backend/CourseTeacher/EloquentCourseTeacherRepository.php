<?php namespace App\Repositories\Backend\CourseTeacher;

use App\Course;
use App\CourseTeacher;
use App\Exceptions\GeneralException;
use App\Repositories\Backend\CourseTeacher\CourseTeacherContract;
use App\User;

/**
 * Class EloquentCourseTeacherRepository
 * @package App\Repositories\CourseTeacher
 */
class EloquentCourseTeacherRepository implements CourseTeacherContract {


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

    public function findByCourseAndTeacher($course,$teacher){
        $courseTeacher = CourseTeacher::where('course_id',$course)->where('teacher_id',$teacher)->get()->first();

        if(! is_null($courseTeacher)) return $courseTeacher;
        else return null;

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

    /**
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function create($teacher,$course,$percentage) {

        $courseTeacher = $this->createCourseTeacherStub($percentage);
        $courseTeacher->teacher()->associate(User::find($teacher));
        $courseTeacher->course()->associate(Course::find($course));
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
    public function update($id, $percentage) {
        $courseTeacher = $this->findOrThrowException($id);


        if ($courseTeacher->update(['percentage' => $percentage])) {

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
    private function createCourseTeacherStub($percentage)
    {
        $courseTeacher = new CourseTeacher;
        $courseTeacher->percentage = $percentage;
        return $courseTeacher;
    }

    public function destroyByCourse($course_id)
    {
        $courseTeachers = CourseTeacher::where('course_id',$course_id);
        foreach($courseTeachers->get() as $courseTeacher){
            $courseTeacher->delete();
            }
            return true;

        throw new GeneralException("There was a problem deleting this courseTeacher. Please try again.");    }
}