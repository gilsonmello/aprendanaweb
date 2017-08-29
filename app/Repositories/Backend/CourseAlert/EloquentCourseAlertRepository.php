<?php namespace App\Repositories\Backend\CourseAlert;

use App\Course;
use App\CourseAlert;
use App\Exceptions\GeneralException;
use App\Repositories\Backend\CourseAlert\CourseAlertContract;
use App\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Collection;

/**
 * Class EloquentCourseAlertRepository
 * @package App\Repositories\CourseAlert
 */
class EloquentCourseAlertRepository implements CourseAlertContract {


	/**
	 * @param $id
	 * @return mixed
	 * @throws GeneralException
	 */
	public function findOrThrowException($id) {
		$courseAlert = CourseAlert::withTrashed()->find($id);

		if (! is_null($courseAlert)) return $courseAlert;

		throw new GeneralException('That courseAlert does not exist.');
	}

	/**
	 * @param $per_page
	 * @param string $order_by
	 * @param string $sort
	 * @return mixed
	 */
	public function getCoursesAlertsPaginated($per_page, $course_id, $order_by = 'date', $sort = 'desc') {
        $query = CourseAlert::whereNotNull('id');
        if (isset($course_id) && $course_id != "")
            $query->where('course_id', '=', $course_id);
        return $query->orderBy($order_by, $sort)->paginate($per_page);
	}

	/**
	 * @param $per_page
	 * @return \Illuminate\Pagination\Paginator
	 */
	public function getDeletedCoursesAlertsPaginated($per_page) {
		return CourseAlert::onlyTrashed()->paginate($per_page);
	}

	/**
	 * @param string $order_by
	 * @param string $sort
	 * @return mixed
	 */
	public function getAllCoursesAlerts($order_by = 'id', $sort = 'asc') {
		return CourseAlert::orderBy($order_by, $sort)->get();
	}

    public function getAllCoursesAlertsPerCourse($course, $order_by = 'date', $sort = 'desc') {
        $query = CourseAlert::whereNotNull('id');
        if (isset($course) && $course != "")
            $query->where('course_id', '=', $course);
        return $query->orderBy($order_by, $sort)->get();
    }

    /**
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function create($input) {
        $coupon = $this->createCourseAlertStub($input);
        if($coupon->save()) {
            return true;
        }
        throw new GeneralException('There was a problem creating this coupon. Please try again.');
    }

    /**
     * @param $id
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function update($id, $input){
        $courseAlert = $this->findOrThrowException($id);

        if ($courseAlert->update($input)) {
            $courseAlert->date = parsebr($input['date']);
            if ($input['course_id'] === '' ){
                $courseAlert->course_id = null;
            }
            $courseAlert->save();
            return $courseAlert;
        }

        throw new GeneralException('There was a problem updating this courseAlert. Please try again.');
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
        $courseAlert = $this->findOrThrowException($id);
        if ($courseAlert->delete())
            return true;

        throw new GeneralException("There was a problem deleting this courseAlert. Please try again.");
    }

    /**
     * @param $input
     * @return mixed
     */
    private function createCourseAlertStub($input)
    {

        $courseAlert = new CourseAlert;
        $courseAlert->description   = $input['description'];
        $courseAlert->date = parsebr($input['date']);
        $courseAlert->course_id = $input['course_id'];
        if ($input['course_id'] === '' ){
            $courseAlert->course_id = null;
        }
        return $courseAlert;
    }

    public function sendEmail($id){
        
        $results = CourseAlert::where('courses_alerts.id', '=', $id)
        ->join('courses', 'courses.id', '=', 'courses_alerts.course_id')
        ->join('enrollments', 'enrollments.course_id', '=', 'courses.id')
        ->join('users', 'users.id', '=', 'enrollments.student_id')
        ->where('enrollments.is_active', '=', 1)
        ->where('enrollments.date_end', '>=', date('Y-m-d H:i:s'))
        ->select('courses_alerts.description AS CoursesAlertsDescription',
            'courses_alerts.date AS CoursesAlertsDate',
            'courses.title AS CoursesTitle',
            'users.name AS UsersName',
            'users.email AS UsersEmail'
        );
        
        $collection = new Collection($results->get());
        
        if(!$collection->isEmpty()){
            foreach($collection as $courseAlert){
                Mail::send('emails.coursesalertsendemail', [
                        'courses_alerts_description' => $courseAlert->CoursesAlertsDescription, 
                        'courses_alerts_date' => format_br($courseAlert->CoursesAlertsDate, "d/m/Y H:i:s"), 
                        'course_title' => $courseAlert->CoursesTitle, 
                        'user_name' => $courseAlert->UsersName,
                        'user_email' => $courseAlert->UsersEmail
                    ], 
                function ($message) use ($courseAlert) {
                    $message->to($courseAlert->UsersEmail, $courseAlert->UsersName)
                    ->subject("Quadro de Avisos")
                    ->from("atendimento@brasiljuridico.com.br", app_name());
                });
            }
            return true;
        }

        return false;
    }
}