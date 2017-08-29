<?php

namespace App\Http\Controllers\Frontend;

use App\ContentComment;
use App\EventModel;
use App\Http\Controllers\Controller;
use App\MyWorkshopActivity;
use App\Repositories\Frontend\WorkshopActivity\MyWorkshopActivityTimeContract;
use App\WorkshopActivity;
use App\MyWorkshopEvaluation;
use App\MyWorkshopTutor;
use App\Workshop;
use App\QuestionsExecution;
use App\Repositories\Backend\Module\ModuleContract;
use App\Repositories\Backend\Sector\SectorContract;
use App\Repositories\Backend\Ticket\TicketContract;
use App\Repositories\Frontend\ContentComments\ContentCommentsContract;
use App\Repositories\Frontend\Course\CourseContract;
use App\Repositories\Frontend\Criterion\CriterionContract;
use App\Repositories\Frontend\Exam\ExamContract;
use App\Repositories\Frontend\Execution\ExecutionContract;
use App\Repositories\Frontend\Lesson\LessonContract;
use App\Repositories\Frontend\Enrollment\EnrollmentContract;
use App\Repositories\Frontend\ContentNotes\ContentNotesContract;
use App\Repositories\Frontend\QuestionsExecution\QuestionsExecutionContract;
use App\Repositories\Frontend\StudyPlan\StudyPlanContract;
use App\Repositories\Frontend\View\ViewContract;
use App\Repositories\Frontend\CourseAlert\CourseAlertContract;
use App\Repositories\Frontend\CourseCalendar\CourseCalendarContract;
use App\WorkshopCriteria;
use Carbon\Carbon;
use Illuminate\Http\Request;
//use App\Http\Requests\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Frontend\AskTheTeacher\AskTheTeacherContract;
use FPDI;
use Illuminate\Support\Facades\Log;
use App\Services\UploadService\UploadService;

/**
 * Class DashboardController
 * @package App\Http\Controllers\Frontend
 */
class ClassroomController extends Controller {

    public function __construct(CourseContract $courses, ModuleContract $modules, LessonContract $lessons, EnrollmentContract $enrollment, ContentNotesContract $contentNotes, ContentCommentsContract $contentComments, ViewContract $view, CriterionContract $criterion, CourseAlertContract $alerts, CourseCalendarContract $calendars, AskTheTeacherContract $askTheTeacher, StudyPlanContract $studyPlan, SectorContract $sectors, TicketContract $tickets, ExamContract $exams, QuestionsExecutionContract $questionsExecution, ExecutionContract $executions, UploadService $uploadService, MyWorkshopActivityTimeContract $myWorkshopActivityTime) {
        $this->courses = $courses;
        $this->modules = $modules;
        $this->lessons = $lessons;
        $this->enrollment = $enrollment;
        $this->contentNotes = $contentNotes;
        $this->contentComments = $contentComments;
        $this->view = $view;
        $this->criterion = $criterion;
        $this->alerts = $alerts;
        $this->calendars = $calendars;
        $this->askTheTeacher = $askTheTeacher;
        $this->studyPlan = $studyPlan;
        $this->sectors = $sectors;
        $this->tickets = $tickets;
        $this->exams = $exams;
        $this->questionsExecution = $questionsExecution;
        $this->executions = $executions;
        $this->uploadService = $uploadService;
        $this->myWorkshopActivityTime = $myWorkshopActivityTime;
    }

    /**
     * @return mixed
     */
    public function indexLesson($lesson_id) {

        $lesson = $this->lessons->findOrThrowException($lesson_id);
        $content = $lesson->contents->where('sequence', "1")->first();
        $user = Auth::user();


        if ($this->enrollment->isStudentEnrolledLesson($user->id, $lesson->id)) {

            $enrollment = $this->enrollment->getStudentEnrollmentLesson($user->id, $lesson_id)->first();
            $view = $this->view->findByEnrollmentAndContent($enrollment->id, $content->id);
            if ($view->isEmpty()) {
                $view = $this->view->createView($enrollment, $content, 2);
            } else {
                $view = $view->first();
            }

            return view('frontend.studentarea.classroom.index')->withContent($content) > withType('lesson')->withEnrollment($enrollment)->withSector($this->sectors->getAllSectorsNoUsers());
        }
    }

    public function indexCourse(Request $request, $course_id, $module_id, $lesson_id, $actual_content = 1, $actual_enrollment = 0) {
        $course = $this->courses->findOrThrowException($course_id);

        $module = $course->modules->find($module_id);

        $lesson = $module->lessons->find($lesson_id);

        $content = $lesson->contents->whereLoose('sequence', $actual_content)->first();

        if (starts_with($content->url, 'http://')) {
            $content->url = 'https://' . substr($content->url, 7);
        }

        $files = $lesson->contents->whereLoose('sequence', '0');
        $user = Auth::user();
        //dd($course->id);
        if ($this->enrollment->isStudentEnrolledCourse($user->id, $course->id)) {

            if ($actual_enrollment == 0) {
                $enrollment = $this->enrollment->getStudentEnrollmentCourse($user->id, $course_id);
                if (count($enrollment) > 1) {
                    $enrollment = $enrollment->whereLoose('is_active', 1);
                    if (!$enrollment->isEmpty()) {
                        $enrollment = $enrollment->first();
                        if (Carbon::today()->gt(new Carbon($enrollment->date_end)))
                            return redirect()->route('frontend.classroom.course', $enrollment->id);
                    } else {
                        $enrollment = $this->enrollment->getStudentEnrollmentCourse($user->id, $course_id)->first();
                        return redirect()->route('frontend.classroom.course', $enrollment->id);
                    }
                } else {
                    $enrollment = $this->enrollment->getStudentEnrollmentCourse($user->id, $course_id)->first();
                }
            } else {
                $enrollment = $this->enrollment->find($actual_enrollment);
                if ($enrollment->is_active == 0 || Carbon::today()->gt(new Carbon($enrollment->date_end)))
                    return redirect()->route('frontend.classroom.course', $enrollment->id);
            }

            $lessons = $this->lessons->getAllLessonsByModule($module->id);
            foreach ($lessons as $lessonlist) {
                $active = false;
                if ($lessonlist->id == $lesson_id)
                    $active = true;
                $lessonlist->viewed = $this->view->lessonViewed($enrollment->id, $lessonlist, $active);
            }

            $modules = $course->modules;
            foreach ($modules as $modulelist) {
                $modulelist->percentage_viewed = $this->view->modulePercentageViewed($enrollment->id, $modulelist);
            }


            $view = $this->view->findByEnrollmentAndContent($enrollment->id, $content->id);

            if ($view->isEmpty()) {
                $view = $this->view->createView($enrollment, $content, $enrollment->course->max_view);
            } else {
                $view = $view->first();
                if ($view->percent > 70) {
                    $accumulated_percent = $view->percent + $view->accumulated_percent;
                    $percent = 0;
                    $this->view->updatePercentageForNewView($view->id, $percent, $accumulated_percent);
                }
            }
            $criteria = $this->criterion->getAllCriteria();

            $view_log = $this->view->createViewLog($enrollment->id, $content->id);
            $view_log->user_agent = $request->header('User-Agent');
            $view_log->ip = \Illuminate\Support\Facades\Request::ip();
            $view_log->save();
            $criteria = $this->criterion->getAllCriteria();

            if (Auth::user()->video_quality == 1) {

                $content->url = $content->url . '?quality=360p';
            }

            $has_exam = $course->groups != null && !$course->groups->isEmpty();

            return view('frontend.studentarea.classroom.index')
                            ->withContent($content)
                            ->withFiles($files)
                            ->withType('course')
                            ->withEnrollment($enrollment)
                            ->withActualContent($actual_content)
                            ->withCriteria($criteria)
                            ->withLessons($lessons)
                            ->withModules($modules)
                            ->withSector($this->sectors->getAllSectorsNoUsers())
                            ->withView($view)
                            ->withCourseExam($has_exam)
                            ->withLesson($lesson);
        }
        
    }

    public function indexModule($module_id, $lesson_id) {

        $module = $this->modules->findOrThrowException($module_id);
        $lesson = $module->lessons->find($lesson_id);
        $content = $lesson->contents->whereLoose('sequence', "1")->first();
        $user = Auth::user();



        if ($this->enrollment->isStudentEnrolledModule($user->id, $module->id)) {
            $enrollment = $this->enrollment->getStudentEnrollmentModule($user->id, $module_id)->first();
            $view = $this->view->findByEnrollmentAndContent($enrollment->id, $content->id);
            if ($view->isEmpty()) {
                $view = $this->view->createView($enrollment, $content, 2);
            } else {
                $view = $view->first();
            }
            return view('frontend.studentarea.classroom.index')->withContent($content) > withType('module')->withEnrollment($enrollment)->withSector($this->sectors->getAllSectorsNoUsers());
        }
    }

    public function getVideoBlock() {

        $lesson = $this->lessons->findOrThrowException($_POST['lesson']);

        $content = $lesson->contents->whereLoose('sequence', $_POST['block'])->first();

        if (Auth::user()->video_quality == 1) {

            $content->url = $content->url . '?quality=360p';
        }

        return json_encode($content);
    }

    public function saveNotes() {
        $input = [];
        $input['note'] = $_POST['note'];
        $input['seconds'] = round($_POST['starting_time']);
        $input['student'] = Auth::user()->id;
        $input['content'] = $_POST['content'];

        $this->contentNotes->createNote($input);


        return "";
    }

    public function getNotes() {
        $student_id = Auth::user()->id;
        $content_id = $_POST['content'];

        $notes = json_encode($this->contentNotes->getNotesByStudentOnContent($student_id, $content_id)->get());

        return $notes;
    }

    public function deleteNotes() {
        $this->contentNotes->destroy($_POST['note']);
        return "";
    }

    public function getComments() {
        $content_id = $_POST['content'];
        $comments = $this->contentComments->getCommentsOnContent($content_id);


        return json_encode($comments);
    }

    public function postComment(Request $request) {
        $comment = $request['comment'];
        $content = $request['content'];
        $publisher = Auth::user()->id;

        $this->contentComments->createComment($content, $comment, $publisher);

        $comment['content'] = "----Seu comentário está pendente de aprovação----\n" . $comment['content'];
        return $comment;
    }

    public function getView(Request $request) {
        $enrollment_id = $_POST['enrollment'];
        $content_id = $_POST['content'];




        $view = $this->view->findByEnrollmentAndContent($enrollment_id, $content_id);


        $view_log = $this->view->createViewLog($enrollment_id, $content_id);
        $view_log->user_agent = $request->header('User-Agent');
        $view_log->save();
        Log::info('Capturando view_log ' . $view_log->id . ' vw' . Auth::user()->id . "usr");
        if ($request->session()->has('view_log')) {
            $request->session()->forget('view_log');
        }



        $request->session()->put('view_log', $view_log);

        Log::info('After get: ' . $request->session()->get('view_log')->id . ' vw' . Auth::user()->id . "user");

        if ($view->isEmpty() || $view === null) {
            $enrollment = $this->enrollment->find($enrollment_id);
            $view = $this->view->createView($enrollment_id, $content_id, $enrollment->course->max_view);
        } else {
            $view = $view->first();
            if ($view->percent > 80) {
                $accumulated_percent = $view->percent + $view->accumulated_percent;
                $percent = 0;
                $this->view->updatePercentageForNewView($view->id, $percent, $accumulated_percent);
            }
        }
        return $view;
    }

    public function saveState() {
        //Nota: A coluna utilizada no mysql vai suportar, no máximo, 160 visualizações para um mesmo conteudo da
        // mesma pessoa. Caso se veja a necessidade de criar um limite maior que 160, mudar o campo para text.
        $content_id = $_POST['content'];
        $percentual = $_POST['percentual'];
        $state = $_POST['state'];
        $actual_enrollment = $_POST['enrollment'];
        $actual_count = $_POST['count'];


        if ($actual_count === null)
            return;

        $this->view->saveState($actual_enrollment, $content_id, $state, $percentual, $actual_count);

        return $percentual;
    }

    public function saveViewTime(Request $request) {
        //$view_log = $request->session()->get('view_log');

        $view_log = $this->view->getLastViewLog($_POST['enrollment'], $_POST['content']);

        Log::info("View_log atual é " . $view_log->id . " com o content " . $view_log->content_id . ' vw' . Auth::user()->id . "usr");
        $watched_time = $_POST['watched_time'];
        if ($view_log == null)
            return;
        if ($view_log->watched_time === null || $view_log->watched_time === 0) {
            $view_log->watched_time = $watched_time;
        } else {
            $view_log->watched_time += $watched_time;
        }

        $view_log->save();
    }

    public function saveLike() {
        $view = $this->view->saveLike($_POST['view'], $_POST['up_down'], $_POST['criteria']);
        return;
    }

    public function saveEnrollmentRating() {
        if (isset($_POST['criteria'])) {
            $this->enrollment->saveCriteriaRating($_POST['enrollment'], $_POST['rating'], $_POST['criteria']);
            $this->enrollment->saveRating($_POST['enrollment'], $_POST['rating']);
            return;
        }


        if (isset($_POST['enrollment']))
            $this->enrollment->saveRating($_POST['enrollment'], $_POST['rating']);
        return;
    }

    function getTotalPercentageCompleted($enrollment) {
        return get_total_percentage_completed($enrollment);
    }

    function needsRating() {
        $enrollment = $this->enrollment->find($_POST['enrollment']);


        if ($enrollment->rating == null || $enrollment->rating == 0 || $enrollment->ratings->isEmpty()) {
            $total = $this->getTotalPercentageCompleted($enrollment);
            if ($enrollment->lesson_id != null) {
                if ($total >= 75) {
                    return 'true';
                } else {
                    return 'false';
                }
            } else if ($enrollment->module_id != null) {
                if ($enrollment->module->lessons->count() < 3) {
                    if ($total >= 80) {
                        return 'true';
                    } else {
                        return 'false';
                    }
                } else {
                    if ($total >= 88) {
                        return 'true';
                    } else {
                        return 'false';
                    }
                }
            } else {

                if ($total >= 75) {
                    return 'true';
                } else {
                    return 'false';
                }
            }
        } else {
            return 'false';
        }
    }

    function courseContent() {
        $course = $this->courses->findOrThrowException($_POST['course']);
        return $course->course_content;
    }

    function courseTerms() {
        return view('frontend.institutional.termstext');
    }

    function courseAlerts() {
        $course = $this->courses->findOrThrowException($_POST['course']);
        $alerts = $this->alerts->getAllCoursesAlertsPerCourse($course);
        return view('frontend.studentarea.coursealerts')->withAlerts($alerts);
    }

    function courseCalendar() {
        $course = $this->courses->findOrThrowException($_POST['course']);
        $calendars = $this->calendars->getAllCoursesCalendarsPerCourse($course);
        return view('frontend.studentarea.coursecalendars')->withCalendars($calendars);
    }

    function courseModules() {
        $course = $this->courses->findOrThrowException($_POST['course']);
        $modules = $this->modules->getAllModulesPerCourse($course);
        return view('frontend.studentarea.coursemodules')->withModules($modules);
    }

    public function course($enrollment_id, $default_tab = 0) {
        $enrollment = $this->enrollment->find($enrollment_id);

        if ($enrollment == null) {
            return view('errors.404');
        }
        if ($enrollment->student_id != Auth::user()->id) {
            return view('errors.404');
        }

        $course = $enrollment->course;
        $calendars = $this->calendars->getAllCoursesCalendarsPerCourse($course, 'date', 'asc');
        $alerts = $this->alerts->getAllCoursesAlertsPerCourse($course);
        $modules = $this->modules->getAllModulesPerCourse($course);
        $modulesPresential = $this->modules->getPresentialModulesPerCourse($course);
        $modulesComplementary = $this->modules->getComplementaryModulesPerCourse($course);
        $modulesOnline = $this->modules->getOnlineModulesPerCourse($course);
        $lessonExams = $this->exams->getExamsByCourse($course);



        $examEnrollments = $this->enrollment->associatedExams($course->id, $enrollment->student_id);
        $workshops = $course->workshops;

        foreach ($modules as $modulelist) {
            $modulelist->percentage_viewed = $this->view->modulePercentageViewed($enrollment->id, $modulelist);
        }
        foreach ($modulesComplementary as $modulelist) {
            $modulelist->percentage_viewed = $this->view->modulePercentageViewed($enrollment->id, $modulelist);
        }
        foreach ($modulesOnline as $modulelist) {
            $modulelist->percentage_viewed = $this->view->modulePercentageViewed($enrollment->id, $modulelist);
        }

        $studyPlan = $this->studyPlan->findByUser(auth()->user()->id);

        if ($studyPlan) {
            $time_watching = $this->view->getTimeInEnrollment(auth()->user()->id);

            //$time_today = $time_watching->whereLoose('date_created',Carbon::today()->toDateString())->first()->watched_time;
            $time_today = $time_watching->whereLoose('date_created', Carbon::today()->toDateString())->first();
            if ($time_today != null) {
                $time_today = $time_today->watched_time;
            } else {
                $time_today = 0;
            }

            $time_this_week = $time_watching->filter(function($item) {
                        $created_at = new Carbon($item->date_created);
                        $week_of_year = $created_at->weekOfYear;
                        return $week_of_year == Carbon::now()->weekOfYear;
                    })->sum('watched_time');
            $time_this_month = $time_watching->filter(function($item) {
                        $created_at = new Carbon($item->date_created);
                        $month_of_year = $created_at->month;
                        return $month_of_year == Carbon::now()->month;
                    })->sum('watched_time');

            $studyPlan->time_today = $time_today;
            $studyPlan->time_this_week = $time_this_week;
            $studyPlan->time_this_month = $time_this_month;

            $weeks = $time_watching->groupBy(function($item) {
                $created_at = new Carbon($item->date_created);
                return $created_at->weekOfYear;
            });

            $months = $time_watching->groupBy(function($item) {
                $created_at = new Carbon($item->date_created);
                return $created_at->month;
            });

            $studyPlan->weeks = $weeks;
            $studyPlan->months = $months;
        }

        foreach ($workshops as $workshop) {
            $workshop->active = 1;
            if ($workshop->available_date != null) {
                $workshop->begin = parsebr($workshop->available_date);
            } else {
                $workshop->begin = (new Carbon($enrollment->date_begin))->addDay($workshop->available_days_after_enrollment);
            }

            if ($workshop->begin > Carbon::today()) {
                $workshop->active = 0;
            }
        }

        $events = [];
        //Carregando as datas das atividades
        $eloquentEvent = EventModel::join('courses', 'courses.id', '=', 'course_id')
                        ->where('courses_calendars.course_id', "=", $course->id)
                        ->select('courses_calendars.description', 'courses_calendars.date', 'courses_calendars.course_id', 'courses_calendars.id', 'courses.title')->get();

        //Varrendo as atividades
        foreach ($eloquentEvent as $event) {
            $events[] = [
                'title' => $event->description,
                'url' => 'javascript:openModal("' . $event->title . '","' . date("d-m-Y", strtotime($event->date)) . '","' . $event->description . '");',
                'start' => date("Y-m-d", strtotime($event->date)),
                'end' => date("Y-m-d", strtotime($event->date))
            ];
        }

        //Webinars
        $webinars = \App\Webinar::where('courses_id', '=', $course->id)->orderBy('date', 'desc')->get();

        return view('frontend.studentarea.classroom.course')
                        ->withEnrollment($enrollment)
                        ->withCourse($course)
                        ->withModules($modules)
                        ->withModulesonline($modulesOnline)
                        ->withModulespresential($modulesPresential)
                        ->withModulescomplementary($modulesComplementary)
                        ->withCalendars($calendars)
                        ->withAlerts($alerts)
                        ->withStudyPlan($studyPlan)
                        ->withExams($lessonExams)
                        ->withExamenrollments($examEnrollments)
                        ->withWorkshops($workshops)
                        ->withWebinars($webinars)
                        ->withEvents($events)
                        ->withDefaultTab($default_tab);
    }

    public function saveAskTheTeacher() {
        $this->askTheTeacher->create($_POST["question"], null, $_POST["lesson_id"]);
        return "1";
    }

    public function saveAskTheTutor() {
        $saved = ($this->askTheTeacher->createAskTheTutor($_POST) == true) ? true : false;
        die(json_encode($saved));
    }

    public function certificate($enrollment_id) {

        $enrollment = $this->enrollment->find($enrollment_id);

        if (($enrollment->course->generate_certificate != null) && ($enrollment->course->generate_certificate != 1)) {
            return redirect()->back();
        }

        $actual = get_total_percentage_completed($enrollment);
        if ($actual < $enrollment->course->percentage_certificate) {
            return redirect()->back();
        }

        if ($enrollment->course->groups != null && !$enrollment->course->groups->isEmpty()) {
            $execution = $enrollment->course->executions->where('finished', 1)->first();

            if ($execution == null || ($execution->grade * 100) / $execution->questions_executions->count() < $enrollment->course->minimum_percentage) {
                return redirect()->back();
            }
        }

        $pdf = new FPDI('P', 'mm', 'A4'); //FPDI extends TCPDF
        //Se o curso possuir algum template cadastrado
        if (isset($enrollment->course) && !empty($enrollment->course->certification_template) && substr($course->certification_template, -4) == '.pdf') {
            // set the source file
            $pdf->setSourceFile('../' . $enrollment->course->certification_template);
        } else if (isset($enrollment->course) && !empty($enrollment->course->certification_template) && substr($course->certification_template, -4) != '.pdf') {
            // set the source file
            $pdf->setSourceFile('../' . $enrollment->course->certification_template . '.pdf');
        } else {
            // set the source file
            $pdf->setSourceFile("../certificado.pdf");
        }

        // import a page
        $templateId = $pdf->importPage(1);
        // get the size of the imported page
        $size = $pdf->getTemplateSize($templateId);

        // create a page (landscape or portrait depending on the imported page size)
        if ($size['w'] > $size['h']) {
            $pdf->AddPage('L', array($size['w'], $size['h']));
        } else {
            $pdf->AddPage('P', array($size['w'], $size['h']));
        }

        // use the imported page and place it at point 10,10 with a width of 100 mm
        $pdf->useTemplate($templateId, 0, 0, $size['w'], $size['h']);


        // now write some text above the imported page
        $pdf->SetFont('Helvetica', '', 20);
        $pdf->SetTextColor(28, 117, 187);

        $pdf->SetXY(100, 80);

        // $pdf->setSignature('file://assets/tcpdf.cert','file://assets/tcpdf.crt','','',1);


        $txt = 'Certificamos que <br><b>' . $enrollment->student->name . '</b>,<br> com o CPF <b>' . $enrollment->student->personal_id . '</b>, concluiu o curso online<br><b>' .
                $enrollment->course->title . '</b><br> com carga horária de <b>' . number_format($enrollment->course->workload, 1, ',', '.') . 'h/aula</b>.' .
                '<br>Início: <b>' . format_datebr($enrollment->date_begin) . '</b> | Conclusão: <b>' . format_datebr(Carbon::now()) . '</b>' .
                '<br><br>Salvador, ' . Carbon::now()->day . ' ' . month_year_br(Carbon::now(), false);

        $pdf->writeHTMLCell(180, 30, 60, 70, $txt, 0, 0, false, true, 'C', true);

        //second page: list of teachers
        $pdf->AddPage('L', array($size['w'], $size['h']));
        $pdf->SetFont('Helvetica', '', 10);
        $pdf->SetTextColor(0, 0, 0);

        foreach ($enrollment->course->modules as $module) {
            $module['teachers'] = $this->modules->getLessonsPerTeacherPerModule($module);
        }
        $txt = view('frontend.studentarea.classroom.certificate_modules')->withCourse($enrollment->course)->render();
        $pdf->writeHTMLCell(260, 30, 10, 10, $txt, 0, 0, false, true, 'C', true);

        $pdf->Output('crt_' . $enrollment_id . '_' . $enrollment->student->personal_id . '.pdf', 'D');
    }

    public function openTicket() {
        $this->tickets->createTicket($_POST["sector_id"], $_POST["message"], $_POST["content_id"], $_POST["enrollment_id"]);
        return "1";
    }

    public function analysis($enrollment_id) {
        $enrollment = $this->enrollment->find($enrollment_id);

        $analysis = "";
        if (($enrollment->course != null) && ($enrollment->course->analysis != null) && ($enrollment->course->analysis != null)) {
            $analysis = $enrollment->course->analysis;
        } else if (($enrollment->exam != null) && ($enrollment->exam->analysis != null) && ($enrollment->exam->analysis != null)) {
            $analysis = $enrollment->exam->analysis;
        }

        return view('frontend.studentarea.analysis.index')
                        ->withAnalysis('frontend.studentarea.analysis.' . $analysis);
    }

    /**
     * @param $enrollment_id
     * @return mixed
     */
    public function exportNotes($enrollment_id) {

        /* set_time_limit(600); */

        $enrollment = $this->enrollment->find($enrollment_id);

        /* $pdf = new FPDI('P', 'mm', 'A4'); //FPDI extends TCPDF

          $pdf->setFontSubsetting(false);

          // set the source file
          $pdf->setSourceFile("../company_logo.pdf");

          // import a page
          $templateId = $pdf->importPage(1);
          // get the size of the imported page
          $size = $pdf->getTemplateSize($templateId);

          // create a page (landscape or portrait depending on the imported page size)
          $pdf->SetTopMargin(30);
          $pdf->SetFooterMargin(30);
          $pdf->SetLeftMargin(30);
          $pdf->SetRightMargin(30);
          // set auto page breaks
          $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

          // set margins
          $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
          //$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
          $pdf->setPrintHeader(false);
          $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

          $pdf->AddPage('P');

          // use the imported page and place it at point 10,10 with a width of 100 mm
          $pdf->useTemplate($templateId, 0, 0, $size['w'], $size['h']);

          $pdf->SetFont('Helvetica', '', 10);
          $pdf->SetTextColor(0, 0, 0); */



        /* foreach ($enrollment->course->modules as $module){
          $module['teachers'] = $this->modules->getLessonsPerTeacherPerModule( $module );
          } */
        /* $txt = */
        return view('frontend.studentarea.classroom.export_notes')
                        ->withEnrollment($enrollment)
                        ->withCourse($enrollment->course);
        /* $pdf->writeHTMLCell(180, 30, 10, 10, $txt, 0, 0, false, true, 'C', true);

          $pdf->Output('anot_' . $enrollment_id . '_' . $enrollment->student->personal_id . '.pdf', 'D'); */
    }

    public function createLessonExecution() {

        $execution = $this->executions->createForLesson($_POST['enrollment'], $_POST['lesson']);
        $lesson = $this->lessons->findOrThrowException($_POST['lesson']);
        $questionExecution = $this->questionsExecution->create($execution, $lesson);

        return $questionExecution;
    }

    public function getLessonExam() {
        $questionExec = null;
        $execution = $this->executions->findByEnrollmentAndLesson($_POST['enrollment'], $_POST['lesson']);
        if ($execution == null) {
            $this->createLessonExecution();
            $execution = $this->executions->findByEnrollmentAndLesson($_POST['enrollment'], $_POST['lesson']);
        }
        $questionExec = $execution->questions_executions;
        $count = count($questionExec);
        if ($execution->last_question_execution_id != null) {
            $questionExec = $questionExec->where('id', $execution->last_question_execution_id);
            if ($questionExec->first()->answersExecution != null) {
                $next = $this->questionsExecution->findNext($questionExec->first()->id);
                if ($next == null) {
                    $this->executions->finish($questionExec->first()->execution);
                    return view('frontend.studentarea.classroom.exam.results')->withExecution($execution)->render();
                } else {
                    $questionExec = $next;
                }
            } else {
                $questionExec = $questionExec->first();
            }
        } else {
            $questionExec = $questionExec->first();
        }
        return view('frontend.studentarea.classroom.exam.exam')->withQuestionExec($questionExec)->withCount($count);
    }

    public function completeLessonResults($questionExec) {
        return view('frontend.studentarea.classroom.exam.results')->withQuestionExec($questionExec);
    }

    public function workshops($enrollment_id, $workshop_id) {
        $enrollment = $this->enrollment->find($enrollment_id);

        $workshops = Workshop::where("course_id", "=", $enrollment->course_id)->where("id", "=", $workshop_id)->get();


        foreach ($workshops as $workshop) {
            $workshop->active = 1;
            if ($workshop->available_date != null) {
                $workshop->begin = parsebr($workshop->available_date);
            } else {
                $workshop->begin = (new Carbon($enrollment->date_begin))->addDay($workshop->available_days_after_enrollment);
            }

            if ($workshop->begin > Carbon::today()) {
                $workshop->active = 0;
            }


            $workshop->tutors = MyWorkshopTutor::where('enrollment_id', '=', $enrollment_id)->where('workshop_id', '=', $workshop->id)->get();
            //dd(MyWorkshopTutor::where('enrollment_id', '=', $enrollment_id)->where('workshop_id', '=', $workshop->id)->get());
            $tutors = array();
            foreach ($workshop->tutors as $tutor) {
                if (!in_array($tutor->tutor, $tutors)) {
                    array_push($tutors, $tutor->tutor);
                }
            }
            $workshop->tutors = $tutors;

            if ($workshop->active == 1) {
                $activities = $workshop->activities;

                foreach ($activities as $activity) {
                    $activity->active = 1;
                    if ($activity->available_date != null) {
                        $activity->begin = new Carbon(parsebr($activity->available_date));
                        $activity->submit_deadline = new Carbon(parsebr($activity->submit_deadline_date));
                        $activity->evaluation_deadline = new Carbon(parsebr($activity->evaluation_deadline_date));
                    } else {
                        $activity->begin = (new Carbon($workshop->begin))->addDay($activity->available_days_after_workshop);
                        $activity->submit_deadline = (new Carbon($workshop->begin))->addDay($activity->submit_deadline_days);
                        $activity->evaluation_deadline = (new Carbon($workshop->begin))->addDay($activity->evaluation_deadline_days);
                    }
                    if ($activity->begin > Carbon::today()) {
                        $activity->active = 0;
                    }

                    $activity->grade = 0;

                    $activity->references = MyWorkshopActivity::where('enrollment_id', '!=', $enrollment_id)->where('reference', '=', 1)->where('activity_id', '=', $activity->id)->get();

                    $activity->myactivity = MyWorkshopActivity::where('enrollment_id', '=', $enrollment_id)->where('activity_id', '=', $activity->id)->get();

                    if (count($activity->myactivity) != 0) {
                        $activity->myevaluations = MyWorkshopEvaluation::where('my_activity_id', '=', $activity->myactivity[0]->id)->get();
                        if (count($activity->myevaluations) != 0) {
                            foreach ($activity->myevaluations as $myevaluation) {
                                $activity->grade = $activity->grade + $myevaluation->grade;
                            }
                        }
                    }
                }


                $workshop->activities = $activities->sortBy(function($item) {
                    return $item->begin . $item->description;
                });
            }
        }

        return view('frontend.studentarea.workshop.index')
                        ->withWorkshops($workshops)
                        ->withEnrollment($enrollment);
    }

    public function uploadActivity(Request $request) {
        $enrollment = $this->enrollment->find($request['enrollment_id']);
        $activity = WorkshopActivity::find($request['activity_id']);
        $myactivities = MyWorkshopActivity::where('enrollment_id', '=', $enrollment->id)->where('activity_id', '=', $activity->id)->get();
        $myactivity = new MyWorkshopActivity();

        if (count($myactivities) != 0) {
            $myactivity = $myactivities[0];
        } else {
            $myactivity->enrollment_id = $enrollment->id;
            $myactivity->activity_id = $activity->id;
            $myactivity->workshop_id = $activity->workshop->id;
            $myactivity->reference = false;
        }
        Log::info("Log.Upload 1");


        if ($request->hasFile('response_document_' . $activity->id)) {
            $upload_result = $this->uploadService->addImg($request->file('response_document_' . $activity->id), $enrollment->student->name . '_' . $activity->workshop->description . '_' . $activity->description, $enrollment->id . '_' . $activity->id, 'workshop');
            if (get_filetype($upload_result['filename']) != ".pdf") {
                return redirect()->back()->withWrongFiletype('true');
            }

            $myactivity->url_document_activity = '/uploads/workshop/' . $enrollment->id . '_' . $activity->id . '/' . $upload_result['filename'];
            $myactivity->date_submit = Carbon::now();
            $myactivity->save();
        }

        Log::info("Log.Upload 2");

        $evaluations = MyWorkshopEvaluation::where('my_activity_id', '=', $myactivity->id)->get();
        if (count($evaluations) == 0) {
            //busca tutores por atividade
            $tutors = MyWorkshopTutor::where('workshop_id', '=', $activity->workshop->id)->where('enrollment_id', '=', $enrollment->id)->where('activity_id', '=', $activity->id)->get();
            if (count($tutors) == 0) {

                $tutors = MyWorkshopTutor::where('workshop_id', '=', $activity->workshop->id)->
                                where('enrollment_id', '=', $enrollment->id)->get()->unique(function($item) {
                    return $item->tutor_id . '-' . $item->criteria_id;
                });
            }


            foreach ($tutors as $tutor) {
                $myevaluation = new MyWorkshopEvaluation();
                $myevaluation->my_activity_id = $myactivity->id;
                $myevaluation->tutor_id = $tutor->tutor_id;
                $myevaluation->criteria_id = $tutor->criteria_id;
                if ($activity->evaluation_deadline_date != null) {
                    Log::info('log.DEADLINE');
                    Log::info($activity->evaluation_deadline_date);
                    $myevaluation->date_deadline = parsebr($activity->evaluation_deadline_date);
                } else {
                    $myevaluation->date_deadline = $enrollment->date_begin + $activity->workshop->available_days_after_enrollment + $activity->available_days_after_workshop + $activity->evaluation_deadline_days;
                }
                if ($activity->submit_deadline_date != null) {
                    $myevaluation->date_begin = parsebr($activity->submit_deadline_date)->addDay();
                } else {
                    $myevaluation->date_begin = $enrollment->date_begin + $activity->workshop->available_days_after_enrollment + $activity->available_days_after_workshop + $activity->submit_deadline_days + 1;
                }
                $myevaluation->save();
            }
        }
        $request->session()->flash('alert-success', 'Resposta enviada com sucesso!');

        return redirect()
                        ->route('frontend.classroom.activity', [$request['enrollment_id'], $activity->workshop->id, $request['activity_id']]);
    }

    public function saveOrCreateWorkshopActivityTime() {
        $activity = $_POST['activity'];
        $enrollment = $_POST['enrollment'];
        $time_spent = $_POST['time_spent'];
        $time_left = $_POST['time_left'];

        $this->myWorkshopActivityTime->createOrUpdate($activity, $enrollment, $time_spent, $time_left);
    }

    public function exportWorkshopDeliveryProtocol($workshop_activity) {
        set_time_limit(600);



        $activity = MyWorkshopActivity::find($workshop_activity);


        $pdf = new FPDI('P', 'mm', 'A4'); //FPDI extends TCPDF

        $pdf->setFontSubsetting(false);

        // set the source file
        $pdf->setSourceFile("../company_logo.pdf");

        // import a page
        $templateId = $pdf->importPage(1);
        // get the size of the imported page
        $size = $pdf->getTemplateSize($templateId);

        // create a page (landscape or portrait depending on the imported page size)
        $pdf->SetTopMargin(30);
        $pdf->SetFooterMargin(30);
        $pdf->SetLeftMargin(30);
        $pdf->SetRightMargin(30);
        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        //$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->setPrintHeader(false);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        $pdf->AddPage('P');

        // use the imported page and place it at point 10,10 with a width of 100 mm
        $pdf->useTemplate($templateId, 0, 0, $size['w'], $size['h']);

        $pdf->SetFont('Helvetica', '', 10);
        $pdf->SetTextColor(0, 0, 0);

//        foreach ($enrollment->course->modules as $module){
//            $module['teachers'] = $this->modules->getLessonsPerTeacherPerModule( $module );
//        }
        $txt = view('frontend.studentarea.workshop.export_protocol')->withWorkshopActivity($activity)->render();

        $pdf->writeHTMLCell(180, 30, 10, 10, $txt, 0, 0, false, true, 'C', true);


        $pdf->Output('protocolo_oficina' . $activity->workshop->id . '_' . $activity->id . '.pdf', 'D');
    }

    public function activity($enrollment_id, $workshop_id, $activity_id) {
        $enrollment = $this->enrollment->find($enrollment_id);

        $workshops = Workshop::where("course_id", "=", $enrollment->course_id)->where("id", "=", $workshop_id)->get();


        foreach ($workshops as $workshop) {
            $workshop->active = 1;
            if ($workshop->available_date != null) {
                $workshop->begin = parsebr($workshop->available_date);
            } else {
                $workshop->begin = (new Carbon($enrollment->date_begin))->addDay($workshop->available_days_after_enrollment);
            }

            if ($workshop->begin > Carbon::today()) {
                $workshop->active = 0;
            }


            $workshop->tutors = MyWorkshopTutor::where('enrollment_id', '=', $enrollment_id)->where('workshop_id', '=', $workshop->id)->get();
            $tutors = array();
            foreach ($workshop->tutors as $tutor) {
                if (!in_array($tutor->tutor, $tutors)) {
                    array_push($tutors, $tutor->tutor);
                }
            }
            $workshop->tutors = $tutors;

            if ($workshop->active == 1) {
                $activity = WorkshopActivity::withTrashed()->find($activity_id);

                if ($activity != null) {
                    $activity->active = 1;
                    if ($activity->available_date != null) {
                        $activity->begin = new Carbon(parsebr($activity->available_date));
                        $activity->submit_deadline = new Carbon(parsebr($activity->submit_deadline_date));
                        $activity->evaluation_deadline = new Carbon(parsebr($activity->evaluation_deadline_date));
                    } else {
                        $activity->begin = (new Carbon($workshop->begin))->addDay($activity->available_days_after_workshop);
                        $activity->submit_deadline = (new Carbon($workshop->begin))->addDay($activity->submit_deadline_days);
                        $activity->evaluation_deadline = (new Carbon($workshop->begin))->addDay($activity->evaluation_deadline_days);
                    }
                    if ($activity->begin > Carbon::today()) {
                        $activity->active = 0;
                    }

                    $activity->grade = 0;

                    $activity->references = MyWorkshopActivity::where('enrollment_id', '!=', $enrollment_id)->where('reference', '=', 1)->where('activity_id', '=', $activity->id)->get();

                    $activity->myactivity = MyWorkshopActivity::where('enrollment_id', '=', $enrollment_id)->where('activity_id', '=', $activity->id)->get();

                    if (count($activity->myactivity) != 0) {
                        $activity->myevaluations = MyWorkshopEvaluation::where('my_activity_id', '=', $activity->myactivity[0]->id)->get();
                        if (count($activity->myevaluations) != 0) {
                            foreach ($activity->myevaluations as $myevaluation) {
                                $activity->grade = $activity->grade + $myevaluation->grade;
                            }
                        }
                    }
                }
            }
        }

        $time = $this->myWorkshopActivityTime->findByActivityAndEnrollment($activity_id, $enrollment->id)->first();

        //$average = $this->get_average_activity_grade($activity);

        return view('frontend.studentarea.workshop.activity')
                        ->withWorkshops($workshops)
                        ->withActivity($activity)
                        ->withEnrollment($enrollment)
                        ->withTime($time);
    }

    public function get_average_activity_grade($workshop_activity) {
        $my_activities = $workshop_activity->myActivities;

        if (!$my_activities->isEmpty() && $my_activities != null) {
            $evaluations = $my_activities->pluck('evaluation', 'id')->reject(function($item) {
                return $item->isEmpty();
            });
            $count = $evaluations->count();
            if ($count > 0) {
                $grades = 0;

                $total = 0;



                foreach ($evaluations as $evaluation) {

                    $grades += $evaluation->sum('grade');
                    $total += $evaluation->count();
                }

                $average = $grades / $total;
                return $average;
            }
        }

        return 0;
    }

    public function tutorial() {
        return view('frontend.studentarea.tutorials.tutorial');
    }

    public function manual() {
        return view('frontend.studentarea.tutorials.manual');
    }

    public function test() {
        $a = $this->enrollment->createEnrollmentForUsersWithExamsAgregatedOfCourse();
        
    }

}
