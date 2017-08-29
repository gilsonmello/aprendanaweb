<?php namespace App\Repositories\Backend\Report;

/**
 * Interface UserContract
 * @package App\Repositories\Article
 */
interface CourseReportContract {

    public function getCourseSalesReports($date_begin, $date_end, $course_id, &$total_general_sales, &$count_general_sales, $only_paid, $partner_id);


    public function getAllSalesByWeek($course);

}