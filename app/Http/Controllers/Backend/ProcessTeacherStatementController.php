<?php namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Repositories\Backend\Configuration\EloquentConfigurationRepository;
use App\Repositories\Backend\CourseTeacher\EloquentCourseTeacherRepository;
use App\Repositories\Backend\Order\EloquentOrderRepository;
use App\Repositories\Backend\OrderCourse\EloquentOrderCourseRepository;
use App\Repositories\Backend\OrderLesson\EloquentOrderLessonRepository;
use App\Repositories\Backend\OrderModule\EloquentOrderModuleRepository;
use App\Repositories\Backend\TeacherStatement\EloquentTeacherStatementRepository;
use App\Repositories\Backend\OrderPackage\EloquentOrderPackageRepository;
use App\Repositories\Backend\PackageTeacher\EloquentPackageTeacherRepository;
use App\Repositories\Backend\PartnerorderPayment\EloquentPartnerorderPaymentRepository;
use App\Repositories\Backend\tag\EloquentTagRepository;
use App\Repositories\Frontend\User\UserTeacherContract;
use Illuminate\Http\Request;
use Carbon\Carbon;

/**
 * Class UserTeacherController
 * @package App\Http\Controllers\Backend
 */
class ProcessTeacherStatementController extends Controller {

    /**
     * @param UserTeacherContract $teachers
     */
    public function __construct() {
    }

    /**
     * @return mixed
     */
    public function index() {
        return view('backend.processteacherstatements.index');
    }

    /**
     * @param $id
     * @return mixed
     */
    public function process(Request $request) {
        try{
            if (validateDate($request['datebegin']) == false) {
                return redirect()->route('admin.processteacherstatements.index')->withFlashSuccess(trans("alerts.processteacherstatements.invalid_date"));
            }
            if (validateDate($request['dateend']) == false) {
                return redirect()->route('admin.processteacherstatements.index')->withFlashSuccess(trans("alerts.processteacherstatements.invalid_date"));
            }

            $datebegin = str_replace('/', '-', $request['datebegin']);
            $dateend = str_replace('/', '-', $request['dateend']);

            $teacherStatementController = new TeacherStatementController( new EloquentTeacherStatementRepository(),
                new EloquentOrderRepository(),
                new EloquentOrderCourseRepository(),
                new EloquentOrderModuleRepository(),
                new EloquentOrderLessonRepository(),
                new EloquentCourseTeacherRepository( new EloquentTagRepository() ),
                new EloquentConfigurationRepository(),
                new EloquentOrderPackageRepository(),
                new EloquentPackageTeacherRepository(),
                new EloquentPartnerorderPaymentRepository());

            $teacherStatementController->process($datebegin, $dateend );
            return redirect()->route('admin.processteacherstatements.index')->withFlashSuccess(trans("alerts.processteacherstatements.processed"));
        } catch (Exception $e){
            return redirect()->route('admin.processteacherstatements.index')->withFlashSuccess(trans("alerts.processteacherstatements.notprocessed"));
        }

    }

}
