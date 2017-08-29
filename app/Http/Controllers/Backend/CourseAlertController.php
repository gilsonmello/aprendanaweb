<?php

/**
 * Created by PhpStorm.
 * User: geofrey19
 * Date: 22/09/15
 * Time: 16:38
 */

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\CourseAlert\CreateCourseAlertRequest;
use App\Http\Requests\Backend\CourseAlert\UpdateCourseAlertRequest;
use App\Repositories\Backend\CourseAlert\CourseAlertContract;
use App\Repositories\Backend\Course\CourseContract;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Commands\importPartnerCommand;

class CourseAlertController extends Controller {

    /**
     * @param CourseAlertContract $CourseAlerts
     */
    public function __construct(CourseAlertContract $CourseAlerts, CourseContract $course) {
        $this->CourseAlerts = $CourseAlerts;
        $this->course = $course;
    }

    /**
     * @return mixed
     */
    public function index(Request $request) {
        $request->session()->put('lastpage', $request->only('page')['page']);

        $f_submit = $request->input('f_submit', '');

        $f_CourseAlertController_course_id = get_parameter_or_session($request, 'f_CourseAlertController_course_id', '', $f_submit, '');

        $courses = $this->course->getAllCourses('title', 'asc');

        return view('backend.coursealerts.index')
            ->withCoursealerts($this->CourseAlerts->getCoursesAlertsPaginated(config('access.users.default_per_page'), $f_CourseAlertController_course_id))
            ->withCoursealertcontrollercourseid($f_CourseAlertController_course_id)
            ->withCourses($courses);
    }

    /**
     * Envia emails para usuários que estão aderentes ao alerta publicado
     */
    public function sendToMail($id) {

        $courseAlert = $this->CourseAlerts->sendEmail($id);
        if($courseAlert){
            return redirect()->back()->withFlashSuccess(trans("alerts.coursealerts.sendemail"));
        }
        return redirect()->back()->withFlashError(trans("alerts.coursealerts.errorsendemail"));
    }

    /**
     * @return mixed
     */
    public function create() {
        $courses = $this->course->getAllCourses('title', 'asc');
        return view('backend.coursealerts.create')
                        ->withCourses($courses);
    }

    /**
     * @param CreateCourseAlertRequest $request
     * @return mixed
     */
    public function store(CreateCourseAlertRequest $request) {
        $this->CourseAlerts->create($request);
        return redirect()->route('admin.coursealerts.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.coursealerts.created"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit($id) {
        $CourseAlert = $this->CourseAlerts->findOrThrowException($id, true);
        $courses = $this->course->getAllCourses('title', 'asc');
        return view('backend.coursealerts.edit')->withCoursealert($CourseAlert)
                        ->withCourses($courses);
    }

    /**
     * @param $id
     * @param UpdateCourseAlertRequest $request
     * @return mixed
     */
    public function update($id, UpdateCourseAlertRequest $request) {
        $this->CourseAlerts->update($id, $request->all());
        return redirect()->route('admin.coursealerts.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.coursealerts.updated"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id) {
        $this->CourseAlerts->destroy($id);
        return redirect()->back()->withFlashSuccess(trans("alerts.coursealerts.deleted"));
    }

}
