<?PHP namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Repositories\Backend\Course\CourseContract;
use App\Repositories\Backend\Partner\PartnerContract;
use App\Repositories\Backend\Report\StudentReportContract;
use App\Repositories\Backend\Studentgroup\StudentgroupContract;
use App\Services\UploadService\UploadService;
use App\Studentgroup;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Collection;

/**
 * Class DashboardControllerapp/Http/Controllers/Backend/ArticleController.php:7
 * @package App\Http\Controllers\Backend
 */
class StudentReportController extends Controller {

    /**
     * @param ArticleContract $articles
     * @param UserContract $users
     * @param UploadService $uploadService
     */
    public function __construct(StudentReportContract $studentreport, CourseContract $course, PartnerContract $partners, StudentgroupContract $studentgroups){
        $this->studentreport = $studentreport;
        $this->course = $course;
        $this->partners = $partners;
        $this->studentgroups = $studentgroups;
    }

    /**
     * @return mixed
     */
    public function executionsSaap(Request $request)
    {
        //All exams
        $exams = $this->studentreport->getAllExam();
        //Input
        $f_submit = $request->input('f_submit', '');
        //Date begin
        $f_StudentReportController_date_begin = get_parameter_or_session($request, 'f_StudentReportController_date_begin', '', $f_submit, format_datebr(Carbon::now()->addDays(-30)));
        //Date end
        $f_StudentReportController_date_end = get_parameter_or_session($request, 'f_StudentReportController_date_end', '', $f_submit, format_datebr(Carbon::now()));
        //Exam_id
        $f_StudentReportController_exam_id = get_parameter_or_session($request,'f_StudentReportController_exam_id', '', $f_submit, '');
        //Export to csv
        $f_StudentReportController_export_to_csv =  get_parameter_or_session($request, 'f_StudentController_export_to_csv', '', '1', '0');

        //All results
        $results = $this->studentreport->getStudentExecutionsSaapReports(
            $f_StudentReportController_date_begin,
            $f_StudentReportController_date_end,
            $f_StudentReportController_exam_id
        );
        //if $f_StudentReportController_export_to_csv == 1 else return for view
        if($f_StudentReportController_export_to_csv == '1'){
            $this->executions_to_csv_download($results);
        }else{
            return view('backend.reports.studentreport.executionsaap')
                ->withResults($results)
                ->withStudentreportcontrollerdatebegin($f_StudentReportController_date_begin)
                ->withStudentreportcontrollerdateend($f_StudentReportController_date_end)
                ->withStudentreportcontrollerexamid($f_StudentReportController_exam_id)
                ->withCountexecution($results->count())
                ->withExams($exams);
        }
    }

    private function executions_to_csv_download($executions, $delimiter=",") {
        // open raw memory as file so no temp files needed, you might run out of memory though
        $f = fopen('php://output', 'w');
        $filename = "exportacao_view_saap_" . time()  . ".csv";
        fputs($f, $bom =( chr(0xEF) . chr(0xBB) . chr(0xBF) ));
        header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename="'.$filename.'";');

        fputcsv(
            $f,
            [
                trans('strings.student'),
                trans('strings.user_email'),
                trans('strings.exam'),
                trans('strings.max_tries'),
                trans('strings.is_finished'),
                trans('menus.avg')
            ],
            ','
        );
        foreach($executions as $result){
            $line = [
                (isset($result->name))  ? $result->name : "",
                (isset($result->email)) ? $result->email : "",
                (isset($result->title)) ? $result->title : "",
                ($result->attempt.'/'. $result->max_tries),
                (format_datebr($result->finished_at) ? format_datebr($result->finished_at) : ""),
                (number_format(($result->grade / $result->questions_count) * 100, 1, '.', '.').'%'),

            ];
            fputcsv($f, $line, $delimiter);
        }
        fpassthru($f);
    }

    /**
     * @return mixed
     */
    public function performance(Request $request)
    {

        $f_submit = $request->input('f_submit', '');
        $f_StudentReportController_course_id = get_parameter_or_session(
            $request,
            'f_StudentReportController_course_id',
            '',
            $f_submit,
            ''
        );

        $f_StudentReportController_date_begin = get_parameter_or_session(
            $request,
            'f_StudentReportController_date_begin',
            '',
            $f_submit,
            format_datebr(Carbon::now()->addDays(-30))
        );

        $f_StudentReportController_date_end = get_parameter_or_session(
            $request,
            'f_StudentReportController_date_end',
            '',
            $f_submit,
            format_datebr(Carbon::now())
        );

        $f_StudentReportController_detail = get_parameter_or_session(
            $request,
            'f_StudentReportController_detail',
            '',
            $f_submit,
            '0'
        );

        $f_StudentReportController_partner_id = get_parameter_or_session(
            $request,
            'f_StudentReportController_partner_id',
            '',
            $f_submit,
            ''
        );

        $f_StudentReportController_studentgroup = get_parameter_or_session(
            $request,
            'f_StudentReportController_studentgroup',
            '',
            $f_submit,
            ''
        );

        $f_StudentReportController_studentname = get_parameter_or_session(
            $request,
            'f_StudentReportController_studentname',
            '',
            $f_submit,
            ''
        );

        $f_CourseController_export_to_csv = get_parameter_or_session(
            $request,
            'f_CourseController_export_to_csv',
            '',
            '1',
            '0'
        );

        $f_CouponController_coupon_code = get_parameter_or_session(
            $request,
            'f_CouponController_coupon_code',
            '',
            $f_submit,
            ''
        );

        $f_StudentReportController_studentgroup_id = null;
        if (($f_StudentReportController_studentgroup != null) && (isset($f_StudentReportController_studentgroup ))){
            $studentgroup = $this->studentgroups->getStundentGroupByPartnerAndName($f_StudentReportController_partner_id, $f_StudentReportController_studentgroup);
            if ($studentgroup != null){
                $f_StudentReportController_studentgroup_id = $studentgroup->id;
            }
        }
        $count_students = 0;

        if (($f_submit == '1')&& ($f_StudentReportController_course_id === '')) {
            redirect()->back()->withFlashSuccess(trans("alerts.report.select_course"));
        }

        $results = null;
        if ($f_submit == '1') {
            $results = $this->studentreport->getStudentPerformanceReports(
                $f_StudentReportController_date_begin,
                $f_StudentReportController_date_end,
                $f_StudentReportController_course_id,
                $f_StudentReportController_partner_id,
                $f_StudentReportController_studentgroup_id,
                $f_StudentReportController_studentname,
                $count_students,
                $f_CouponController_coupon_code
            );
        }
        // Wrap them in a collection.
        $collection = new Collection($results);



        // Sort descending by stars.
        $collection = $collection->sortByDesc(function($item){
            return $item->pace_needed;
        });
        if ($f_CourseController_export_to_csv == '1'){
            $this->performance_to_csv_download($collection);
        } else {
            $courses = $this->course->getAllCourses('title', 'asc');
            $partners = $this->partners->getAllPartners('name', 'asc');
            return view('backend.reports.studentreport.performance')
                ->withResults($collection)
                ->withStudentreportcontrollerdatebegin($f_StudentReportController_date_begin)
                ->withStudentreportcontrollerdateend($f_StudentReportController_date_end)
                ->withCountstudents($count_students)
                ->withCourses($courses)
                ->withPartners($partners)
                ->withStudentreportcontrollerdetail($f_StudentReportController_detail)
                ->withStudentreportcontrollercourseid($f_StudentReportController_course_id)
                ->withStudentreportcontrollerpartnerid($f_StudentReportController_partner_id)
                ->withStudentreportcontrollerstudentgroup($f_StudentReportController_studentgroup)
                ->withStudentreportcontrollerstudentname($f_StudentReportController_studentname)
                ->withStudentreportcontrollercouponcode($f_CouponController_coupon_code);
        }
    }

    function performance_to_csv_download($performances, $delimiter=",") {

        // open raw memory as file so no temp files needed, you might run out of memory though
        $f = fopen('php://output', 'w');

        $filename = "exportacao_performance_" . time()  . ".csv";

        fputs($f, $bom =( chr(0xEF) . chr(0xBB) . chr(0xBF) ));

        header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename="'.$filename.'";');

        fputcsv($f, [
            trans('strings.student'),
            trans('strings.user_email'),
            trans('strings.course'),
            trans('strings.studentgroup'),
            trans('strings.coupon'),
            trans('strings.percentage_discount'),
            trans('strings.date_begin'),
            trans('strings.date_end'),
            trans('strings.block_total'),
            trans('strings.block_views'),
            trans('strings.percentage_course'),
            trans('strings.pace_week'),
            trans('strings.percentage_to_finish'),
            trans('strings.pace_needed') ], ',');


        foreach ($performances as $result) {
            // generate csv lines from the inner arrays
            $line = array( ($result->student != null ? $result->student->name : ""),
                $result->student != null ? $result->student->email : "",
                ($result->course != null ? $result->course->title : ""),
                ($result->studentgroup != null ? $result->studentgroup->name : ""),
                (isset($result->order->coupon)) ? $result->order->coupon->code : "",
                (isset($result->order->coupon)) ? number_format($result->order->coupon->percentage, 0, ',', '.').'%' : "",
                format_datebr($result->date_begin),
                format_datebr($result->date_end),
                number_format($result->contents, 0, ',', '.' ),
                number_format($result->count_views, 0, ',', '.' ),
                number_format($result->percent_finished, 0, ',', '.' ) . '%',
                number_format($result->pace_per_week, 0, ',', '.' ) . ' p/s',
                number_format(100 - $result->percent_finished, 0, ',', '.' ) . '%',
                ($result->pace_needed === -1 ? '-' : number_format($result->pace_needed, 0, ',', '.' ) . ' p/s') );
            fputcsv($f, $line, $delimiter);
        }
        fpassthru($f);
    }


    public function demographics(Request $request) {

        $f_submit = $request->input('f_submit', '');

        $f_StudentReportController_course_id = get_parameter_or_session(
            $request,
            'f_StudentReportController_course_id',
            '',
            $f_submit,
            ''
        );

        $f_StudentReportController_date_begin = get_parameter_or_session(
            $request,
            'f_StudentReportController_date_begin',
            '',
            $f_submit,
            format_datebr(Carbon::now()->addDays(-30))
        );

        $f_StudentReportController_date_end = get_parameter_or_session(
            $request,
            'f_StudentReportController_date_end',
            '',
            $f_submit,
            format_datebr(Carbon::now())
        );

        $f_StudentReportController_dim1 = get_parameter_or_session(
            $request,
            'f_StudentReportController_dim1',
            '',
            $f_submit,
            ''
        );

        $f_StudentReportController_dim2 = get_parameter_or_session( $request, 'f_StudentReportController_dim2', '', $f_submit, '' );

        $f_StudentReportController_dim3 = get_parameter_or_session( $request, 'f_StudentReportController_dim3', '', $f_submit, '' );

        $count_students = 0;

        if (($f_submit == '1')&& ($f_StudentReportController_dim1 === '') && ($f_StudentReportController_dim2 === '') && ($f_StudentReportController_dim3 === '')) {
            redirect()->back()->withFlashSuccess(trans("alerts.report.select_at_least_one_dim"));
        }

        $results = null;
        //if ($f_submit == '1') {
        $results = $this->studentreport->getStudentDemographicsReports($f_StudentReportController_date_begin, $f_StudentReportController_date_end,
            $f_StudentReportController_course_id, $f_StudentReportController_dim1, $f_StudentReportController_dim2, $f_StudentReportController_dim3, $count_students);
        //}
//        // Wrap them in a collection.
//        $collection = new Collection($results);
//
//        // Sort descending by stars.
//        $collection = $collection->sortByDesc(function($item)
//        {
//            return $item->pace_needed;
//        });

        $courses = $this->course->getAllCourses('title', 'asc');

        return view('backend.reports.studentreport.demographics')
            ->withResults( $results )
            ->withStudentreportcontrollerdatebegin( $f_StudentReportController_date_begin )
            ->withStudentreportcontrollerdateend( $f_StudentReportController_date_end )
            ->withCountstudents( $count_students )
            ->withCourses( $courses )
            ->withStudentreportcontrollerdim1( $f_StudentReportController_dim1 )
            ->withStudentreportcontrollerdim2( $f_StudentReportController_dim2 )
            ->withStudentreportcontrollerdim3( $f_StudentReportController_dim3 )
            ->withStudentreportcontrollercourseid($f_StudentReportController_course_id);
    }


}
