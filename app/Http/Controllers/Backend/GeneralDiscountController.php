<?php namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Repositories\Backend\Course\CourseContract;
use App\Repositories\Backend\Package\PackageContract;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Repositories\Backend\Section\SectionContract;

/**
 * Class UserTeacherController
 * @package App\Http\Controllers\Backend
 */
class GeneralDiscountController extends Controller {

    /**
     * @param UserTeacherContract $teachers
     */
    public function __construct( SectionContract $sections, CourseContract $courses, PackageContract $packages) {
        $this->sections = $sections;
        $this->courses = $courses;
        $this->packages = $packages;
    }

    /**
     * @return mixed
     */
    public function index() {
        return view('backend.generaldiscount.index')->withSections($this->sections->getAllSections());
    }

    /**
     * @param $id
     * @return mixed
     */
    public function apply(Request $request) {
        \DB::beginTransaction();
        try{
            if (validateDate($request['date_begin']) == false) {
                return redirect()->route('admin.generaldiscount.index')->withFlashDanger(trans("alerts.generaldiscount.invalid_date_begin"));
            }
            if (validateDate($request['date_end']) == false) {
                return redirect()->route('admin.generaldiscount.index')->withFlashDanger(trans("alerts.generaldiscount.invalid_date_end"));
            }
            if ( is_numeric($request['percentage']) == false) {
                return redirect()->route('admin.generaldiscount.index')->withFlashDanger(trans("alerts.generaldiscount.invalid_percentage"));
            }

            $date_begin = str_replace('/', '-', $request['date_begin']);

            $date_end = str_replace('/', '-', $request['date_end']);

            $courses = null;
            if ($request['sections'][0] === ""){
                $courses = $this->courses->getAllCourses();
            } else {
                $courses = $this->courses->getCoursesBySection( $request['sections'][0] );
            }

            foreach ($courses as $course) {
                $course->special_price = $course->price - ($course->price * $request['percentage'] /100) ;
                $course->start_special_price = Carbon::parse($date_begin);
                $course->end_special_price = Carbon::parse($date_end);
                $course->save();
            }

            $packages = null;
            if ($request['sections'][0] === ""){
                $packages = $this->packages->getAllPackages();
            } else {
                $packages = $this->packages->getPackagesBySection( $request['sections'][0] );
            }

            foreach ($packages as $package) {
                $package->special_price = $package->price - ($package->price * $request['percentage'] /100) ;
                $package->start_special_price = Carbon::parse($date_begin);
                $package->end_special_price = Carbon::parse($date_end);
                $package->save();
            }
            \DB::commit();
            return redirect()->route('admin.generaldiscount.index')->withSections($this->sections->getAllSections())->withFlashSuccess(trans("alerts.generaldiscount.applied"));
        } catch (Exception $e){
            \DB::rollback();
            return redirect()->route('admin.generaldiscount.index')->withFlashDanger($this->sections->getAllSections())->withFlashSuccess(trans("alerts.generaldiscount.notapplied"));
        }

    }

}
