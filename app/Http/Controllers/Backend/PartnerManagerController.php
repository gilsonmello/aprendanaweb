<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\PartnerManager\CreatePartnerManagerRequest;
use App\Repositories\Backend\PartnerManager\PartnerManagerContract;
use App\Repositories\Backend\Report\StudentReportContract;
use Carbon\Carbon;
use App\Repositories\Backend\User\UserContract;
use Illuminate\Http\Request;

class PartnerManagerController extends Controller
{

    /**
     * @param PartnerManagerContract $partnermanagers
     */
    public function __construct(PartnerManagerContract $partnermanagers, StudentReportContract $studentreport)
    {
        $this->partnermanagers = $partnermanagers;
        $this->studentreport = $studentreport;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function accompaniment(Request $request)
    {
        $request->session()->put('lastpage', $request->only('page')['page']);

        $f_submit = $request->input('f_submit', '');

        $f_PartnerManagerController_partner_id = get_parameter_or_session($request, 'f_PartnerManagerController_partner_id', '', $f_submit, '');

        $f_PartnerManagerController_user_name = get_parameter_or_session($request, 'f_PartnerManagerController_user_name', '', $f_submit, '');

        $f_PartnerManagerController_date_begin = get_parameter_or_session($request, 'f_PartnerManagerController_date_begin', '', $f_submit, '');

        $f_PartnerManagerController_date_end = get_parameter_or_session($request, 'f_PartnerManagerController_date_end', '', $f_submit, '');

        $f_PartnerManagerController_course_id = get_parameter_or_session($request, 'f_PartnerManagerController_course_id', '', $f_submit, 52);

        $f_PartnerManagerController_studentgroup = get_parameter_or_session(
            $request, 'f_PartnerManagerController_studentgroup', '', $f_submit, ''
        );

        $count_student = 0;

        return view('backend.partnermanagers.accompaniment')
            ->withResults($this->partnermanagers->usersPartnerPerfomance(
                config('access.users.default_per_page'), $f_PartnerManagerController_partner_id, $f_PartnerManagerController_user_name, $f_PartnerManagerController_date_begin, $f_PartnerManagerController_date_end, $f_PartnerManagerController_course_id, $f_PartnerManagerController_studentgroup, $count_student
            )
            )
            ->withPartnermanagercontrollerpartnerid($f_PartnerManagerController_partner_id)
            ->withPartnermanagercontrollerusername($f_PartnerManagerController_user_name)
            ->withPartnermanagercontrollerdatebegin($f_PartnerManagerController_date_begin)
            ->withPartnermanagercontrollerdateend($f_PartnerManagerController_date_end)
            ->withPartnermanagercontrollercourseid($f_PartnerManagerController_course_id)
            ->withPartnermanagercontrollerstudentgroup($f_PartnerManagerController_studentgroup)
            ->withPartnerusers($this->partnermanagers->allPartnersUser())
            ->withCourses($this->partnermanagers->allCourses())
            ->withPartnermanagercontrollercountstudent($count_student);
    }

    /**
     * Show the form for creating a new resource.
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //Get id partner
        $partner_id = $request->request->get('f_partner_id');

        //Return for view create
        return view('backend.partnermanagers.create')
            ->withPartnerid($partner_id)
            ->withUsers($this->partnermanagers->allUsers())
            ->withPartner($this->partnermanagers->getPartner($partner_id, 'id', 'asc'))
            ->withPartnermanagers($this->partnermanagers->getAllPartnerManagers($partner_id));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CreatePartnerManagerRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreatePartnerManagerRequest $request)
    {
        //Inserting records into the database
        $this->partnermanagers->create($request);

        //Redirecting to the index of partners
        return redirect()->route('admin.partners.index', [
            'page' => $request->session()->get('lastpage', '1')
        ])
            ->withFlashSuccess(trans("alerts.partnermanager.created_or_update"));
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
        $date_begin = get_parameter_or_session($request, 'f_PartnerManagerController_date_begin', '', $f_submit, format_datebr(Carbon::now()->addDays(-30)));
        //Date end
        $date_end = get_parameter_or_session($request, 'f_PartnerManagerController_date_end', '', $f_submit, format_datebr(Carbon::now()));
        //Exam_id
        $exam_id = get_parameter_or_session($request, 'f_PartnerManagerController_exam_id', '', $f_submit, '');
        //Partner_id
        $partner_id = get_parameter_or_session($request, 'f_PartnerManagerController_partner_id', '', $f_submit, '');
        //Name
        $name = get_parameter_or_session($request, 'f_PartnerManagerController_user_name', '', $f_submit, '');
        //Student_group
        $student_group = get_parameter_or_session($request, 'f_PartnerManagerController_studentgroup', '', $f_submit, '');
        //Export to csv
        $export_to_csv = get_parameter_or_session($request, 'f_PartnerManagerController_export_to_csv', '', '1', '0');

        //All results
        $results = $this->partnermanagers->executionSaap(
            config('access.users.default_per_page'),
            $date_begin,
            $date_end,
            $exam_id,
            $partner_id,
            $name,
            $student_group
        );
        //if $export_to_csv == 1 else return for view
        if ($export_to_csv == '1') {
            $this->executions_to_csv_download($results);
        } else {
            return view('backend.partnermanagers.executionsaap')
                ->withResults($results)
                ->withPartnermanagercontrollerpartnerid($partner_id)
                ->withStudentreportcontrollerdatebegin($date_begin)
                ->withStudentreportcontrollerdateend($date_end)
                ->withStudentreportcontrollerexamid($exam_id)
                ->withPartnermanagercontrollerusername($name)
                ->withPartnermanagercontrollerstudentgroup($student_group)
                ->withExams($exams)
                ->withPartnerusers($this->partnermanagers->allPartnersUser());
        }
    }

    private function executions_to_csv_download($executions, $delimiter = ",")
    {
        // open raw memory as file so no temp files needed, you might run out of memory though
        $f = fopen('php://output', 'w');
        $filename = "exportacao_view_saap_" . time() . ".csv";
        fputs($f, $bom = (chr(0xEF) . chr(0xBB) . chr(0xBF)));
        header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '";');

        fputcsv(
            $f, [
            trans('strings.partner'),
            trans('strings.studentgroup'),
            trans('strings.student'),
            trans('strings.user_email'),
            trans('strings.exam'),
            trans('strings.max_tries'),
            trans('strings.is_finished'),
            trans('menus.avg')
        ], ','
        );
        foreach ($executions as $result) {
            $line = [
                $result->partners_name != null ? $result->partners_name : "",
                $result->studentgroups_name != null ? $result->studentgroups_name : "",
                $result->users_name != null ? $result->users_name : "",
                !empty($result->users_email) ? $result->users_email : "",
                $result->exams_title,
                $result->executions_attempt . ' de ' . $result->max_tries,
                (format_datebr($result->finished_at) ? format_datebr($result->finished_at) : ""),
                (number_format(($result->executions_grade / $result->questions_count) * 100, 1, '.', '.') . '%'),
            ];
            fputcsv($f, $line, $delimiter);
        }
        fpassthru($f);
    }

    public function performanceInSaap(Request $request){
        //All exams
        $exams = $this->studentreport->getAllExam();

        //dd($request->all());
        $courses = \App\Course::courses();
        //Input
        $f_submit = $request->input('f_submit', '');

        //Course_id
        $course_id = get_parameter_or_session($request, 'f_PartnerManagerController_course_id', '', $f_submit, '');

        //Date begin
        $date_begin = get_parameter_or_session($request, 'f_PartnerManagerController_date_begin', '', $f_submit, format_datebr(Carbon::now()->addDays(-30)));
        //Date end
        $date_end = get_parameter_or_session($request, 'f_PartnerManagerController_date_end', '', $f_submit, format_datebr(Carbon::now()));
        //Exam_id
        $exam_id = get_parameter_or_session($request, 'f_PartnerManagerController_exam_id', '', $f_submit, '');
        //Partner_id
        $partner_id = get_parameter_or_session($request, 'f_PartnerManagerController_partner_id', '', $f_submit, '');
        //Name
        $name = get_parameter_or_session($request, 'f_PartnerManagerController_user_name', '', $f_submit, '');
        //Student_group
        $student_group = get_parameter_or_session($request, 'f_PartnerManagerController_studentgroup', '', $f_submit, '');
        //Export to csv
        $export_to_csv = get_parameter_or_session($request, 'f_PartnerManagerController_export_to_csv', '', '1', '0');

        //All results
        $results = $this->partnermanagers->getPerformanceInSaap(
            config('access.users.default_per_page'),
            $date_begin,
            $date_end,
            $course_id,
            $partner_id,
            NULL,
            NULL,
            NULL,
            $student_group
        );
        //if $export_to_csv == 1 else return for view
        if ($export_to_csv == '1') {
            $this->executions_to_csv_download($results);
        } else {
            return view('backend.partnermanagers.performancesaap')
                ->withResults($results)
                ->withPartnermanagercontrollerpartnerid($partner_id)
                ->withStudentreportcontrollerdatebegin($date_begin)
                ->withStudentreportcontrollerdateend($date_end)
                ->withStudentreportcontrollerexamid($exam_id)
                ->withPartnermanagercontrollerusername($name)
                ->withPartnermanagercontrollerstudentgroup($student_group)
                ->withPartnermanagercontrollercourseid($course_id)
                ->withExams($exams)
                ->withPartnerusers($this->partnermanagers->allPartnersUser())
                ->withCourses($courses);
        }

    }

}
