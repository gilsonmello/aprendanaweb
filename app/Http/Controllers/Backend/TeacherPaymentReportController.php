<?PHP namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Repositories\Backend\Report\TeacherPaymentReportContract;
use App\Services\UploadService\UploadService;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Collection;

/**
 * Class DashboardControllerapp/Http/Controllers/Backend/ArticleController.php:7
 * @package App\Http\Controllers\Backend
 */
class TeacherPaymentReportController extends Controller {

    /**
     * @param ArticleContract $articles
     * @param UserContract $users
     * @param UploadService $uploadService
     */
    public function __construct(TeacherPaymentReportContract $teacherpaymentreport) {
        $this->teacherpaymentreport = $teacherpaymentreport;
    }

    /**
     * @return mixed
     */
    public function index(Request $request) {

        $f_submit = $request->input('f_submit', '');

        $f_TeacherPaymentReportController_teacher_id = get_parameter_or_session( $request, 'f_TeacherPaymentReportController_teacher_id', '', $f_submit, '' );

        $f_TeacherPaymentReportController_date_begin = get_parameter_or_session( $request, 'f_TeacherPaymentReportController_date_begin', '', $f_submit, format_datebr(Carbon::now()->addDays(-30) ));

        $f_TeacherPaymentReportController_date_end = get_parameter_or_session( $request, 'f_TeacherPaymentReportController_date_end', '', $f_submit, format_datebr(Carbon::now() ));

        $f_TeacherPaymentReportController_detail = get_parameter_or_session( $request, 'f_TeacherPaymentReportController_detail', '', $f_submit, '0' );

        $f_TeacherPaymentReportController_itens = get_parameter_or_session( $request, 'f_TeacherPaymentReportController_itens', '', $f_submit, '0' );

        $total_general_sales = 0;
        $count_general_sales = 0;

        $results = null;
        
        if ($f_submit == '1') {
            $results = $this->teacherpaymentreport->getTeacherPaymentListReports($f_TeacherPaymentReportController_date_begin, $f_TeacherPaymentReportController_date_end, null, $total_general_sales, $count_general_sales);
        }

        // Wrap them in a collection.
        $collection = new Collection($results);

        // Sort descending by stars.
        $collection = $collection->sortByDesc(function($item)
        {
            return $item->total_sales;
        });

        if ($f_TeacherPaymentReportController_itens != 0){
            $collection = $collection->take($f_TeacherPaymentReportController_itens);
        }

        return view('backend.reports.teacherpaymentreport.index')
            ->withResults( $collection )
            ->withTeacherpaymentreportcontrollerdatebegin( $f_TeacherPaymentReportController_date_begin )
            ->withTeacherpaymentreportcontrollerdateend( $f_TeacherPaymentReportController_date_end )
            ->withTotalsales( $total_general_sales )
            ->withCountsales( $count_general_sales )
            ->withTeacherpaymentreportcontrollerdetail($f_TeacherPaymentReportController_detail)
            ->withTeacherpaymentreportcontrolleritens($f_TeacherPaymentReportController_itens);
    }


}
