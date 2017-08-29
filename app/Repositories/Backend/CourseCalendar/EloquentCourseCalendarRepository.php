<?php namespace App\Repositories\Backend\CourseCalendar;

use App\Course;
use App\CourseCalendar;
use App\Exceptions\GeneralException;
use App\Repositories\Backend\CourseCalendar\CourseCalendarContract;
use App\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Collection;

/**
 * Class EloquentCourseCalendarRepository
 * @package App\Repositories\CourseCalendar
 */
class EloquentCourseCalendarRepository implements CourseCalendarContract {

    /**
     *
     * Função para enviar notificações de calendário dos cursos para os alunos
     * 
     **/
    public function getAndSendNotificationsCalendarCourse(){
        
        //Pegando todos os usuário
        $users = User::students()->select(
            'users.id as user_id',
            'users.name as user_name',
            'users.email as user_email'
        )->where('users.status', '=', 1)
        ->orderBy('name', 'asc')->get();
        
        //Agrupando as notificações do calendário por usuário
        foreach($users as $user){
            $user->courseCalendar = NULL;
            $query = CourseCalendar::select(
                'courses_calendars.*', 
                'courses.title AS course_title',
                'students.id AS student_id',
                'students.name AS student_name',
                'students.email AS student_email'
            )
            ->join('courses', 'courses.id', '=', 'courses_calendars.course_id')
            ->join('enrollments', 'enrollments.course_id', '=', 'courses.id')
            ->join('users AS students', 'students.id', '=', 'enrollments.student_id')
            ->where('students.id', '=', $user->user_id)
            ->where('courses_calendars.date', '=', date('Y-m-d'))
            ->where('enrollments.is_active', '=', 1)
            ->where('enrollments.date_end', '>=', date('Y-m-d'))
            ->get();
            if(count($query) != 0){
                $user->courseCalendar = $query;
            }
        }
        //Enviando e-mail para os usuário que tiverem notificação para ser enviada
        foreach($users as $user){
            if(!is_null($user->courseCalendar)){
                Mail::send('emails.course_calendar', [
                    'data' => $user->courseCalendar
                ], 
                function ($message) use ($user) {
                    $message->to($user->user_email, $user->user_name)
                    /*->cc([
                        'adhemarfontes@gmail.com'
                    ])*/
                    ->subject("Brasil Jurídico :: Calendário do(s) Curso(s)")
                    ->from("atendimento@brasiljuridico.com.br", app_name());
                });
            }
        }
    }


    /**
     * @param $id
     * @return mixed
     * @throws GeneralException
     */
    public function findOrThrowException($id) {
        $courseCalendar = CourseCalendar::withTrashed()->find($id);

        if (! is_null($courseCalendar)) return $courseCalendar;

        throw new GeneralException('That courseCalendar does not exist.');
    }

    /**
     * @param $per_page
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getCoursesCalendarsPaginated($per_page, $course_id, $order_by = 'date', $sort = 'desc') {
        $query = CourseCalendar::whereNotNull('id');
        if (isset($course_id) && $course_id != "")
            $query->where('course_id', '=', $course_id);
        return $query->orderBy($order_by, $sort)->paginate($per_page);
    }

    /**
     * @param $per_page
     * @return \Illuminate\Pagination\Paginator
     */
    public function getDeletedCoursesCalendarsPaginated($per_page) {
        return CourseCalendar::onlyTrashed()->paginate($per_page);
    }

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAllCoursesCalendars($order_by = 'id', $sort = 'asc') {
        return CourseCalendar::orderBy($order_by, $sort)->get();
    }

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAlloursesCalendarsPerUser($order_by = 'id', $sort = 'asc') {
        return CourseCalendar::select('courses_calendars.*',
            'students.name AS student_name',
            'students.email AS student_email',
            'courses.title AS course_title',
            'courses.id AS course_id'
        )
        ->join('courses', 'courses.id', '=', 'courses_calendars.course_id')
        ->join('enrollments', 'enrollments.course_id', '=', 'courses.id')
        ->join('users AS students', 'students.id', '=', 'enrollments.student_id')
        ->where('students.id', '=', Auth()->user()->id)
        ->where('courses_calendars.date', '=', date('Y-m-d'))
        ->get();
    }

    public function getAllCoursesCalendarsPerCourse($course, $order_by = 'date', $sort = 'desc') {
        $query = CourseCalendar::whereNotNull('id');
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
        $coupon = $this->createCourseCalendarStub($input);
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
        $courseCalendar = $this->findOrThrowException($id);

        if ($courseCalendar->update($input)) {
            $courseCalendar->date = parsebr($input['date']);
            $courseCalendar->save();
            return $courseCalendar;
        }

        throw new GeneralException('There was a problem updating this courseCalendar. Please try again.');
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
        $courseCalendar = $this->findOrThrowException($id);
        if ($courseCalendar->delete())
            return true;

        throw new GeneralException("There was a problem deleting this courseCalendar. Please try again.");
    }

    /**
     * @param $input
     * @return mixed
     */
    private function createCourseCalendarStub($input)
    {

        $courseCalendar = new CourseCalendar;
        $courseCalendar->description   = $input['description'];
        $courseCalendar->date = parsebr($input['date']);
        $courseCalendar->course_id = $input['course_id'];
        return $courseCalendar;
    }
}


