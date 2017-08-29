<?php namespace App\Repositories\Backend\Report;

use App\TeacherStatement;
use App\User;
use App\Exceptions\GeneralException;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


/**
 * Class EloquentArticleRepository
 * @package App\Repositories\Article
 */
class EloquentTeacherPaymentReportRepository implements TeacherPaymentReportContract {


    public function getTeacherPaymentListReports($date_begin, $date_end, $teacher_id, &$total_payment, &$count_payment){
        $query = User::teachers();
        if (isset($teacher_id) && $teacher_id != "")
            $query->where('id', '=', $teacher_id);

        $query->orderBy('name', 'asc');
        $teachers = $query->get();

        $total_payment = 0;
        $count_payment = 0;
        foreach ($teachers as $teacher) {

            $query = TeacherStatement::where('value', '>', 0)
                ->where('user_teacher_id', '=', $teacher->id );

            if (isset($date_begin) && $date_begin != "")
                $query->where('date', '>=', parsebr($date_begin));
            if (isset($date_begin) && $date_end != "")
                $query->where('date', '<', parsebr($date_end)->addDay());

            $payments = $query->orderBy('date', 'asc')->orderBy('date', 'asc')->get();

            $teacher->payments = $payments;

            $total_sales = 0;
            $count_sales = 0;
            foreach ($payments as $payment){
                $total_sales = $total_sales + $payment->value;
                $count_sales = $count_sales + 1;
            }
            $teacher->total_sales = $total_sales;
            $total_payment = $total_payment + $total_sales;
            $teacher->count_sales = $count_sales;
            $count_payment = $count_payment + $count_sales;
            if ($count_sales == 0){
                $teacher->average_sales = 0;
            } else {
                $teacher->average_sales = $total_sales / $count_sales;
            }
        }

        return $teachers;
	}

}