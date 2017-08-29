<?PHP

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Access\User\CreateUserStudentRequest;
use App\Http\Requests\Backend\Access\User\UpdateUserStudentRequest;
use App\Http\Requests\Backend\Access\User\UpdateUserPasswordRequest;
use App\Repositories\Backend\Order\OrderContract;
use App\Repositories\Backend\OrderCourse\OrderCourseContract;
use App\Repositories\Backend\OrderPackage\OrderPackageContract;
use App\Repositories\Backend\User\UserStudentContract;
use App\Repositories\Backend\City\CityContract;
use App\Repositories\Backend\State\StateContract;
use App\Repositories\Backend\Enrollment\EnrollmentContract;
use App\Repositories\Backend\View\ViewContract;
use App\City;
use App\State;
use Carbon\Carbon;
use Illuminate\Http\Request;

/**
 * Class DashboardController
 * @package App\Http\Controllers\Backend
 */
class UserStudentController extends Controller {

    /**
     * @param UserStudentContract $newsletters
     */
    public function __construct(UserStudentContract $userstudents, CityContract $cities, StateContract $states,
                                EnrollmentContract $enrollments, ViewContract $view, OrderContract $orders,
                                OrderCourseContract $ordercourses, OrderPackageContract $orderpackages) {
        $this->userstudents = $userstudents;
        $this->cities = $cities;
        $this->states = $states;
        $this->enrollments = $enrollments;
        $this->view = $view;
        $this->orders = $orders;
        $this->ordercourses = $ordercourses;
        $this->orderpackages = $orderpackages;

    }

    /**
     * @return mixed
     */
    public function index(Request $request) {
        $request->session()->put('lastpage', $request->only('page')['page']);

        $f_UserStudentController_name = $request->input('f_UserStudentController_name', '');
        $f_submit = $request->input('f_submit', '');
        if (($f_submit != '1') && ($f_UserStudentController_name === ''))
            $f_UserStudentController_name = $request->session()->get('f_UserStudentController_name', '');
        $request->session()->put('f_UserStudentController_name', $f_UserStudentController_name);

        return view('backend.userstudents.index')
                        ->withUserstudents($this->userstudents->getUserStudentsPaginated(config('access.users.default_per_page'), $f_UserStudentController_name))
                        ->withUserstudentcontrollername($f_UserStudentController_name);
    }

    public function listUserStudent() {
        return view('backend.userstudents.list')
                        ->withUserstudents($this->userstudents->getAllUserStudents());
    }

    /**
     * @return mixed
     */
    public function create() {
        return view('backend.userstudents.create');
    }

    /**
     * @param CreateUserStudentRequest $request
     * @return mixed
     */
    public function store(CreateUserStudentRequest $request) {
        $this->userstudents->create($request);
        return redirect()->route('admin.userstudents.index')->withFlashSuccess(trans("alerts.userstudents.created"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit($id) {
        $userstudent = $this->userstudents->findOrThrowException($id, true);
        $city = City::withTrashed()->find($userstudent->city_id);
        $state = new State();
        if ($city != null) {
            $state = State::withTrashed()->find($city->state_id);
        } else {
            $city = new City();
        }
        return view('backend.userstudents.edit')
                        ->withUserstudent($userstudent)
                        ->withCity($city)
                        ->withState($state);
    }

    public function selectStudent() {

        $userstudents = $this->userstudents->selectStudents($_POST['term']);

        $list = [];

        foreach ($userstudents as $student) {
            $list[] = ['id' => $student->id, 'text' => $student->name];
        }

        return json_encode($list);
    }

    /**
     * @param $id
     * @param UpdateUserStudentRequest $request
     * @return mixed
     */
    public function update($id, UpdateUserStudentRequest $request) {
        $this->userstudents->update($id, $request->all());
        return redirect()->route('admin.userstudents.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.userstudent.updated"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id) {
        $this->userstudents->destroy($id);
        return redirect()->back()->withFlashSuccess(trans("alerts.userstudent.deleted"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function changePassword($id) {
        return view('backend.userstudents.change-password')
                        ->withUserstudent($this->userstudents->findOrThrowException($id));
    }

    /**
     * @param $id
     * @param UpdateUserPasswordRequest $request
     * @return mixed
     */
    public function updatePassword($id, UpdateUserPasswordRequest $request) {
        $this->userstudents->updatePassword($id, $request->all());
        return redirect()->route('admin.userstudents.index')->withFlashSuccess(trans("alerts.users.updated_password"));
    }

    /**
     * @return mixed
     */
    public function enrollments(Request $request, $id) {
        $courses = $this->enrollments->getCoursesPerStudent($id);
        $modules = $this->enrollments->getModulesPerStudent($id);
        $lessons = $this->enrollments->getLessonsPerStudent($id);

        return view('backend.userstudents.enrollments')
                        ->withStudentcourses($courses)
                        ->withStudentmodules($modules)
                        ->withStudentlessons($lessons)
                        ->withStudentcoursecontrollerstudentid($id);
    }

    public function logOfAccess(Request $request, $student_id, $course_id) {
        $enrollments = \App\Enrollment::where('student_id', '=', $student_id)
                ->where('course_id', '=', $course_id)
                ->get();

        //Consultando log das matriculas
        foreach ($enrollments as $enrollment) {
            //Consultando base de logs
            $logs[$enrollment->id] = \App\ViewLog::join('contents as c', 'c.id', "=", 'view_log.content_id')
                    ->join('lessons as l', 'l.id', '=', 'c.lesson_id')
                    ->selectRaw(
                            "c.sequence as bloco,"
                            . "view_log.datetime_view,"
                            . "view_log.created_at as date_begin, "
                            . "view_log.updated_at as date_end, "
                            . "view_log.watched_time,"
                            . "view_log.content_id,"
                            . "l.title as lesson_title,"
                            . "l.sequence as lesson_sequence,"
                            . "view_log.user_agent,"
                            . "view_log.ip as ip")
                    ->where('view_log.enrollment_id', '=', $enrollment->id)
                    ->where('view_log.watched_time', '>', 0)
                    ->orderBy('view_log.datetime_view', 'desc')
                    ->get();
        }



        return view('backend.userstudents.logs')
                        ->withLogs($logs)
                        ->withEnrollments($enrollments);
    }

    /**
     * 
     * @param Request $request
     * @param type $student_id
     * @param type $enrollment_id
     * @param type $view
     * @return type
     */
    public function logOfLessonAccess(Request $request, $enrollment_id, $lesson_id) {

        
        //Consultando base de logs
        $logs = \App\ViewLog::join('contents as c', 'c.id', "=", 'view_log.content_id')
                ->join('lessons as l', 'l.id', '=', 'c.lesson_id')
                ->selectRaw(
                        "c.sequence as bloco,"
                        . "view_log.datetime_view,"
                        . "view_log.created_at as date_begin, "
                        . "view_log.updated_at as date_end, "
                        . "view_log.watched_time,"
                        . "view_log.content_id,"
                        . "l.title as lesson_title,"
                        . "l.sequence as lesson_sequence,"
                        . "view_log.user_agent")
                ->where('view_log.enrollment_id', '=', $enrollment_id)
                ->where('l.id', '=', $lesson_id)
                ->where('view_log.watched_time', '>', 0)
                ->orderBy('view_log.datetime_view', 'desc')
                ->get();
        return view('backend.userstudents.lessons_logs')
                        ->withLogs($logs);
    }

    /**
     * @return mixed
     */
    public function lessons(Request $request, $id, $enrollment_id) {
        $enrollment = $this->enrollments->findOrThrowException($enrollment_id, true);

        $views = null;
        if ($enrollment->course != null) {
            $views = $this->view->getViewCoursePerStudent($id, $enrollment_id);
        } else if ($enrollment->module != null) {
            $views = $this->view->getViewModulePerStudent($id, $enrollment_id);
        } else {
            $views = $this->view->getViewLessonPerStudent($id, $enrollment_id);
        }

        $views = $views->reject(function($item) {
            return $item->content == null || $item->content->lesson == null;
        });

        return view('backend.userstudents.lessons')
                        ->withViews($views)
                        ->withViewcontrollerstudentid($id)
                        ->withViewcontrollerenrollment($enrollment);
    }

    public function addView(Request $request, $id, $enrollment_id, $view) {

        $view = $this->view->findOrThrowException($view, true);
        $view->max_view = $view->max_view + 1;
        $view->save();

        return redirect()->route('admin.userstudents.lessons', [$id, $enrollment_id]);
    }

    public function subtractView(Request $request, $id, $enrollment_id, $view) {

        $view = $this->view->findOrThrowException($view, true);
        $view->max_view = $view->max_view - 1;
        $view->save();

        return redirect()->route('admin.userstudents.lessons', [$id, $enrollment_id]);
    }

    public function deactivateEnrollment($student_id, $enrollment_id) {
        $this->enrollments->deactivated($enrollment_id);
        return redirect()->back()->withFlashSuccess(trans("alerts.tags.deactivated"));
    }

    public function activateEnrollment($student_id, $enrollment_id) {
        $this->enrollments->activated($enrollment_id);
        return redirect()->back()->withFlashSuccess(trans("alerts.tags.activated"));
    }

    public function addDayEnrollment(Request $request, $id, $enrollment_id) {

        $enrollment = $this->enrollments->findOrThrowException($enrollment_id, true);
        $enrollment->date_end = Carbon::parse($enrollment->date_end)->addDay();
        $enrollment->save();

        return redirect()->back();
    }

    public function addWeekEnrollment(Request $request, $id, $enrollment_id) {

        $enrollment = $this->enrollments->findOrThrowException($enrollment_id, true);
        $enrollment->date_end = Carbon::parse($enrollment->date_end)->addWeek();
        $enrollment->save();

        return redirect()->back();
    }

    public function addMonthEnrollment(Request $request, $id, $enrollment_id) {

        $enrollment = $this->enrollments->findOrThrowException($enrollment_id, true);
        $enrollment->date_end = Carbon::parse($enrollment->date_end)->addMonth();
        $enrollment->save();

        return redirect()->back();
    }

    /**
     * @return mixed
     */
    public function exams(Request $request, $id) {
        $exams = $this->enrollments->getExamsPerStudent($id);

        return view('backend.userstudents.exams')
                        ->withStudentexams($exams)
                        ->withStudentexamcontrollerstudentid($id);
    }

    public function addExecution(Request $request, $id, $enrollment_id) {

        $enrollment = $this->enrollments->findOrThrowException($enrollment_id, true);
        $enrollment->exam_max_tries = $enrollment->exam_max_tries + 1;
        $enrollment->save();

        return redirect()->back();
    }

    public function subtractExecution(Request $request, $id, $enrollment_id) {

        $enrollment = $this->enrollments->findOrThrowException($enrollment_id, true);
        $enrollment->exam_max_tries = $enrollment->exam_max_tries - 1;
        $enrollment->save();

        return redirect()->back();
    }

    public function viewed(Request $request, $id, $enrollment_id, $view) {

        $view = $this->view->findOrThrowException($view, true);
        if ($view->view == 0) {
            $view->view = 1;
            $view->save();
        }

        return redirect()->route('admin.userstudents.lessons', [$id, $enrollment_id]);
    }

    public function orders(Request $request, $id){
        $orders = $this->orders->getOrdersStudent( $id);

        return view('backend.userstudents.orders')
            ->withOrders($orders)
            ->withStudentordercontrollerstudentid($id);
    }

    public function courseExternalPayment( $id ) {
        if (access()->hasPermission('order_external_payment')) {
            $ordercourse = $this->ordercourses->findOrThrowException($id);
            return view('backend.userstudents.orders_course_external_payment')->withOrdercourse($ordercourse);
        }
    }

    public function courseExternalPaymentRun( Request $request ) {
        if (access()->hasPermission('order_external_payment')) {
            $ordercourse = $this->ordercourses->findOrThrowException($request->input('ordercourse_id', ''));

            $student_id = $ordercourse->order->student_id;


            if ($ordercourse->discount_price == 0.00) {
                $value = parsemoneybr($request->input('value', ''));

                $ordercourse->discount_price = $value;
                if ($ordercourse->price < $ordercourse->discount_price) {
                    $ordercourse->price = $ordercourse->discount_price;
                }
                $ordercourse->document_external_payment = $request->input('document_external_payment', '');
                $ordercourse->justification_external_payment = $request->input('justification_external_payment', '');
                $ordercourse->user_id_external_payment = auth()->user()->id;
                $ordercourse->save();

                $ordercourse->order->discount_price = $ordercourse->order->discount_price + $value;
                if ($ordercourse->order->price < $ordercourse->order->discount_price) {
                    $ordercourse->order->price = $ordercourse->order->discount_price;
                }
                $ordercourse->order->save();
            }
            $orders = $this->orders->getOrdersStudent($student_id);
            return view('backend.userstudents.orders')->withOrders($orders)->withStudentordercontrollerstudentid($student_id);
        }
    }

//    public function packageExternalPayment( $id ) {
//        if (access()->hasPermission('order_external_payment')) {
//        $orderpackages = $this->orderpackagess->findOrThrowException( $id );
//
//        return view('backend.userstudents.orders_packages_external_payment')->withOrderpackages( $orderpackages );
//        }
//    }
//
//    public function packageExternalPaymentRun( Request $request ) {
//        if (access()->hasPermission('order_external_payment')) {
//        $orderpackages = $this->orderpackagess->findOrThrowException( $request->input('orderpackages_id', ''));
//
//        $student_id = $orderpackages->order->student_id;
//
//
//        if ($orderpackages->discount_price == 0.00){
//            $value = parsemoneybr($request->input('value', ''));
//
//            $orderpackages->discount_price = $value;
//            $orderpackages->document_external_payment = $request->input('document_external_payment', '');
//            $orderpackages->justification_external_payment = $request->input('justification_external_payment', '');
//            $orderpackages->user_id_external_payment = auth()->user()->id;
//            $orderpackages->save();
//
//            $orderpackages->order->discount_price = $orderpackages->order->discount_price + $value;
//            if ( $orderpackages->order->price < $orderpackages->order->discount_price){
//                $orderpackages->order->price = $orderpackages->order->discount_price;
//            }
//            $orderpackages->order->save();
//        }
//        $orders = $this->orders->getOrdersStudent( $student_id );
//        return view('backend.userstudents.orders')->withOrders($orders)->withStudentordercontrollerstudentid($student_id);
//      }
//    }

}
