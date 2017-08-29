<?php
/**
 * Created by PhpStorm.
 * User: geofrey19
 * Date: 22/09/15
 * Time: 16:38
 */

namespace App\Http\Controllers\Backend;


use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\CourseCalendar\CreateCourseCalendarRequest;
use App\Http\Requests\Backend\CourseCalendar\UpdateCourseCalendarRequest;
use App\Repositories\Backend\CourseCalendar\CourseCalendarContract;
use App\Repositories\Backend\Course\CourseContract;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Commands\importPartnerCommand;

class CourseCalendarController extends Controller {
    /**
     * @param CourseCalendarContract $CourseCalendars
     */
    public function __construct(CourseCalendarContract $CourseCalendars, CourseContract $course) {
        $this->CourseCalendars = $CourseCalendars;
        $this->course = $course;
    }

    /**
     * @return mixed
     */
    public function index(Request $request) {
        $request->session()->put('lastpage', $request->only('page')['page']);

        $f_submit = $request->input('f_submit', '');

        $f_CourseCalendarController_course_id = get_parameter_or_session( $request, 'f_CourseCalendarController_course_id', '', $f_submit, '' );

        $courses = $this->course->getAllCourses('title', 'asc');

        return view('backend.coursecalendars.index')
            ->withCoursecalendars($this->CourseCalendars->getCoursesCalendarsPaginated(config('access.users.default_per_page'), $f_CourseCalendarController_course_id))
            ->withCoursecalendarcontrollercourseid($f_CourseCalendarController_course_id)
            ->withCourses( $courses );
    }





    /**
     * @return mixed
     */
    public function create() {
        $courses = $this->course->getAllCourses('title', 'asc');
        return view('backend.coursecalendars.create')
            ->withCourses( $courses );
    }

    /**
     * @param CreateCourseCalendarRequest $request
     * @return mixed
     */
    public function store(CreateCourseCalendarRequest $request) {
        $this->CourseCalendars->create($request);
        return redirect()->route('admin.coursecalendars.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.coursecalendars.created"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit($id) {
        $CourseCalendar = $this->CourseCalendars->findOrThrowException($id, true);
        $courses = $this->course->getAllCourses('title', 'asc');
        return view('backend.coursecalendars.edit')->withCoursecalendar($CourseCalendar)
            ->withCourses( $courses );
    }


    /**
     * @param $id
     * @param UpdateCourseCalendarRequest $request
     * @return mixed
     */
    public function update($id, UpdateCourseCalendarRequest $request) {
        $this->CourseCalendars->update($id, $request->all());
        return redirect()->route('admin.coursecalendars.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.coursecalendars.updated"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id) {
        $this->CourseCalendars->destroy($id);
        return redirect()->back()->withFlashSuccess(trans("alerts.coursecalendars.deleted"));
    }

}