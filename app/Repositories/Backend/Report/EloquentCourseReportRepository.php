<?php namespace App\Repositories\Backend\Report;

use App\OrderCourse;
use App\OrderPackage;
use App\Course;
use App\Package;
use App\Exceptions\GeneralException;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Order;


/**
 * Class EloquentArticleRepository
 * @package App\Repositories\Article
 */
class EloquentCourseReportRepository implements CourseReportContract {


    public function getCourseSalesReports($date_begin, $date_end, $course_id, &$total_general_sales, &$count_general_sales, $only_paid, $partner_id){
        $query = Course::whereNotNull('id');
        if (isset($course_id) && $course_id != "")
            $query->where('id', '=', $course_id);

        $query->orderBy('title', 'asc')->orderBy('id', 'asc')->get();
        $courses = $query->orderBy('id', 'asc')->get();

        foreach ($courses as $course) {

            $course->type = "course";

            $query = OrderCourse::whereNotNull('order_courses.id')
                ->select('order_courses.*',
                        'students.name as student_name',
                        'students.email as student_email',
                        'students.cel as student_cel',
                        'orders.date_registration as order_date_registration'
                )
                ->join('orders', 'orders.id', '=', 'order_courses.order_id')
                ->join('users as students', 'students.id', '=', 'orders.student_id')
                ->where('order_courses.course_id', '=', $course->id )
                ->where('orders.status_id', '=', 4 );
            if (isset($only_paid) && $only_paid == '1')
                $query->where('order_courses.discount_price', '>', 0.00);

            if (isset($date_begin) && $date_begin != "")
                $query->where('orders.date_registration', '>', parsebr($date_begin));
            if (isset($date_end) && $date_end != "")
                $query->where('orders.date_registration', '<', parsebr($date_end)->addDay());

            if (isset($partner_id) && $partner_id != "")
                $query->where('orders.partner_id', '=', $partner_id);

            $ordercourses = $query->orderBy('orders.date_registration', 'asc')->get();
            $course->ordercourses = $ordercourses;

            $total_sales = 0;
            $count_sales = 0;
            foreach ($ordercourses as $ordercourse){
                $total_sales = $total_sales + $ordercourse->discount_price;
                $count_sales = $count_sales + 1;
            }
            $course->total_sales = $total_sales;
            $total_general_sales = $total_general_sales + $total_sales;
            $course->count_sales = $count_sales;
            $count_general_sales = $count_general_sales + $count_sales;
            if ($count_sales == 0){
                $course->average_sales = 0;
            } else {
                $course->average_sales = $total_sales / $count_sales;
            }
        }
        $query = Package::whereNotNull('id');
        $query->orderBy('title', 'asc')->orderBy('id', 'asc')->get();
        $packages = $query->orderBy('id', 'asc')->get();

        foreach ($packages as $package) {

            $package->type = "package";

            $query = OrderPackage::whereNotNull('order_packages.id')
                ->select('order_packages.*', 
                        'students.name as student_name',
                        'students.email as student_email',
                        'students.cel as student_cel',
                        'orders.date_registration as order_date_registration'
                )
                ->join('orders', 'orders.id', '=', 'order_packages.order_id')
                    ->join('users as students', 'students.id', '=', 'orders.student_id')
                ->where('order_packages.package_id', '=', $package->id )
                ->where('orders.status_id', '=', 4 );

            if (isset($only_paid) && $only_paid == '1')
                $query->where('order_packages.discount_price', '>', 0.00);

            if (isset($date_begin) && $date_begin != "")
                $query->where('orders.date_registration', '>', parsebr($date_begin));
            if (isset($date_end) && $date_end != "")
                $query->where('orders.date_registration', '<', parsebr($date_end)->addDay());

            if (isset($partner_id) && $partner_id != "")
                $query->where('orders.partner_id', '=', $partner_id);

            $orderpackages = $query->orderBy('orders.date_registration', 'asc')->get();

            $package->ordercourses = $orderpackages;

            $total_sales = 0;
            $count_sales = 0;
            foreach ($orderpackages as $orderpackage){
                $total_sales = $total_sales + $orderpackage->discount_price;
                $count_sales = $count_sales + 1;
            }
            $package->total_sales = $total_sales;
            $total_general_sales = $total_general_sales + $total_sales;
            $package->count_sales = $count_sales;
            $count_general_sales = $count_general_sales + $count_sales;
            if ($count_sales == 0){
                $package->average_sales = 0;
            } else {
                $package->average_sales = $total_sales / $count_sales;
            }

            $courses->add( $package );
        }

        return $courses;
	}

    public function getAllSalesByWeek($course){
        OrderCourse::where('course_id',$course)->where('status_id',4)->groupBy(function($date){
        });



    }

}