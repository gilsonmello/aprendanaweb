<?php

/**
 * Created by PhpStorm.
 * User: geofrey19
 * Date: 22/09/15
 * Time: 16:38
 */

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Enrollment\CreateEnrollmentRequest;
use App\Http\Requests\Backend\Enrollment\UpdateEnrollmentRequest;
use App\Repositories\Backend\Course\CourseContract;
use App\Repositories\Backend\Enrollment\EnrollmentContract;
use App\Repositories\Backend\Exam\ExamContract;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Commands\importPartnerCommand;
use App\Course;

class EnrollmentController extends Controller {

    /**
     * @param EnrollmentContract $enrollments
     */
    public function __construct(EnrollmentContract $enrollments, CourseContract $courses, ExamContract $exams) {
        $this->enrollments = $enrollments;
        $this->courses = $courses;
        $this->exams = $exams;
    }
    
    /**
     * 
     * @param Request $request
     * @return view
     */
    public function releaseForCertification(Request $request) {
        $f_submit = $request->input('f_submit', '');

        $nameOrEmail = get_parameter_or_session($request, 'f_EnrollmentController_name_or_email', '', $f_submit, '');
        $course_id = get_parameter_or_session($request, 'f_EnrollmentController_course_id', '', $f_submit, '');
        $date_begin = get_parameter_or_session($request, 'f_EnrollmentController_date_begin', '', $f_submit, '');
        $date_end = get_parameter_or_session($request, 'f_EnrollmentController_date_end', '', $f_submit, '');
        $released_for_certification = get_parameter_or_session($request, 'f_EnrollmentController_released_for_certification', '', $f_submit, '');
        return view('backend.enrollments.releaseforcertification')
                        ->withEnrollments($this->enrollments->getEnrollmentsForCoordinators(
                                        config('access.users.default_per_page'), $nameOrEmail, $course_id, $date_begin, $date_end, $released_for_certification
                                )
                        )
                        ->withCourses(Course::courses())
                        ->withNameoremail($nameOrEmail)
                        ->withCourseid($course_id)
                        ->withDatebegin($date_begin)
                        ->withDateend($date_end)
                        ->withReleasedforcertification($released_for_certification);
    }
    
    /**
     * 
     * @param Request $request
     * @return view
     */
    public function index(Request $request) {
        $f_submit = $request->input('f_submit', '');

        $nameOrEmail = get_parameter_or_session($request, 'f_EnrollmentController_name_or_email', '', $f_submit, '');
        $course_id = get_parameter_or_session($request, 'f_EnrollmentController_course_id', '', $f_submit, '');
        $date_begin = get_parameter_or_session($request, 'f_EnrollmentController_date_begin', '', $f_submit, '');
        $date_end = get_parameter_or_session($request, 'f_EnrollmentController_date_end', '', $f_submit, '');
        $released_for_certification = get_parameter_or_session($request, 'f_EnrollmentController_released_for_certification', '', $f_submit, '');
        return view('backend.enrollments.index')
                        ->withEnrollments($this->enrollments->getEnrollmentsForCoordinators(
                                        config('access.users.default_per_page'), $nameOrEmail, $course_id, $date_begin, $date_end, $released_for_certification
                                )
                        )
                        ->withCourses(Course::courses())
                        ->withNameoremail($nameOrEmail)
                        ->withCourseid($course_id)
                        ->withDatebegin($date_begin)
                        ->withDateend($date_end)
                        ->withReleasedforcertification($released_for_certification);
    }
    
    public function edit($id){
        return view('backend.enrollments.edit', ['enrollment' => $this->enrollments->findOrThrowException($id)]);
    }
    
    public function update($id, Request $request){
        $enrollment = $this->enrollments->update($id, $request->all());
        if($enrollment){
           return redirect()->route('admin.enrollments.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.enrollments.updated"));
        }
        return redirect()->route('admin.enrollments.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashDanger(trans("alerts.enrollments.updated_error"));
    }
    
    public function updateReleaseForCertification($id, Request $request){
        $enrollment = $this->enrollments->updateReleaseForCertification($id, $request->all());
        if($enrollment){
            return redirect()->route('admin.enrollments.releaseforcertification', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.enrollments.updated"));
        }
        return redirect()->route('admin.enrollments.releaseforcertification', ['page' => $request->session()->get('lastpage', '1')])->withFlashDanger(trans("alerts.enrollments.updated_error"));
  
    }

    /**
     * @return mixed
     */
    public function indexTest(Request $request) {
        $request->session()->put('lastpage', $request->only('page')['page']);

        $f_submit = $request->input('f_submit', '');

        return view('backend.enrollments.index-test')
                        ->withEnrollments($this->enrollments->getEnrollmentsTestPaginated(config('access.users.default_per_page')));
    }

    /**
     * @return mixed
     */
    public function createTest() {
        $courses = $this->courses->getAllCourses();

        $exams = $this->exams->getAllExams();

        return view('backend.enrollments.create-test')
                        ->withCourses($courses)
                        ->withExams($exams);
    }

    /**
     * @param CreateEnrollmentRequest $request
     * @return mixed
     */
    public function storeTest(Request $request) {
        $this->enrollments->createTest($request);
        return redirect()->route('admin.enrollments.indextest', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.enrollments.created"));
    }

    /**
     * @return mixed
     */
    public function indexSaapInCourse(Request $request) {
        $request->session()->put('lastpage', $request->only('page')['page']);

        $f_submit = $request->input('f_submit', '');

        return view('backend.enrollments.index-saapincourse')
                        ->withEnrollments($this->enrollments->getEnrollmentsSaapInCoursePaginated(config('access.users.default_per_page')));
    }

    /**
     * @return mixed
     */
    public function createSaapInCourse() {
        $courses = $this->courses->getAllCourses();

        $exams = $this->exams->getAllExams();

        return view('backend.enrollments.create-saapincourse')
                        ->withCourses($courses)
                        ->withExams($exams);
    }

    /**
     * @param CreateEnrollmentRequest $request
     * @return mixed
     */
    public function storeSaapInCourse(Request $request) {
        $this->enrollments->createSaapInCourse($request);
        return redirect()->route('admin.enrollments.indexsaapincourse', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.enrollments.created"));
    }

    /**
     * @param CreateEnrollmentRequest $request
     * @return mixed
     */
    public function reportEnrollmentVsCoupon(Request $request) {
        $f_submit = $request->input('f_submit', '');

        $f_EnrollmentController_coupon = get_parameter_or_session($request, 'f_EnrollmentController_coupon', '', $f_submit, '');
        $f_EnrollmentController_date_begin = get_parameter_or_session($request, 'f_EnrollmentController_date_begin', '', $f_submit, '');
        $f_EnrollmentController_date_end = get_parameter_or_session($request, 'f_EnrollmentController_date_end', '', $f_submit, '');

        return view('backend.reports.enrollmentxcoupon.index')
                        ->withResults($this->enrollments->getAllEnrollmentWithCoupon(
                                        $f_EnrollmentController_coupon, $f_EnrollmentController_date_begin, $f_EnrollmentController_date_end
                                )
                        )
                        ->withEnrollmentcoupon($f_EnrollmentController_coupon)
                        ->withEnrollmentdatebegin($f_EnrollmentController_date_begin)
                        ->withEnrollmentdateend($f_EnrollmentController_date_end);
    }

}
