<?php

namespace App\Repositories\Backend\Enrollment;

use App\Enrollment;
use App\Exam;
use App\Exceptions\GeneralException;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * Class EloquentEnrollmentRepository
 * @package App\Repositories\Enrollment
 */
class EloquentEnrollmentRepository implements EnrollmentContract {
//	public function __construct() {
//	}

    /**
     * Função que retorna todas as matrículas do curso que o coordenador logado tem acesso
     */
    public function getEnrollmentsForCoordinators($per_page, $nameOrEmail = '', $course_id = NULL, $date_begin = NULL, $date_end = NULL, $released_for_certification = NULL) {
        $select = 'enrollments.*, courses.id AS courses_id, courses.title AS courses_title, enrollments.id AS enrollments_id, students.id AS students_id, students.name AS students_name, students.email AS students_email';
        $query = Enrollment::query()
                ->join('courses', 'courses.id', '=', 'enrollments.course_id')
                ->join('users AS students', 'students.id', '=', 'enrollments.student_id')
                ->where('enrollments.is_active', '=', '1')
                ->whereDate('enrollments.date_begin', '<=', date('Y-m-d'))
                ->whereDate('enrollments.date_end', '>=', date('Y-m-d'));
        if(!access()->hasRole('Administrador')){
            $select .= ', coordinators.name AS coordinators_name, coordinators.email AS coordinators_email';
            $query->join('coordinators_courses', 'coordinators_courses.course_id', '=', 'courses.id')
                    ->join('users AS coordinators', 'coordinators.id', '=', 'coordinators_courses.coordinator_id')
                    ->where('coordinators.id', '=', auth()->user()->id);
        }
        $query->selectRaw($select);

        if (isset($nameOrEmail) && !empty($nameOrEmail)) {
            $query->where('students.name', 'like', '%' . $nameOrEmail . '%')
            ->orWhere('students.email', 'like', '%' . $nameOrEmail . '%');
        }
        
        if(isset($course_id) && !empty($course_id)){
            $query->where('courses.id', '=', $course_id);
        }
        
        if(isset($date_begin) && !empty($date_begin)){
            $query->where('enrollments.date_begin', '>=', parsebr($date_begin));
        }
        
        if(isset($date_end) && !empty($date_end)){
            $query->where('enrollments.date_end', '<=', parsebr($date_end));
        }
        
        if(isset($released_for_certification) && !empty($released_for_certification)){
            $query->whereNotNull('enrollments.certification_individual_date');
        }
        
        return $query->orderBy('enrollments.id', 'DESC')->paginate($per_page);
    }

    /**
     * @param $id
     * @return mixed
     * @throws GeneralException
     */
    public function findOrThrowException($id) {
        $enrollment = Enrollment::withTrashed()->find($id);

        if (!is_null($enrollment))
            return $enrollment;

        throw new GeneralException('That enrollments does not exist.');
    }

    public function getCoursesPerStudent($f_EnrollmentController_student_id, $order_by = 'id', $sort = 'asc') {
        return Enrollment::
                        where('student_id', '=', $f_EnrollmentController_student_id)
                        ->whereNotNull('course_id')
                        ->orderBy($order_by, $sort)->get();
    }

    public function getModulesPerStudent($f_EnrollmentController_student_id, $order_by = 'id', $sort = 'asc') {
        return Enrollment::
                        where('student_id', '=', $f_EnrollmentController_student_id)
                        ->whereNotNull('module_id')
                        ->orderBy($order_by, $sort)->get();
    }

    public function getLessonsPerStudent($f_EnrollmentController_student_id, $order_by = 'id', $sort = 'asc') {
        return Enrollment::
                        where('student_id', '=', $f_EnrollmentController_student_id)
                        ->whereNotNull('lesson_id')
                        ->orderBy($order_by, $sort)->get();
    }

    /**
     * @param $per_page
     * @return \Illuminate\Pagination\Paginator
     */
    public function getDeletedEnrollmentsPaginated($per_page) {
        return Enrollment::onlyTrashed()->paginate($per_page);
    }

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAllEnrollments($order_by = 'id', $sort = 'asc') {
        return Enrollment::orderBy($order_by, $sort)->get();
    }

    /**
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function create($input) {
        $enrollment = $this->createEnrollmentStub($input);
        if ($enrollment->save())
            return true;
        throw new GeneralException('There was a problem creating this enrollments. Please try again.');
    }

    /**
     * @param $id
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function update($id, $input) {
        $enrollment = $this->findOrThrowException($id);
        if(isset($input['release_for_certification']) && !empty($input['release_for_certification'])){
            $enrollment->certification_individual_date = $input['release_for_certification'];
            $enrollment->certification_individual_user_id = auth()->user()->id;
        }
        
        if ($enrollment->update($input)) {
            //$enrollment->email  = $input['email'];
            $enrollment->save();

            return true;
        }

        throw new GeneralException('There was a problem updating this enrollments. Please try again.');
    }
    
     /**
     * @param $id
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function updateReleaseForCertification($id, $input) {
        $enrollment = $this->findOrThrowException($id);
        $enrollment->certification_individual_date = date('Y-m-d H:i:s');
        $enrollment->certification_individual_user_id = auth()->user()->id;
        if($enrollment->saveOrFail()){
            return true;
        }
        throw new GeneralException('There was a problem updating this enrollments. Please try again.');
    }

    /**
     * @param $id
     * @return bool
     * @throws GeneralException
     */
    public function destroy($id) {
        $enrollment = $this->findOrThrowException($id);
        if ($enrollment->delete())
            return true;

        throw new GeneralException("There was a problem deleting this enrollments. Please try again.");
    }

    /**
     * @param $input
     * @return mixed
     */
    private function createEnrollmentStub($input) {
        $enrollment = new Enrollment;
        //$enrollment->email  = $input['email'];
        return $enrollment;
    }

    public function deactivated($id) {
        $enrollment = $this->findOrThrowException($id);
        $enrollment->is_active = 0;
        //$enrollment->user_moderator_id  =  auth()->user()->id;
        $enrollment->save();
        return true;

        throw new GeneralException('There was a problem updating this tag. Please try again.');
    }

    public function activated($id) {
        $enrollment = $this->findOrThrowException($id);
        $enrollment->is_active = 1;
        //$enrollment->user_moderator_id  =  auth()->user()->id;
        $enrollment->save();
        return true;

        throw new GeneralException('There was a problem updating this tag. Please try again.');
    }

    public function getExamsPerStudent($f_EnrollmentController_student_id, $order_by = 'id', $sort = 'asc') {
        return Enrollment::
                        where('student_id', '=', $f_EnrollmentController_student_id)
                        ->whereNotNull('exam_id')
                        ->orderBy($order_by, $sort)->get();
    }

    public function getAllEnrollmentWithCoupon($f_EnrollmentController_coupon, $f_EnrollmentController_date_begin, $f_EnrollmentController_date_end, $order_by = 'desc', $sort = 'asc') {
        $query = Enrollment::join('orders', 'orders.id', '=', 'enrollments.order_id')
                ->join('coupons', 'coupons.id', '=', 'orders.coupon_id')
                ->join('users', 'users.id', '=', 'enrollments.student_id')
                ->join('cities', 'cities.id', '=', 'users.city_id')
                ->join('states', 'states.id', '=', 'cities.state_id');

//        (strpos($f_EnrollmentController_date_begin, "__/__/____") >= 0) ? "" : $f_EnrollmentController_date_begin; 
//        (strpos($f_EnrollmentController_date_end, "__/__/____") >= 0) ? "" : $f_EnrollmentController_date_end; 
//        
//        if(!empty($f_EnrollmentController_date_begin) && empty($f_EnrollmentController_date_end)){
//            $f_EnrollmentController_date_begin = implode("-", array_reverse(explode("/", $f_EnrollmentController_date_begin))). ' 00:00:00';
//            $query->where('enrollments.created_at', '<=', $f_EnrollmentController_date_begin);
//        }else if(!empty($f_EnrollmentController_date_begin) && !empty($f_EnrollmentController_date_end)){
//            $f_EnrollmentController_date_begin = implode("-", array_reverse(explode("/", $f_EnrollmentController_date_begin))). ' 00:00:00';
//            $f_EnrollmentController_date_end = implode("-", array_reverse(explode("/", $f_EnrollmentController_date_end))). ' 23:59:59';
//            //dd($f_EnrollmentController_date_begin, $f_EnrollmentController_date_end);
//            $query->whereBetween('enrollments.created_at', [$f_EnrollmentController_date_begin, $f_EnrollmentController_date_end]);
//        }else if(empty($f_EnrollmentController_date_begin) && !empty($f_EnrollmentController_date_end)){
//            $f_EnrollmentController_date_end = implode("-", array_reverse(explode("/", $f_EnrollmentController_date_end))).' 23:59:59';
//            //$f_EnrollmentController_date_end = $f_EnrollmentController_date_end.;
//            $query->where('enrollments.created_at', '>=', $f_EnrollmentController_date_end);
//        }
        return $query->select(
                                DB::raw('DISTINCT(enrollments.student_id)'), 'coupons.code AS Code', 'orders.id as OrderId', 'orders.status_id as OrderStatus', 'orders.created_at as OrderCreated', 'users.name AS UserName', 'users.address AS UserAddress', 'users.neighborhood AS UserNeighborhood', 'states.name AS UF'
                        )
                        ->where('orders.status_id', '=', 4)
                        ->where('Code', 'like', '%' . $f_EnrollmentController_coupon . '%')
                        ->orderBy('UF')
                        ->orderBy('Code')
                        ->get();
    }

    public function getEnrollmentsTestPaginated($per_page, $order_by = 'id', $sort = 'asc') {
        return Enrollment::where('test', '=', 1)->paginate($per_page);
    }

    /**
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function createTest($input) {
        $enrollment = new Enrollment();

        if (($input['exams'][0] != null) && ($input['exams'][0] != '0') && (isset($input['exams'][0]))) {
            $enrollment->exam_id = $input['exams'][0];
            $enrollment->exam_max_tries = $enrollment->exam->max_tries;
        } else {
            $enrollment->exam_id = null;
        }
        if (($input['courses'][0] != null) && ($input['courses'][0] != '0') && (isset($input['courses'][0]))) {
            $enrollment->course_id = $input['courses'][0];
        } else {
            $enrollment->course_id = null;
        }

        if (($enrollment->exam_id == null) && ($enrollment->course_id == null)) {
            throw new GeneralException('Informe um exame ou um curso.');
        }

        if (($input['students'][0] != null) && ($input['students'][0] != '0') && (isset($input['students'][0]))) {
            $enrollment->student_id = $input['students'][0];
        } else {
            throw new GeneralException('Informe o aluno.');
        }
        $enrollment->date_begin = Carbon::now();
        $enrollment->date_end = Carbon::now()->addDays($input['days']);
        $enrollment->is_active = 1;
        $enrollment->is_paid = 0;
        $enrollment->test = 1;
        $enrollment->user_id_created_by = auth()->user()->id;

        $enrollment->order_id = null;
        $enrollment->module_id = null;
        $enrollment->lesson_id = null;
        $enrollment->studentgroup_id = null;
        $enrollment->partner_id = null;

        if ($enrollment->save())
            return true;
        throw new GeneralException('There was a problem creating this enrollments. Please try again.');
    }

    public function getEnrollmentsSaapInCoursePaginated($per_page, $order_by = 'id', $sort = 'asc') {
        return Enrollment::whereNotNull('course_enrollment_id')->paginate($per_page);
    }

    /**
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function createSaapInCourse($input) {

        if (($input['courses'][0] == null) || ($input['courses'][0] == '0') || (!isset($input['courses'][0]))) {
            return;
        }

        if (($input['exams'][0] == null) || ($input['exams'][0] == '0') || (!isset($input['exams'][0]))) {
            return;
        }

        $enrollments = Enrollment::where('course_id', '=', $input['courses'][0])->get();
        foreach ($enrollments as $enrollmentCourse) {
            $saapenrollments = Enrollment::where('exam_id', '=', $input['exams'][0])
                    ->where('course_enrollment_id', '=', $enrollmentCourse->id)
                    ->get();
            if (count($saapenrollments) == 0) {
                $enrollment = new Enrollment();

                $exam = Exam::find($input['exams'][0]);

                $enrollment->exam_id = $input['exams'][0];
                $enrollment->course_enrollment_id = $enrollmentCourse->id;
                $enrollment->exam_max_tries = $exam->max_tries;

                $enrollment->student_id = $enrollmentCourse->student_id;

                $day_begin = new Carbon(parsebr($input['date_begin']));


                $enrollment->date_begin = Carbon::create($day_begin->year, $day_begin->month, $day_begin->day, $input['time_begin']);
                $enrollment->date_end = parsebr($input['date_end']);

                $enrollment->is_active = 1;
                $enrollment->is_paid = 0;
                $enrollment->test = 0;
                $enrollment->user_id_created_by = auth()->user()->id;

                $enrollment->order_id = null;
                $enrollment->module_id = null;
                $enrollment->lesson_id = null;
                $enrollment->studentgroup_id = null;
                $enrollment->partner_id = null;

                $enrollment->save();
            }
        }

        return true;

        throw new GeneralException('There was a problem creating this enrollments. Please try again.');
    }

}
