<?php

namespace App\Http\Controllers\Frontend;

use App\Execution;
use App\Http\Controllers\Controller;
use App\Repositories\Backend\Occupation\OccupationContract;
use App\Repositories\Frontend\Course\CourseContract;
use App\Repositories\Frontend\Enrollment\EnrollmentContract;
use App\Repositories\Frontend\Lesson\LessonContract;
use App\Repositories\Frontend\Module\ModuleContract;
use App\Repositories\Frontend\StudyPlan\StudyPlanContract;
use App\Repositories\Frontend\View\ViewContract;
use App\Repositories\Backend\CourseCalendar\CourseCalendarContract;
use App\Services\Utils\Tags;
use App\Module;
use App\StudyPlan;
use App\QuestionsExecution;
use App\Subject;
use App\SurveySimpleResponse;
use App\User;
use App\Survey;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

/**
 * Class DashboardController
 * @package App\Http\Controllers\Frontend
 */
class DashboardController extends Controller {

    public function __construct(CourseContract $courses, ModuleContract $modules, LessonContract $lessons, EnrollmentContract $enrollment, StudyPlanContract $studyPlan, ViewContract $view, OccupationContract $occupations, CourseCalendarContract $courseCalendar) {
        $this->courses = $courses;
        $this->modules = $modules;
        $this->lessons = $lessons;
        $this->enrollment = $enrollment;
        $this->studyPlan = $studyPlan;
        $this->view = $view;
        $this->occupations = $occupations;
        $this->check_activation_lesson();
        $this->courseCalendar = $courseCalendar;
    }

    /**
     * Ativação da Aula com base na Data de Ativação
     * @return void
     */
    public function check_activation_lesson() {
        $ObjModule = new \App\Module();
        $Carbon = new \Carbon\Carbon();
        $Modules = $ObjModule->where('activation_date', '<=', $Carbon::now())
                ->where('is_active', 0)
                ->get();

        //Varrendo registros com data de ativação expirado
        foreach ($Modules as $module) {
            $module->is_active = 1;
            $module->update();
        }
    }

    /**
     * @return mixed
     */
    public function index(Request $request) {
        /*
          $enrollments = $this->enrollment->getAllStudentEnrollmentsByStatus(auth()->user()->id,true)->sortByDesc(function($item){
          return $item->views->max('updated_at');
          });
         */
        $posMessage = 0;
        $messages = array();

        $couseCalendar = $this->courseCalendar->getAlloursesCalendarsPerUser();

        $messages[$posMessage] = "<span class='font-blue-steel'>Acesse a <b>Área do Curso</b> para a emissão do certificado.</span>";
        $posMessage++;

        $lastenrollments = $this->enrollment->getAllStudentEnrollmentsInLastHours(auth()->user()->id, 2)->take(4);

        $enrollments = $this->enrollment->getAllStudentEnrollmentsByStatus(auth()->user()->id, true)->sortByDesc(function($item) {
            return $item->view_logs->max('created_at');
        });

        $welcome_message = '';
        foreach ($enrollments as $enrollment) {

            if (($enrollment->course->welcome_message != null) && ($enrollment->course->welcome_message != '') && $welcome_message == '') {
                if ($enrollment->welcome_viewed == 0) {
                    $enrollment->welcome_viewed = 1;
                    $enrollment->save();

                    $welcome_message = $enrollment->course->welcome_message;
                }
            }

            $totalTime = Carbon::parse($enrollment->date_begin)->diffInDays(Carbon::parse($enrollment->date_end));
            $toFinishTime = Carbon::now()->diffInDays(Carbon::parse($enrollment->date_end));
            if (($toFinishTime / $totalTime) < 0.2) {
                $messages[$posMessage] = "<span class='font-red-flamingo'> Você tem apenas " . $toFinishTime . " dias para concluir o curso " . $enrollment->course->title . "</span>";
                $posMessage++;
            } else if (($toFinishTime / $totalTime) < 0.4) {
                $messages[$posMessage] = "<span class='font-yellow-saffron'> Você tem apenas " . $toFinishTime . " dias para concluir o curso " . $enrollment->course->title . "</span>";
                $posMessage++;
            }
        }


        $enrollments_with_exam = $enrollments->filter(function($item){
            return $item->course->groups != null && !$item->course->groups->isEmpty() && $item->course->executions->whereLoose('finished','1')->first() == null;
        });



        $courses_taken = $enrollments->count();
        $enrollments = $enrollments->take(1);




        $expireds = $this->enrollment->getAllStudentEnrollmentsByStatus(auth()->user()->id, false);
        $exams = $this->enrollment->getAllStudentEnrollmentsExamByStatus(auth()->user()->id, true)->sortByDesc(function($item) {
            return $item->executions->max('updated_at');
        });





        Log::info('log.EXAM');
        foreach ($exams as $exam) {

            $totalTime = Carbon::parse($exam->date_begin)->diffInDays(Carbon::parse($exam->date_end));
            $toFinishTime = Carbon::today()->diffInDays(Carbon::parse($exam->date_end));
            if (($toFinishTime / $totalTime) < 0.2) {
                $messages[$posMessage] = "<span class='font-red-flamingo'> Você tem apenas " . $toFinishTime . " dias para concluir o SAAP " . $exam->exam->title . "</span>";
                $posMessage++;
            } else if (($toFinishTime / $totalTime) < 0.4) {
                $messages[$posMessage] = "<span class='font-yellow-saffron'> Você tem apenas " . $toFinishTime . " dias para concluir o SAAP " . $exam->exam->title . "</span>";
                $posMessage++;
            }
        }

        $exams = $exams->take(1);
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

            if ((count($enrollments) != 0) && ($time_today < $studyPlan->daily_time)) {
                $messages[$posMessage] = "<span class='font-red-flamingo'> Você ainda não atingiu sua meta diária. Vamos lá, assista algumas aulas!</span>";
                $posMessage++;
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


            $request->session()->put("time_watching", $time_watching);

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
        } else {
            $messages[$posMessage] = "<span class='font-blue-steel'> Você ainda não definiu sua meta de estudos diária. Acesse o seu perfil e configure.</span>";
            $posMessage++;
        }

        $occupations = null;
        $survey = null;
        if (((auth()->user()->last_data_update != null) && ( Carbon::now()->addDays(-15)->gt(new Carbon(auth()->user()->last_data_update)))) || ( Carbon::now()->addDays(-15)->gt(auth()->user()->created_at) )) {

            $surveys = SurveySimpleResponse::where('user_id', '=', auth()->user()->id)->get();
            if (count($surveys) == 0) {
                $survey = 1;
            }
//			} else if ( Auth::user()->occupation_id == null){
//				$occupations = $this->occupations->getAllOccupations('description', 'asc');
//			}
        }


        return view('frontend.studentarea.dashboard')
                        ->withUser(Auth::user())
                        ->withEnrollments($enrollments)
                        ->withLastenrollments($lastenrollments)
                        ->withExpireds($expireds)
                        ->withExams($exams)
                        ->withStudyPlan($studyPlan)
                        ->withCoursesTaken($courses_taken)
                        ->withMessages($messages)
                        ->withOccupations($occupations)
                        ->withSurvey($survey)
                        ->withWelcomemessage($welcome_message)
                        ->withCoursecalendar($couseCalendar)
                        ->withFinalExamPending($enrollments_with_exam);
    }

    public function initializeStudyPlan(Request $request) {

        $planstudy_hours = $request['planstudy_hours'];

        if ($planstudy_hours != null) {
            $studyPlan = $this->studyPlan->findByUser(auth()->user()->id);

            if ($studyPlan != null) {
                $studyPlan->daily_time = $planstudy_hours;
                $studyPlan->save();
            } else {
                $studyPlan = new StudyPlan();
                $studyPlan->daily_time = $planstudy_hours;
                $studyPlan->user_id = auth()->user()->id;
                $studyPlan->save();
            }
        }

        return $this->index($request);
    }

    public function accessHistory(Request $request) {

        $time_watching = $request->session()->get('time_watching');

        $daily_time = collect([]);


        for ($i = 7; $i > 0; $i--) {
            $day_and_month = Carbon::today()->addDays(-$i);

            $daily_time[$day_and_month->day . '/' . str_pad($day_and_month->month, 2, "0", STR_PAD_LEFT)] = 0;
        }


        $week_before = Carbon::today()->addDays(-7);
        foreach ($time_watching as $day) {
            $created_at = new Carbon($day->date_created);
            if ($created_at->gte($week_before)) {

                $day_and_month = $created_at->day . '/' . str_pad($created_at->month, 2, "0", STR_PAD_LEFT);

                if (!isset($daily_time[$day_and_month]))
                    $daily_time[$day_and_month] = $day->watched_time;
                else
                    $daily_time[$day_and_month] += $day->watched_time;
            }
        }





        $week_time = collect([]);


        for ($i = 7; $i > 0; $i--) {
            $start_to_finish_week = Carbon::today()->addWeeks(-$i);
            $from_day = $start_to_finish_week->startOfWeek()->day . '/' . str_pad($start_to_finish_week->startOfWeek()->month, 2, "0", STR_PAD_LEFT);
            $to_day = $start_to_finish_week->endOfWeek()->day . '/' . str_pad($start_to_finish_week->endOfWeek()->month, 2, "0", STR_PAD_LEFT);

            $week_time[$from_day . '-' . $to_day] = 0;
        }


        $weeks_before = Carbon::today()->addWeeks(-7);
        foreach ($time_watching as $week) {

            $created_at = new Carbon($week->date_created);
            $from_day = $created_at->startOfWeek()->day . '/' . str_pad($created_at->startOfWeek()->month, 2, '0', STR_PAD_LEFT);
            $to_day = $created_at->endOfWeek()->day . '/' . str_pad($created_at->endOfWeek()->month, 2, '0', STR_PAD_LEFT);


            if ($created_at->gte($weeks_before)) {

                if (!isset($week_time[$from_day . '-' . $to_day]))
                    $week_time[$from_day . '-' . $to_day] = $week->watched_time;
                else
                    $week_time[$from_day . '-' . $to_day] += $week->watched_time;
            }
        }

        $month_time = collect([]);


        for ($i = 7; $i > 0; $i--) {
            $actual_month = Carbon::today()->addMonths(-$i);

            $month_time[str_pad($actual_month->month, 2, '0', STR_PAD_LEFT) . '/' . $actual_month->year] = 0;
        }

        $months_before = Carbon::today()->addMonths(-7);
        foreach ($time_watching as $month) {

            $created_at = new Carbon($month->date_created);

            if ($created_at->gte($months_before)) {

                $month_and_year = str_pad($created_at->month, 2, '0', STR_PAD_LEFT) . '/' . $created_at->year;


                if (!isset($month_time[$month_and_year]))
                    $month_time[$month_and_year] = $month->watched_time;
                else
                    $month_time[$month_and_year] += $month->watched_time;
            }
        }


        return ["monthly" => $month_time, "weekly" => $week_time, "daily" => $daily_time];
    }

    public function courses(Request $request) {
        $f_selected_tag = get_parameter_or_session($request, 'cat', '', '1', '');

        $enrollments = $this->enrollment->getAllStudentEnrollmentsByStatus(auth()->user()->id, true);
        $expireds = null;

        $enrollments = $enrollments->reject(function($item) {
            return $item->course == null || $item->deleted_at != null || $item->course == "" || $item->course->deleted_at != null;
        });


        $tags = (new Tags())->tagsList($enrollments, $f_selected_tag);

        if (($f_selected_tag != null) && ($f_selected_tag != "") && ($f_selected_tag != "-")) {
            $enrollments = $enrollments->keyBy('id');
            foreach ($enrollments as $enrollment) {
                $object_tags = $enrollment->course->tags;
                if ($object_tags != null && $object_tags != '') {
                    $object_tags = explode(";", $object_tags);
                    if (!in_array($f_selected_tag, $object_tags)) {
                        $enrollments->forget($enrollment->id);
                    }
                } else {
                    $enrollments->forget($enrollment->id);
                }
            }
        } else {
            $expireds = $this->enrollment->getAllStudentEnrollmentsByStatus(auth()->user()->id, false);

            $expireds = $expireds->reject(function($item) {
                return $item->course == null || $item->deleted_at != null || $item->course == "" || $item->course->deleted_at != null;
            });
        }

        return view('frontend.studentarea.courses')
                        ->withUser(Auth::user())->withEnrollments($enrollments)->withExpireds($expireds)->withTags($tags)->withSelectedtag($f_selected_tag);
    }

    public function exams(Request $request) {
        $f_selected_tag = get_parameter_or_session($request, 'cat', '', '1', '');

        $exams = $this->enrollment->getAllStudentEnrollmentsExamByStatus(auth()->user()->id, true);
        $expireds = null;

        $tags = (new Tags())->tagsList($exams, $f_selected_tag);

        if (($f_selected_tag != null) && ($f_selected_tag != "") && ($f_selected_tag != "-")) {
            $exams = $exams->keyBy('id');
            foreach ($exams as $enrollment) {
                $object_tags = $enrollment->exam->tags;
                if ($object_tags != null && $object_tags != '') {
                    $object_tags = explode(";", $object_tags);
                    if (!in_array($f_selected_tag, $object_tags)) {
                        $exams->forget($enrollment->id);
                    }
                } else {
                    $exams->forget($enrollment->id);
                }
            }
        } else {
            $expireds = $this->enrollment->getAllStudentEnrollmentsExamByStatus(auth()->user()->id, false);
        }

        return view('frontend.studentarea.exams')
                        ->withUser(Auth::user())->withExams($exams)->withExpireds($expireds)->withExams($exams)->withTags($tags)->withSelectedtag($f_selected_tag);
    }

    public function disciplineGeneralPerformance() {
        $discipline = $_POST['discipline'];

        $subjects = Subject::join('questions', 'questions.subject_id', '=', 'subjects.id')
                        ->join('questions_executions', 'questions_executions.question_id', '=', 'questions.id')
                        ->join('executions', 'executions.id', '=', 'questions_executions.execution_id')
                        ->join('enrollments', 'enrollments.id', '=', 'executions.enrollment_id')
                        ->join('subjects as sb2', 'subjects.subject_id', '=', 'sb2.id')
                        ->where('sb2.subject_id', '=', $discipline)
                        ->where('enrollments.student_id', '=', auth()->user()->id)
                        ->whereNotNull('questions_executions.grade')
                        ->groupBy('sb2.name')
                        ->select(\DB::raw('sum(questions_executions.grade) as rights'), 'sb2.name as subject', \DB::raw('count(*) as questions '))
                        ->orderBy('questions', 'desc')->get();

        $subjects = $subjects->sortBy(function($item, $key) {
            return ($item->rights / $item->questions);
        });


        return view('frontend.studentarea.discipline-general-performance')->withSubjects($subjects);
    }

    public function examGeneralPerformance() {

        $disciplines = Subject::join('questions', 'questions.subject_id', '=', 'subjects.id')
                        ->join('questions_executions', 'questions_executions.question_id', '=', 'questions.id')
                        ->join('executions', 'executions.id', '=', 'questions_executions.execution_id')
                        ->join('enrollments', 'enrollments.id', '=', 'executions.enrollment_id')
                        ->join('subjects as sb2', 'subjects.subject_id', '=', 'sb2.id')
                        ->join('subjects as sb3', 'sb2.subject_id', '=', 'sb3.id')
                        ->where('enrollments.student_id', '=', auth()->user()->id)
                        ->whereNotNull('questions_executions.grade')
                        ->groupBy('sb3.name')
                        ->select('sb3.id as discipline_id', 'sb3.name as discipline', \DB::raw('count(*) as questions '))
                        ->orderBy('questions', 'desc')->get();

        $disciplinesRights = Subject::join('questions', 'subjects.id', '=', 'questions.subject_id')
                        ->join('questions_executions', 'questions.id', '=', 'questions_executions.question_id')
                        ->join('executions', 'questions_executions.execution_id', '=', 'executions.id')
                        ->join('enrollments', 'executions.enrollment_id', '=', 'enrollments.id')
                        ->join('subjects as sb2', 'subjects.subject_id', '=', 'sb2.id')
                        ->join('subjects as sb3', 'sb2.subject_id', '=', 'sb3.id')
                        ->where('enrollments.student_id', '=', auth()->user()->id)
                        ->where('questions_executions.grade', '=', 1)
                        ->groupBy('sb3.name')
                        ->select('sb3.name as discipline', \DB::raw('count(*) as questions '))
                        ->orderBy('discipline', 'asc')->orderBy('questions', 'desc')->get();

        $disciplinesWrongs = Subject::join('questions', 'subjects.id', '=', 'questions.subject_id')
                        ->join('questions_executions', 'questions.id', '=', 'questions_executions.question_id')
                        ->join('executions', 'questions_executions.execution_id', '=', 'executions.id')
                        ->join('enrollments', 'executions.enrollment_id', '=', 'enrollments.id')
                        ->join('subjects as sb2', 'subjects.subject_id', '=', 'sb2.id')
                        ->join('subjects as sb3', 'sb2.subject_id', '=', 'sb3.id')
                        ->where('enrollments.student_id', '=', auth()->user()->id)
                        ->where('questions_executions.grade', '=', 0)
                        ->groupBy('sb3.name')
                        ->select('sb3.name as discipline', \DB::raw('count(*) as questions '))
                        ->orderBy('discipline', 'asc')->orderBy('questions', 'desc')->get();

        $total = 0;
        $rights = 0;
        $wrongs = 0;

        foreach ($disciplines as $discipline) {
            $disciplineRight = $disciplinesRights->where('discipline', $discipline->discipline);
            if (($disciplineRight != null) && (count($disciplineRight) != 0)) {
                $discipline->rights = $disciplineRight->first()->questions;
            } else {
                $discipline->rights = 0;
            }

            $disciplineWrong = $disciplinesWrongs->where('discipline', $discipline->discipline);
            if (($disciplineWrong != null) && (count($disciplineWrong) != 0)) {
                $discipline->wrongs = $disciplineWrong->first()->questions;
            } else {
                $discipline->wrongs = 0;
            }

            $discipline->percent = $discipline->rights / $discipline->questions * 100;

            $total = $total + $discipline->questions;
            $rights = $rights + $discipline->rights;
            $wrongs = $wrongs + $discipline->wrongs;
        }



        $disciplines = $disciplines->sortBy(function($item) {
            return $item->percent;
        });

        /*         * ************************************ Cálculo de tempo total ********************************************** */
        $total_time = Execution::join('enrollments', 'executions.enrollment_id', '=', 'enrollments.id')->
                        join('exams', 'enrollments.exam_id', '=', 'exams.id')->
                        where('enrollments.student_id', '=', auth()->user()->id)->select('exams.duration', 'executions.time')->get();


        $time_sum = 0;

        foreach ($total_time as $time) {
            $difference = parse_duration_to_sec($time->duration) - parse_time_to_sec($time->time);
            $time_sum += $difference;
        }


        $formatted_time_sum = parse_sec_to_time($time_sum);


        $time_by_question = parse_sec_to_time($time_sum / $total);
        /*         * *********************************** Fim de cálculo de tempo total **************************************** */


        $complete_executions_count = Execution::join('enrollments', 'executions.enrollment_id', '=', 'enrollments.id')->
                        where('enrollments.student_id', '=', auth()->user()->id)->where('finished', '=', 1)->count();


        $last_execution = Execution::join('enrollments', 'executions.enrollment_id', '=', 'enrollments.id')->
                        where('enrollments.student_id', '=', auth()->user()->id)->whereNotNull('enrollments.exam_id');


        if ($last_execution->count() > 0) {

            if ($last_execution->where('finished', 1)->count() != 0) {
                $last_execution = $last_execution->where('finished', 1)->orderBy('finished_at', 'desc')->first();
            } else {

                $last_execution = Execution::join('enrollments', 'executions.enrollment_id', '=', 'enrollments.id')->
                                where('enrollments.student_id', '=', auth()->user()->id)->select("executions.*")->orderBy('executions.updated_at', 'desc');

                $last_execution = $last_execution->first();
            }
        } else {
            $last_execution = null;
        }



        $teacher = User::teachersFeatured()->get()->shuffle()->first();



        return view('frontend.studentarea.exam-general-performance')
                        ->withDisciplines($disciplines)
                        ->withTotal($total)
                        ->withRights($rights)
                        ->withWrongs($wrongs)
                        ->withTotalTime($formatted_time_sum)
                        ->withTimeQuestion($time_by_question)
                        ->withExecutionCount($complete_executions_count)
                        ->withLastExecution($last_execution)
                        ->withTeacher($teacher);
    }

}
