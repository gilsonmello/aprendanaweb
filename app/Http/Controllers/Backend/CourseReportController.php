<?PHP

namespace App\Http\Controllers\Backend;

use App\AttemptToRegisterOnTheCart;
use App\Http\Controllers\Controller;
use App\Repositories\Backend\Partner\PartnerContract;
use App\Repositories\Backend\Report\CourseReportContract;
use App\Repositories\Backend\Order\OrderContract;
use App\Services\UploadService\UploadService;
use App\TrackCart;
use App\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use stdClass;
use App\Order;

/**
 * Class DashboardControllerapp/Http/Controllers/Backend/ArticleController.php:7
 * @package App\Http\Controllers\Backend
 */
class CourseReportController extends Controller {

    /**
     * @param ArticleContract $articles
     * @param UserContract $users
     * @param UploadService $uploadService
     */
    public function __construct(CourseReportContract $coursereport, OrderContract $orders, PartnerContract  $partners) {
        $this->coursereport = $coursereport;
        $this->orders = $orders;
        $this->partners = $partners;
    }

    /**
     * @return mixed
     */
    public function sales(Request $request) {

        $f_submit = $request->input('f_submit', '');

        $f_CourseReportController_course_id = get_parameter_or_session($request, 'f_CourseReportController_course_id', '', $f_submit, '');

        $f_CourseReportController_date_begin = get_parameter_or_session($request, 'f_CourseReportController_date_begin', '', $f_submit, format_datebr(Carbon::now()->addDays(-30)));

        $f_CourseReportController_date_end = get_parameter_or_session($request, 'f_CourseReportController_date_end', '', $f_submit, format_datebr(Carbon::now()));

        $f_CourseReportController_detail = get_parameter_or_session($request, 'f_CourseReportController_detail', '', $f_submit, '0');

        $f_CourseReportController_itens = get_parameter_or_session($request, 'f_CourseReportController_itens', '', $f_submit, '0');

        $f_CourseReportController_only_paid = get_parameter_or_session($request, 'f_CourseReportController_only_paid', '', $f_submit, '0');

        $f_CourseReportController_partner_id = get_parameter_or_session($request, 'f_CourseReportController_partner_id', '', $f_submit, '' );


        $total_general_sales = 0;
        $count_general_sales = 0;

        $results = null;
        if ($f_submit == '1') {
            $results = $this->coursereport->getCourseSalesReports($f_CourseReportController_date_begin, $f_CourseReportController_date_end, null, $total_general_sales, $count_general_sales, $f_CourseReportController_only_paid, $f_CourseReportController_partner_id);
        }
        // Wrap them in a collection.
        $collection = new Collection($results);

        // Sort descending by stars.
        $collection = $collection->sortByDesc(function($item) {
            return $item->total_sales;
        });

        if ($f_CourseReportController_itens != 0) {
            $collection = $collection->take($f_CourseReportController_itens);
        }

        $partners = $this->partners->getAllPartners('name', 'asc');

        return view('backend.reports.coursereport.sales')
                        ->withResults($collection)
                        ->withCoursereportcontrollerdatebegin($f_CourseReportController_date_begin)
                        ->withCoursereportcontrollerdateend($f_CourseReportController_date_end)
                        ->withTotalsales($total_general_sales)
                        ->withCountsales($count_general_sales)
                        ->withPartners($partners)
                        ->withCoursereportcontrollerpartnerid($f_CourseReportController_partner_id)
                        ->withCoursereportcontrollerdetail($f_CourseReportController_detail)
                        ->withCoursereportcontrolleronlypaid($f_CourseReportController_only_paid)
                        ->withCoursereportcontrolleritens($f_CourseReportController_itens);
    }

    /**
     * @return mixed
     */
    public function stats(Request $request) {

        $f_submit = $request->input('f_submit', '');
        $f_CourseReportController_course_id = get_parameter_or_session($request, 'f_CourseReportController_course_id', '', $f_submit, '');
        $f_CourseReportController_date_begin = get_parameter_or_session($request, 'f_CourseReportController_date_begin', '', $f_submit, format_datebr(Carbon::now()->addDays(-30)));
        $f_CourseReportController_date_end = get_parameter_or_session($request, 'f_CourseReportController_date_end', '', $f_submit, format_datebr(Carbon::now()));

        $orders = null;
        if ($f_submit == '1') {
            $orders = $this->orders->getAllOrders($f_CourseReportController_date_begin, $f_CourseReportController_date_end, null, null, null);
        } else {
            return view('backend.reports.coursereport.stats')
                            ->withCoursereportcontrollerdatebegin($f_CourseReportController_date_begin)
                            ->withCoursereportcontrollerdateend($f_CourseReportController_date_end);
        }

        $stats = new stdClass();
        $stats->total = 0;
        $stats->status1 = 0;
        $stats->status1WithoutUser = 0;
        $stats->status1WithUser = 0;
        $stats->status2 = 0;
        $stats->status2Money = 0;
        $stats->status4 = 0;
        $stats->status4Paid = 0;
        $stats->status4PaidMoney = 0;
        $stats->status4PaidCoupon = 0;
        $stats->status4PaidCouponMoney = 0;
        $stats->status4Free = 0;
        $stats->status4FreeCoupon = 0;
        $stats->status5 = 0;
        $stats->status5Money = 0;

        $preorders = array();
        $cancelleds = array();
        $pendings = array();

        foreach ($orders as $order) {
            if (($order->student == null) || (count($order->student->roles()->get()) == 1)) {
                if ($order->status_id == 1) {
                    $stats->status1 = $stats->status1 + 1;
                    if ($order->student_id == null) {
                        $stats->status1WithoutUser = $stats->status1WithoutUser + 1;
                    } else {
                        $stats->status1WithUser = $stats->status1WithUser + 1;
                        $preorders[] = $order;
                    }
                    $stats->total = $stats->total + 1;
                } else if (($order->status_id == 2) && ($order->student != null)) {
                    $stats->status2 = $stats->status2 + 1;
                    $stats->status2Money = $stats->status2Money + $order->discount_price;
                    $pendings[] = $order;
                    $stats->total = $stats->total + 1;
                } else if (($order->status_id == 4) && ($order->student != null)) {
                    $stats->status4 = $stats->status4 + 1;
                    if ($order->discount_price <= 0) {
                        if ($order->coupon_id == null) {
                            $stats->status4Free = $stats->status4Free + 1;
                        } else {
                            $stats->status4FreeCoupon = $stats->status4FreeCoupon + 1;
                        }
                    } else {
                        if ($order->coupon_id == null) {
                            $stats->status4Paid = $stats->status4Paid + 1;
                            $stats->status4PaidMoney = $stats->status4PaidMoney + $order->discount_price;
                        } else {
                            $stats->status4PaidCoupon = $stats->status4PaidCoupon + 1;
                            $stats->status4PaidCouponMoney = $stats->status4PaidCouponMoney + $order->discount_price;
                        }
                    }
                    $stats->total = $stats->total + 1;
                } else if (($order->status_id == 5) && ($order->student != null)) {
                    $stats->status5 = $stats->status5 + 1;
                    $stats->status5Money = $stats->status5Money + $order->discount_price;
                    $cancelleds[] = $order;
                    $stats->total = $stats->total + 1;
                }
            }
        }

        $query = User::students()->select(\DB::raw('count(*) as count '));
        if (isset($f_CourseReportController_date_begin) && $f_CourseReportController_date_begin != "")
            $query->where('created_at', '>', parsebr($f_CourseReportController_date_begin));
        if (isset($f_CourseReportController_date_end) && $f_CourseReportController_date_end != "")
            $query->where('created_at', '<', parsebr($f_CourseReportController_date_end)->addDay());
        $students = $query->get();
        $stats->students = $students[0]->count;

        $query = TrackCart::select('path'); //->whereNotNull('order_id');
        if (isset($f_CourseReportController_date_begin) && $f_CourseReportController_date_begin != "")
            $query->where('created_at', '>', parsebr($f_CourseReportController_date_begin));
        if (isset($f_CourseReportController_date_end) && $f_CourseReportController_date_end != "")
            $query->where('created_at', '<', parsebr($f_CourseReportController_date_end)->addDay());
        $tracks = $query->orderBy('path')->get();


        $collection = new Collection($tracks);
        $collection = $collection->groupBy('path');

        $tracks = [];
        foreach ($collection as $key => $item) {
            $track = new stdClass();
            $track->path = $key;
            $track->count = count($item);
            $tracks[] = $track;
        }

        $collection = new Collection($tracks);
        $collection = $collection->sortByDesc(function($item) {
            return $item->count;
        });

        $query = AttemptToRegisterOnTheCart::orderBy('created_at')->whereRaw( ' email not in (Select users.email from users) ' ); //->whereNotNull('order_id');
        if (isset($f_CourseReportController_date_begin) && $f_CourseReportController_date_begin != "")
            $query->where('created_at', '>', parsebr($f_CourseReportController_date_begin));
        if (isset($f_CourseReportController_date_end) && $f_CourseReportController_date_end != "")
            $query->where('created_at', '<', parsebr($f_CourseReportController_date_end)->addDay());
        $attempts = $query->get();

//        $query = Order::whereNotNull('orders.id')->whereNotNull('orders.student_id');
//        $query->where('orders.status_id', '=', 1);
//        $query->where('orders.date_registration', '>=', parsebr($f_CourseReportController_date_begin));
//        $query->where('orders.date_registration', '<', parsebr($f_CourseReportController_date_end)->addDay());
//        $preorders = $query->orderBy('orders.id', 'asc')->get();
//
//        $query = Order::whereNotNull('orders.id')->whereNotNull('orders.student_id');
//        $query->where('orders.status_id', '=', 5);
//        $query->where('orders.date_registration', '>=', parsebr($f_CourseReportController_date_begin));
//        $query->where('orders.date_registration', '<', parsebr($f_CourseReportController_date_end)->addDay());
//        $cancelleds = $query->orderBy('orders.id', 'asc')->get();
//
//        $query = Order::whereNotNull('orders.id')->whereNotNull('orders.student_id');
//        $query->where('orders.status_id', '=', 2);
//        $query->where('orders.date_registration', '>=', parsebr($f_CourseReportController_date_begin));
//        $query->where('orders.date_registration', '<', parsebr($f_CourseReportController_date_end)->addDay());
//        $pendings = $query->orderBy('orders.id', 'asc')->get();

        return view('backend.reports.coursereport.stats')
                        ->withStats($stats)
                        ->withTracks($collection)
                        ->withPreorders($preorders)
                        ->withCancelleds($cancelleds)
                        ->withPendings($pendings)
                        ->withAttempts($attempts)
                        ->withCoursereportcontrollerdatebegin($f_CourseReportController_date_begin)
                        ->withCoursereportcontrollerdateend($f_CourseReportController_date_end);
    }

}
