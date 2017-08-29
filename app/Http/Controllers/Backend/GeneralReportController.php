<?PHP namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\OrderCourse;
use App\OrderLesson;
use App\OrderModule;
use App\Repositories\Backend\GeneralReport\GeneralReportContract;
use App\Repositories\Backend\Report\CourseReportContract;
use App\Services\UploadService\UploadService;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Collection;

/**
 * Class DashboardControllerapp/Http/Controllers/Backend/ArticleController.php:7
 * @package App\Http\Controllers\Backend
 */
class GeneralReportController extends Controller {

    /**
     * @param ArticleContract $articles
     * @param UserContract $users
     * @param UploadService $uploadService
     */
    public function __construct(GeneralReportContract $coursereport) {
        $this->coursereport = $coursereport;
    }

    /**
     * @return mixed
     */
    public function sales(Request $request)
    {

        $type = $_POST['type'];
        $period = $_POST['period'];
        $specific = $_POST['specific'];

        $order = null;


        if($type == 'courses'){
            $order = OrderCourse::withTrashed();
        }else if($type == 'modules'){
            $order = OrderModule::withTrashed();
        }else{
            $order = OrderLesson::withTrashed();
        }


        if($specific == 0) $specific = null;


        if($period == 'annual'){

            return $this->coursereport->getAnnualOrderReports($order, $specific);

        }else if($period == 'daily'){
            return $this->coursereport->getDailyOrderReports($order, $specific);
        }else if($period == 'quarterly'){
            return $this->coursereport->getQuarterlyOrderReports($order, $specific);
        }else if($period == 'all'){
            return $this->coursereport->getLifetimeOrderReports($order,$specific);
        }



        //$sales = $this->coursereport->getAllSalesByWeek($course);

       // return  view('backend.reports.coursereport.sales')->withResults( $sales );
    }


    public function totalSales(){
        //$type = $_POST['type'];

        $type = 'courses';
        $order = null;

        if($type == 'courses'){
            $order = OrderCourse::withTrashed();
        }else if($type == 'modules'){
            $order = OrderModule::withTrashed();
        }else{
            $order = OrderLesson::withTrashed();
        }

        $results = $this->coursereport->getTotalSalesReports($order);



        return $results;
    }


}
