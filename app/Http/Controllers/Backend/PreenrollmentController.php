<?PHP namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Preenrollment\CreatePreenrollmentRequest;
use App\Http\Requests\Backend\Preenrollment\UpdatePreenrollmentRequest;
use App\Partner;
use App\Partnerorder;
use App\Preenrollment;
use App\Repositories\Backend\Partner\PartnerContract;
use App\Repositories\Backend\Course\CourseContract;
use App\Repositories\Backend\Preenrollment\PreenrollmentContract;
use App\Repositories\Backend\Studentgroup\StudentgroupContract;
use App\Services\UploadService\UploadService;
use App\Studentgroup;
use App\User;
use App\Role;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

/**
 * Class DashboardController
 * @package App\Http\Controllers\Backend
 */
class PreenrollmentController extends Controller {

    /**
     * @param PreenrollmentContract $preenrollments
     */
    public function __construct(PreenrollmentContract $preenrollments, UploadService $uploadService,
                                PartnerContract $partners, CourseContract $courses,
                                StudentgroupContract $studentgroups) {
        $this->preenrollments = $preenrollments;
        $this->uploadService = $uploadService;
        $this->partners = $partners;
        $this->courses = $courses;
        $this->studentgroups = $studentgroups;
    }

    /**
     * @return mixed
     */
    public function index(Request $request) {
        $request->session()->put('lastpage', $request->only('page')['page']);

        $f_submit = $request->input('f_submit', '');

        $f_PartnerController_partner_id = get_parameter_or_session( $request, 'f_PartnerController_partner_id', '', $f_submit, '' );

        $f_PartnerController_studentname = get_parameter_or_session( $request, 'f_PartnerController_name', '', $f_submit, '' );

        $f_PartnerController_status = get_parameter_or_session( $request, 'f_PartnerController_status', '', $f_submit, '0' );

        $f_CourseController_export_to_csv = get_parameter_or_session( $request, 'f_CourseController_export_to_csv', '', '1', '0' );

        $partners = $this->partners->getAllPartners('name', 'asc');


        if ($f_CourseController_export_to_csv == '1'){
            $preenrollments = $this->preenrollments->getPreenrollmentsPaginated(NULL, $f_PartnerController_partner_id, $f_PartnerController_studentname, $f_PartnerController_status, 'preenrollments.id', 'asc');
            $this->preenrollment_to_csv_download($preenrollments);
        } else {
            $preenrollments = $this->preenrollments->getPreenrollmentsPaginated(config('access.users.default_per_page'), $f_PartnerController_partner_id, $f_PartnerController_studentname, $f_PartnerController_status, 'preenrollments.id', 'asc');

            return view('backend.preenrollments.index')
                ->withPreenrollments($preenrollments)
                ->withPartners($partners)
                ->withPreenrollmentcontrollerpartnerid($f_PartnerController_partner_id)
                ->withPreenrollmentcontrollerstudentname($f_PartnerController_studentname)
                ->withPreenrollmentcontrollerstatus($f_PartnerController_status);
        }
    }

    function preenrollment_to_csv_download($preenrollments, $delimiter=",") {
        // open raw memory as file so no temp files needed, you might run out of memory though
        $f = fopen('php://output', 'w');

        $filename = "exportacao_prematriculas_" . time()  . ".csv";

        fputs($f, $bom =( chr(0xEF) . chr(0xBB) . chr(0xBF) ));

        header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename="'.$filename.'";');

        fputcsv($f, array('Aluno', 'E-mail', 'Parceiro', 'Turma', 'Curso', 'Data e-mail', 'Data prazo', utf8_encode('Data AtivaÃ§Ã£o')), ',');

        foreach ($preenrollments as $preenrollment) {
            // generate csv lines from the inner arrays
            $line = [
                $preenrollment->student->name,
                $preenrollment->student->email,
                $preenrollment->partner->name,
                $preenrollment->studentgroup->name,
                $preenrollment->course->title,
                format_br( $preenrollment->date_email, "d-m-Y"),
                format_br( $preenrollment->date_deadline, "d-m-Y" ),
                format_br( $preenrollment->date_activation, "d-m-Y" ) 
            ];
            fputcsv($f, $line, $delimiter);
        }
        fpassthru($f);
    }

    /**
     * @return mixed
     */
    public function create() {
        return '';
        $partners = $this->partners->getAllPartners('name', 'asc');
        $courses = $this->courses->getAllCourses('title', 'asc');
        return view('backend.preenrollments.create')
            ->withPartners( $partners )
            ->withCourses( $courses );
    }

    /**
     * @param CreatePreenrollmentRequest $request
     * @return mixed
     */
    public function store(CreatePreenrollmentRequest $request) {
        return '';
        $preenrollment = $this->preenrollments->create($request);

        if($request->hasFile('addimg')) {
            $upload_result = $this->uploadService->addImg($request->file('addimg'), $preenrollment->name, $preenrollment->id, 'preenrollments');
            if(!isset($upload_result['error'])) $this->preenrollments->updateImg($preenrollment->id, $upload_result['filename']);
        }

        return redirect()->route('admin.preenrollments.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.preenrollments.created"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit($id) {
        return '';
        $preenrollment = $this->preenrollments->findOrThrowException($id, true);

        return view('backend.preenrollments.edit')->withPreenrollment($preenrollment);
    }

    /**
     * @param $id
     * @param UpdatePreenrollmentRequest $request
     * @return mixed
     */
    public function update($id, UpdatePreenrollmentRequest $request) {
        return '';

        $preenrollment = $this->preenrollments->update($id, $request->except(['addimg']));

        if($request->hasFile('addimg')) {
            $upload_result = $this->uploadService->editImg($request->file('addimg'), $preenrollment->name, $preenrollment->id, 'preenrollments', $preenrollment->img_sizes);
            if(!isset($upload_result['error'])) $this->preenrollments->updateImg($preenrollment->id, $upload_result['filename']);
        }

        return redirect()->route('admin.preenrollments.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.preenrollments.updated"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id) {
        $preenrollment = $this->preenrollments->findOrThrowException($id, true);
        if ($preenrollment->date_activation != null){
            return redirect()->back()->withFlashDanger(trans("alerts.preenrollments.is_enrollment"));
        }

        $this->preenrollments->destroy($id);
        return redirect()->back()->withFlashSuccess(trans("alerts.preenrollments.deleted"));
    }

    public function addDayPreenrollment(Request $request, $preenrollment_id)
    {

        $preenrollment = $this->preenrollments->findOrThrowException($preenrollment_id, true);
        if ($preenrollment->date_activation != null){
            return redirect()->back()->withFlashDanger(trans("alerts.preenrollments.is_enrollment"));
        }
        $preenrollment->date_deadline = Carbon::parse($preenrollment->date_deadline )->addDay();
        $preenrollment->save();

        return redirect()->route('admin.preenrollments.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.preenrollments.dayadded"));
    }

    public function addWeekPreenrollment(Request $request, $preenrollment_id)
    {

        $preenrollment = $this->preenrollments->findOrThrowException($preenrollment_id, true);
        if ($preenrollment->date_activation != null){
            return redirect()->back()->withFlashDanger(trans("alerts.preenrollments.is_enrollment"));
        }
        $preenrollment->date_deadline = Carbon::parse($preenrollment->date_deadline )->addWeek();
        $preenrollment->save();

        return redirect()->route('admin.preenrollments.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.preenrollments.weekadded"));
    }

    /**
     * @return mixed
     */
    public function importSelectFile() {
        $partners = $this->partners->getAllPartners('name', 'asc');

        return view('backend.preenrollments.importselectfile')
            ->withPartners($partners);
    }


    /**
     * @return mixed
     */
    public function import(Request $request) {
        if($request->hasFile('importfile')) {
            $f_PreenrollmentController_partner_id = get_parameter_or_session( $request, 'partner_id', '', '', '' );

            $partner = $this->partners->findOrThrowException( $f_PreenrollmentController_partner_id );

            $ret = "";
            $row = 1;
            if (($handle = fopen($request->file('importfile')->getRealPath(), "r")) !== FALSE) {
                while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
                    $data = array_map("utf8_encode", $data); //added
                    $num = count($data);
                    if (($num == 6) && ($data[0] != 'NOME_COMP')) {
                        \DB::beginTransaction();
                        try{

                            $row++;
                            $name = $data[0];
                            $email = $data[1];
                            $partner_number = $data[2];
                            $phone = $data[3];
                            $external_course_id = $data[4];
                            $student_group = $data[5];

                            $partnerorders = Partnerorder::where('partner_id', '=', $partner->id)
                                ->where('external_course_id', 'like', $external_course_id)
                                ->where('is_active', '=', '1')
                                ->where('total_enrollments', '>', \DB::raw('used_enrollments'))
                                ->get();
                            if (count($partnerorders) != 0) {

                                $partnerorder = $partnerorders[0];
                                $course = $partnerorder->course;

                                $groups = Studentgroup::where('partner_id', '=', $partner->id)->where('name', 'like', $student_group)->get();
                                if (count($groups) == 0){
                                    $studentgroup = new Studentgroup;
                                    $studentgroup->partner_id = $partner->id;
                                    $studentgroup->name = $student_group;
                                    $studentgroup->save();
                                } else {
                                    $studentgroup = $groups[0];
                                }

                                $students = User::where('email', 'like', trim($email) )->get();
                                if (count($students) == 0){
                                    $student = new User;
                                    $student->email = trim($email);
                                    $student->name = $name;
                                    $student->password = $this->randomPassword();
                                    $student->status = 0;
                                    $student->cel = $phone;
                                    $student->video_quality = $partner->video_quality;
                                    $student->save();

                                    $role = Role::where('name', '=', 'Aluno')->first();
                                    $student->attachRole( $role  );
                                    $student->save();

                                } else {
                                    $student = $students[0];

                                    if (($student->name == null ) || ($student->name == '')){
                                        $student->name = $name;
                                        $student->save();
                                    }

                                    if (! $student->hasRole("Aluno")){
                                        $role = Role::where('name', '=', 'Aluno')->first();
                                        $student->attachRole( $role  );
                                        $student->save();
                                    }
                                }

                                $preenrollments = Preenrollment::where('course_id', '=', $course->id)
                                    ->where('student_id', '=', $student->id)
                                    ->where('course_id', '=', $course->id)
                                    ->where('partner_id', '=', $partner->id)
                                    ->where('studentgroup_id', '=', $studentgroup->id)
                                    ->whereNull('date_activation')
                                    ->get();
                                if (count($preenrollments) == 0){

                                    $preenrollment = new Preenrollment();
                                    $preenrollment->student_id = $student->id;
                                    $preenrollment->course_id = $course->id;
                                    $preenrollment->partner_id = $partner->id;
                                    $preenrollment->studentgroup_id = $studentgroup->id;
                                    $preenrollment->partnerorder_id = $partnerorder->id;
                                    $preenrollment->date_email = null;
                                    $preenrollment->date_deadline = null;
                                    $preenrollment->date_activation = null;
                                    $preenrollment->subscribe_key = $this->generateKey( $email . date_timestamp_get(Carbon:: now())  );
                                    $preenrollment->partner_number = $partner_number;
                                    $preenrollment->save();
                                } else {
                                    $preenrollment = $preenrollments[0];
                                }

                            }

                            \DB::commit();
                        } catch (Exception $e) {
                            \DB::rollback();
                        }
                    }
                }
                fclose ($handle);
            }
            return redirect()->route('admin.preenrollments.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.preenrollments.imported"));
        } else {
            return view('backend.preenrollments.index')->withFlashDanger(trans("alerts.preenrollments.importfilenotinformed"));
        }
    }

    function randomPassword() {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }

    function generateKey($data){
        return hash('md5', $data);
    }

    public function email($id, Request $request) {
        $preenrollment = $this->preenrollments->findOrThrowException( $id );
        if($preenrollment->date_activation == null) {

            $student = $preenrollment->student;

            try{
                Mail::send('emails.preenrollment',
                    ['preenrollment' => $preenrollment,
                        'partnerorder' => $preenrollment->partnerorder
                    ], function($message) use ( $preenrollment, $student )
                    {
                        $message->to($student->email, $student->name);
                        $message->subject(app_name() . ': ' . trans('strings.subscribe_to') . ' ' . $preenrollment->course->title );
                    });

                if ($preenrollment->date_email == null){
                    $date_email = Carbon::now();
                    $date_deadline = Carbon::now()->addDay( $preenrollment->partner->days_subscribe );
                    $preenrollment->date_email = $date_email;
                    $preenrollment->date_deadline = $date_deadline;
                    $preenrollment->save();
                }

            } catch (Exception $e) {
                return view('backend.preenrollments.index')->withFlashDanger(trans("alerts.preenrollments.error"));
            }
            return redirect()->back()->withFlashSuccess(trans("alerts.preenrollments.emailsent"));
        } else {
            return view('backend.preenrollments.index')->withFlashDanger(trans("alerts.preenrollments.active"));
        }
        throw new GeneralException('There was a problem sending email. Please try again.');
    }

    /**
     * @return mixed
     */
    public function studentGroups(Request $request) {
        $request->session()->put('lastpage', $request->only('page')['page']);

        $f_submit = $request->input('f_submit', '');

        $f_PartnerController_partner_id = get_parameter_or_session( $request, 'f_PartnerController_partner_id', '', $f_submit, '' );

        $partners = $this->partners->getAllPartners('name', 'asc');

        $studentgroups = $this->studentgroups->getStudentgroupsPaginated(config('access.users.default_per_page'), $f_PartnerController_partner_id, 'id', 'asc');

        return view('backend.preenrollments.studentgroups')
            ->withStudentgroups( $studentgroups )
            ->withPartners( $partners )
            ->withStudentgroupcontrollerpartnerid($f_PartnerController_partner_id);
    }


    /**
     * @return mixed
     */
    public function sendEmailList($f_PartnerController_studentgroup_id) {
        $preenrollments = $this->preenrollments->getPendingPreenrollmentsPerStudentgroup( $f_PartnerController_studentgroup_id, 'id', 'asc');

        $studentgroup = $this->studentgroups->findOrThrowException( $f_PartnerController_studentgroup_id );

        return view('backend.preenrollments.sendemaillist')
            ->withPreenrollments( $preenrollments )
            ->withStudentgroup( $studentgroup );
    }

    public function sendEmailStudentGroup(Request $request) {
        $studentgroup = $this->studentgroups->findOrThrowException( $request['f_PreenrollmentController_studentgroup_id'] );

        $preenrollments = $this->preenrollments->getPendingPreenrollmentsPerStudentgroup( $studentgroup->id, 'id', 'asc');

        $date_deadline = null;
        foreach ($preenrollments as $preenrollment) {

            if ($preenrollment->date_activation == null) {
                if ($date_deadline == null){
                    $date_email = Carbon::now();
                    $date_deadline = Carbon::now()->addDay( $preenrollment->partner->days_subscribe );
                }

                $student = $preenrollment->student;

                try{
                    Mail::send('emails.preenrollment',
                        ['preenrollment' => $preenrollment,
                            'partnerorder' => $preenrollment->partnerorder
                        ], function ($message) use ($preenrollment, $student) {
                            $message->to($student->email, $student->name);
                            $message->subject(app_name() . ': ' . trans('strings.subscribe_to') . ' ' . $preenrollment->course->title);
                        });

                    //caso tenha marcado reset
                    if (($request['f_PreenrollmentController_reset_date'] != null) && ($request['f_PreenrollmentController_reset_date'] == '1')){
                        $preenrollment->date_email = $date_email;
                        $preenrollment->date_deadline = $date_deadline;
                        $preenrollment->save();
                    }

                    //para primeiro envio
                    if ($preenrollment->date_email == null){
                        $preenrollment->date_email = $date_email;
                        $preenrollment->date_deadline = $date_deadline;
                        $preenrollment->save();
                    }
                } catch (Exception $e) {
                }

            }
        }
        return redirect()->route('admin.preenrollments.studentgroups')->withFlashSuccess(trans("alerts.preenrollments.emailsent"));

        throw new GeneralException('There was a problem creating this ticket. Please try again.');
    }

}