<?php namespace App\Repositories\Backend\Report;

/**
 * Interface UserContract
 * @package App\Repositories\Article
 */
interface TeacherPaymentReportContract {

    public function getTeacherPaymentListReports($date_begin, $date_end, $teacher_id, &$total_payment, &$count_payment);


}