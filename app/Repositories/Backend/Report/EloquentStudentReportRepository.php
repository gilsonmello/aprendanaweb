<?php namespace App\Repositories\Backend\Report;

use App\Enrollment;
use App\Content;
use App\Execution;
use App\View;
use App\Exceptions\GeneralException;
use App\Exam;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


/**
 * Class EloquentArticleRepository
 * @package App\Repositories\Article
 */
class EloquentStudentReportRepository implements StudentReportContract {

    /**
     * Get all report execution the SAAP
     * @param date $date_begin
     * @param date $date_end
     * @param int $exam_id
     */
    public function getStudentExecutionsSaapReports($date_begin, $date_end, $exam_id){
        $query = Execution::where('executions.finished', '=', '1');
        $query->join('enrollments', 'executions.enrollment_id', '=', 'enrollments.id')
        ->join('exams', 'enrollments.exam_id', '=', 'exams.id')
        ->join('users', 'enrollments.student_id', '=', 'users.id')
        ->selectRaw('executions.*, users.*, enrollments.*, exams.*');

        if(isset($date_begin) && !empty($date_begin)){
            $query->where('executions.created_at', '>=', parsebr($date_begin));
        }
        if(isset($date_end) && !empty($date_end)){
            $query->where('executions.finished_at', '<=', parsebr($date_end));
        }
        if(isset($exam_id) && !empty($exam_id)){
            $query->where('exams.id', '=', $exam_id);
        }

        return $query->orderBy('users.name')->get();
    }

    /**
     * Get all Exams
     * @param string $order_by
     * @param string $sort
     */
    public function getAllExam($order_by = 'title', $sort = 'asc'){
        return Exam::orderBy($order_by, $sort)->get();
    }

    /**
     * Get all report performance
     * @param date $date_begin
     * @param date $date_end
     * @param int $course_id
     * @param int $partner_id
     * @param int $studentgroup_id
     * @param string $student_name
     * @param int &$count_student
     * @param string $couponname
     */
    public function getStudentPerformanceReports($date_begin, $date_end, $course_id, $partner_id, $studentgroup_id, $student_name, &$count_student, $coupon_name = ""){
        $query = Enrollment::where('is_active', '=', '1');
        if (isset($date_begin) && $date_begin != "") {
            $query->where('date_begin', '>=', parsebr($date_begin));
            //$query->where('date_end', '>=', parsebr($date_begin));
        }
        if (isset($date_end) && $date_end != "") {
            $query->where('date_begin', '<', parsebr($date_end)->addDay());
            //$query->where('date_end', '<', parsebr($date_end)->addDay());
        }

        if (isset($course_id) && $course_id != "")
            $query->where('course_id', '=', $course_id);

        if (isset($partner_id) && $partner_id != "")
            $query->where('enrollments.partner_id', '=', $partner_id);

        if (isset($studentgroup_id) && $studentgroup_id != ""){
            $query->join('studentgroups', 'enrollments.studentgroup_id', '=', 'studentgroups.id')
                ->where('studentgroups.id', '=', $studentgroup_id);
        }
        if (($student_name != null) && ($student_name != '')){
            $query->join('users', 'enrollments.student_id', '=', 'users.id')
                ->select('enrollments.*')
                ->where( 'users.name', 'like', '%' . $student_name . '%');
        }
        if (!empty($coupon_name) && isset($coupon_name)){
            $query->join('orders', 'enrollments.order_id', '=', 'orders.id')
                ->join('coupons', 'orders.coupon_id', '=', 'coupons.id')
                ->select('enrollments.*', 'coupons.name', 'coupons.code')
                ->where('coupons.code', 'like', '%'.$coupon_name.'%');
        }
        
        $query->orderBy('enrollments.date_begin', 'asc')->get();
        $enrollments = $query->get();

        $query = Content::query()
            ->join('lessons', 'lessons.id', '=', 'contents.lesson_id')
            ->join('modules', 'modules.id', '=', 'lessons.module_id')
            ->where( 'modules.course_id', '=', $course_id)
            ->where( 'contents.is_video', '=', 1)
            ->selectRaw('COUNT(name) as blocks');
        $blocks = $query->first()->blocks;

        $count_student = 0;
        foreach ($enrollments as $enrollment) {

            $query = View::where('enrollment_id', '=', $enrollment->id);

            $query->join('contents', 'view.content_id', '=', 'contents.id')
                ->join('lessons', 'lessons.id', '=', 'contents.lesson_id')
                ->select('view.*')
                ->where( 'contents.is_video', '=', 1);

            $views = $query->orderBy('created_at', 'asc')->get();
            $enrollment->views = $views;

            $count_views = 0;
            foreach ($views as $view){
                if ($view->view != 0){
                    $count_views = $count_views + 1;
                }
            }
            $enrollment->count_views = $count_views;

            $enrollment->contents = $blocks;

            if ($enrollment->contents === 0){
                $enrollment->contents = 1;
            }

            $date_to_end = null;

            if (($enrollment->date_end != null) && ($enrollment->date_begin != null)) {
                if ((new Carbon($enrollment->date_end))->gte(Carbon::now())) {
                    $weeks_to_end = (new Carbon($enrollment->date_end))->diffInWeeks(Carbon::now());
                    if ($weeks_to_end === 0) {
                        $weeks_to_end = 1;
                    }
                    $enrollment->pace_needed = ($enrollment->contents - $enrollment->count_views) / $weeks_to_end;
                    $date_to_end = Carbon::now();
                } else {
                    $enrollment->pace_needed = -1;
                    $date_to_end = new Carbon($enrollment->date_end);
                }

                $enrollment->percent_finished = $enrollment->count_views / $enrollment->contents * 100;
                $weeks_from_begin = (new Carbon($enrollment->date_begin))->diffInWeeks($date_to_end);
                if ($weeks_from_begin === 0) {
                    $weeks_from_begin = 1;
                }
                $enrollment->pace_per_week = $enrollment->count_views / $weeks_from_begin;
            }

            $count_student++;
//            if ($count_sales == 0){
//                $teacher->average_sales = 0;
//            } else {
//                $teacher->average_sales = $total_sales / $count_sales;
//            }
        }

        return $enrollments;
	}

    /**
     * Get demographics report the Students
     * @param date $date_begin
     * @param date $date_end
     * @param int $course_id
     * @param int $partner_id
     * @param int $studentgroup_id
     * @param string $student_name
     * @param int &$count_student
     * @param string $couponname
     */
    public function getStudentDemographicsReports($date_begin, $date_end, $course_id, $dim1, $dim2, $dim3, &$count_student){

        if ((($dim1 == null ) || ($dim1 === '')) && (($dim2 == null ) || ($dim2 === '')) && (($dim3 == null ) || ($dim3 === '')) ){
            return null;
        }

        $sql = 'SELECT count(*) count, ';
        if ($dim1 === 'G'){
            $sql .= ' users.gender as dim1, ';
        } else if ($dim1 === 'S'){
            $sql .= ' states.name as dim1, ';
        } else if ($dim1 === 'A'){
            $sql .= ' TRUNCATE( (DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(users.birthdate)),\'%Y\')+0) / 5, 0) * 5 as dim1, ';
        }
        if ($dim2 === 'G'){
            $sql .= ' users.gender as dim2, ';
        } else if ($dim2 === 'S'){
            $sql .= ' states.name as dim2, ';
        } else if ($dim2 === 'A'){
            $sql .= ' TRUNCATE((DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(users.birthdate)),\'%Y\')+0)/5, 0) * 5 as dim2, ';
        }
        if ($dim3 === 'G'){
            $sql .= ' users.gender as dim3, ';
        } else if ($dim3 === 'S'){
            $sql .= ' states.name as dim3, ';
        } else if ($dim3 === 'A'){
            $sql .= ' TRUNCATE((DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(users.birthdate)),\'%Y\')+0)/5, 0) * 5 as dim3, ';
        }

        $sql = substr($sql, 0, strlen($sql) - 2);


        $sql .= ' FROM enrollments, users, states, cities ';
        $sql .= ' WHERE is_active = 1 and cities.id = users.city_id and cities.state_id = states.id and enrollments.student_id = users.id ';
        $sql .= 'and partner_id is null and test = 0 ';
        if (isset($date_begin) && $date_begin != "") {
            $sql .= ' and date_begin >= :date_begin ';
        }
        if (isset($date_begin) && $date_end != "") {
            $sql .= ' and date_begin <= :date_end ';
        }

        if (isset($course_id) && $course_id != ""){
            $sql .= ' and course_id = :course_id ';
        }

        $sql .= ' group by ';
        if (($dim1 === 'G') || ($dim2 === 'G') || ($dim3 === 'G')){
            $sql .= ' users.gender, ';
        }
        if (($dim1 === 'S') || ($dim2 === 'S') || ($dim3 === 'S')){
            $sql .= ' states.name, ';
        }
        if (($dim1 === 'A') || ($dim2 === 'A') || ($dim3 === 'A')){
            $sql .= ' TRUNCATE((DATE_FORMAT(FROM_DAYS(TO_DAYS(NOW())-TO_DAYS(users.birthdate)),\'%Y\')+0)/5, 0) * 5, ';
        }

        $sql = substr($sql, 0, strlen($sql) - 2);

        $sql .= ' order by ';
        if ($dim1 != ''){
            $sql .= ' 2, ';
        }
        if ($dim2 != ''){
            $sql .= ' 3, ';
        }
        if ($dim3 != ''){
            $sql .= ' 4, ';
        }
        $sql .= ' 1';

        //$query->where('date_end', '>=', parsebr($date_begin));
        //$query->where('date_begin', '<', parsebr($date_end)->addDay());

        $parameters = null;
        if (isset($course_id) && $course_id != "") {
            $parameters = array('course_id' => $course_id, 'date_begin' => parsebr($date_begin)->addDay(), 'date_end' => parsebr($date_end)->addDay());
        } else {
            $parameters = array( 'date_begin' => parsebr($date_begin)->addDay(), 'date_end' => parsebr($date_end)->addDay() );
        }

        $results = DB::select( DB::raw($sql), $parameters );

        $tdim1 = "";
        $tdim2 = "";
        $tdim3 = "";

        $adim1 = array();
        $adim2 = array();
        $adim3 = array();

        $cdim1 = 0;
        $cdim2 = 0;
        $cdim3 = 0;

        $odim1 = null;
        $odim2 = null;
        $odim3 = null;

        $pos = 0;

        if (count($results) == 0){
            return $adim1;
        }

        foreach ($results as $i => $value) {

            if ($dim1 != ''){
                $results[$i]->dim1  = (($results[$i]->dim1 === null || $results[$i]->dim1 === '') ? '-' : $results[$i]->dim1);
            }
            if ($dim2 != ''){
                $results[$i]->dim2  = (($results[$i]->dim2 === null || $results[$i]->dim2 === '') ? '-' : $results[$i]->dim2);
            }
            if ($dim3 != ''){
                $results[$i]->dim3  = (($results[$i]->dim3 === null || $results[$i]->dim3 === '') ? '-' : $results[$i]->dim3);
            }

            if ( $results[$i]->dim1 != $tdim1){
                if ($i != 0){
                    if (isset($results[$i]->dim3)) {
                        $odim3['count'] = $cdim3;
                        $cdim3 = 0;
                        array_push($odim2['dim3'], $odim3);
                    }

                    if (isset($results[$i]->dim2)) {
                        $odim2['count'] = $cdim2;
                        $cdim2 = 0;
                        array_push($odim1['dim2'], $odim2);
                    }
                    $odim1['count'] = $cdim1;
                    $cdim1 = 0;
                    array_push( $adim1, $odim1);
                }
                $odim1['title'] = $results[$i]->dim1;
                if (isset($results[$i]->dim3)) {
                    $odim3['title'] = $results[$i]->dim3;
                    $odim2['dim3'] = $adim3;
                    $tdim3 = $results[$i]->dim3;
                }
                if (isset($results[$i]->dim2)) {
                    $odim2['title'] = $results[$i]->dim2;
                    $odim1['dim2'] = $adim2;
                    $tdim2 = $results[$i]->dim2;
                }

                $tdim1 = $results[$i]->dim1;
            } else if ((isset($results[$i]->dim2)) && ( $results[$i]->dim2 != $tdim2)){
                if ($i != 0){
                    if (isset($results[$i]->dim3)) {
                        $odim3['count'] = $cdim3;
                        $cdim3 = 0;
                        array_push($odim2['dim3'], $odim3);
                    }
                    $odim2['count'] = $cdim2;
                    $cdim2 = 0;
                    array_push( $odim1['dim2'], $odim2);
                }

                $odim2['title'] = $results[$i]->dim2;
                $tdim2 = $results[$i]->dim2;
                if (isset($results[$i]->dim3)) {
                    $odim3['title'] = $results[$i]->dim3;
                    $odim2['dim3'] = $adim3;
                }
            } else if ((isset($results[$i]->dim3)) && ( $results[$i]->dim3 != $tdim3)){
                if ($i != 0){
                    $odim3['count'] = $cdim3;
                    $cdim3 = 0;
                    array_push($odim2['dim3'], $odim3);
                }

                $odim3['title'] = $results[$i]->dim3;
            }


            $cdim1 = $cdim1 + $results[$i]->count;
            $cdim2 = $cdim2 + $results[$i]->count;
            $cdim3 = $cdim3 + $results[$i]->count;
            $count_student = $count_student + $results[$i]->count;
            $pos = $i;
        }

        if (isset($results[$pos]->dim3)) {
            $odim3['count'] = $cdim3;
            array_push($odim2['dim3'], $odim3);
        }

        if (isset($results[$pos]->dim2)) {
            $odim2['count'] = $cdim2;
            array_push($odim1['dim2'], $odim2);
        }
        $odim1['count'] = $cdim1;
        array_push( $adim1, $odim1);
        $odim1['title'] = $results[$pos]->dim1;
        if (isset($results[$pos]->dim2)) {
            $odim2['title'] = $results[$pos]->dim2;
            $odim1['dim2'] = $adim2;
        }
        if (isset($results[$pos]->dim3)) {
            $odim3['title'] = $results[$pos]->dim3;
            $odim2['dim3'] = $adim3;
        }

        return $adim1;

//        $count_student = 0;
//        foreach ($enrollments as $enrollment) {
//
//            $query = View::where('enrollment_id', '=', $enrollment->id);
//
//            $query->join('contents', 'view.content_id', '=', 'contents.id')
//                ->join('lessons', 'lessons.id', '=', 'contents.lesson_id')
//                ->select('view.*')
//                ->where( 'contents.is_video', '=', 1);
//
//            $views = $query->orderBy('created_at', 'asc')->get();
//
//            $enrollment->views = $views;
//
//            $count_views = 0;
//            foreach ($views as $view){
//                if ($view->view != 0){
//                    $count_views = $count_views + 1;
//                }
//            }
//            $enrollment->count_views = $count_views;
//
//            $enrollment->contents = $blocks;
//
//            if ($enrollment->contents === 0){
//                $enrollment->contents = 1;
//            }
//
//            $date_to_end = null;
//
//            if (($enrollment->date_end != null) && ($enrollment->date_begin != null)) {
//                if ((new Carbon($enrollment->date_end))->gte(Carbon::now())) {
//                    $weeks_to_end = (new Carbon($enrollment->date_end))->diffInWeeks(Carbon::now());
//                    if ($weeks_to_end === 0) {
//                        $weeks_to_end = 1;
//                    }
//                    $enrollment->pace_needed = ($enrollment->contents - $enrollment->count_views) / $weeks_to_end;
//                    $date_to_end = Carbon::now();
//                } else {
//                    $enrollment->pace_needed = -1;
//                    $date_to_end = new Carbon($enrollment->date_end);
//                }
//
//                $enrollment->percent_finished = $enrollment->count_views / $enrollment->contents * 100;
//                $weeks_from_begin = (new Carbon($enrollment->date_begin))->diffInWeeks($date_to_end);
//                if ($weeks_from_begin === 0) {
//                    $weeks_from_begin = 1;
//                }
//                $enrollment->pace_per_week = $enrollment->count_views / $weeks_from_begin;
//            }
//
//            $count_student++;
////            if ($count_sales == 0){
////                $teacher->average_sales = 0;
////            } else {
////                $teacher->average_sales = $total_sales / $count_sales;
////            }
//        }
//
//        return $enrollments;
    }



}