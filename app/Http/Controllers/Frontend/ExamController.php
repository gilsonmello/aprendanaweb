<?PHP namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use App\Repositories\Frontend\AnswersExecution\AnswersExecutionContract;
use App\Repositories\Frontend\AskTheTeacher\AskTheTeacherContract;
use App\Repositories\Frontend\Enrollment\EnrollmentContract;
use App\Repositories\Frontend\Exam\ExamContract;
use App\Repositories\Frontend\Execution\ExecutionContract;
use App\Repositories\Frontend\Package\PackageContract;
use App\Repositories\Frontend\Question\QuestionContract;
use App\Repositories\Frontend\QuestionNote\QuestionNoteContract;
use App\Repositories\Frontend\QuestionsExecution\QuestionsExecutionContract;
use App\Repositories\Frontend\Subject\SubjectContract;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Request;
use App\Repositories\Frontend\ViewExam\ViewExamContract;
use FPDI;

    /**
 * Class DashboardControllerapp
 * @package App\Http\Controllers\Backend
 */
class ExamController extends Controller {
    
    /**
     * @param CourseContract $courses
     * @param SectionContract $sections
     */
    public function __construct(ExamContract $exams, QuestionContract $questions,EnrollmentContract $enrollments,
                                ExecutionContract $executions, QuestionsExecutionContract $questionsExecutions,
                                AnswersExecutionContract $answersExecutions, SubjectContract $subjects,
                                QuestionNoteContract $questionNotes, AskTheTeacherContract $askTheTeacher,
                                ViewExamContract $viewExams, PackageContract $packages) {
        $this->exams = $exams;
        $this->questions = $questions;
        $this->enrollments = $enrollments;
        $this->executions = $executions;
        $this->questionsExecutions = $questionsExecutions;
        $this->answersExecutions = $answersExecutions;
        $this->subjects = $subjects;
        $this->questionNotes = $questionNotes;
        $this->askTheTeacher = $askTheTeacher;
        $this->viewExams = $viewExams;
        $this->packages = $packages;
    }

    /**
     * 
     * @param $id
     * @return mixed
     */
    public function intro($id){
        //$exam = $this->exams->findOrThrowException($id);
        //if($this->enrollments->isStudentEnrolledModule(Auth::user()->id,$exam));

        //dd($this->countNotes($id));
        //$enrollment = $this->enrollments->getEnrollmentByExamStudent($id,Auth::user()->id);
        $enrollment =   $this->enrollments->find($id);
        $exam = $enrollment->exam;
        $order = 0;

        if(!$enrollment->executions->whereLoose('finished',0)->isEmpty() &&  $enrollment->executions->whereLoose('finished',0)->first()->last_question_execution != null &&  $enrollment->executions->whereLoose('finished',0)->first()->simulation_mode == 0 ){
            $order = $enrollment->executions->whereLoose('finished',0)->first()->last_question_execution->order;
        }

        $exam->video_frag = parse_video($exam->video_ad_url);

        return view('frontend.studentarea.exam.intro')
        ->withExam($exam)
        ->withOrder(++$order)
        ->withEnrollment($enrollment)
        ->withCountnote($this->countNotes($id));
    }
    
    /**
     * @return mixed
     */
    public function index($id, $simulation = 0) {


        //$exam = $this->exams->findOrThrowException($id);
        //$enrollment = $this->enrollments->getEnrollmentByExamStudent($id,Auth::user()->id);
        $enrollment =   $this->enrollments->find($id);
        $exam = $enrollment->exam;
        $execution = null;
        $time = $exam->duration;
        if($exam->time_by_question != null){
            $time = $exam->time_by_question;
        }

        $max_tries = $enrollment->exam_max_tries;
        if ($enrollment->exam_max_tries == null){
            $max_tries = $exam->max_tries;
        }

        if($enrollment->executions->max('attempt') > $max_tries || $enrollment->is_active == 0 || Carbon::today()->gt(new Carbon($enrollment->date_end)))
        {
            return $this->intro($id);
        }
        if(!$enrollment->executions->whereLoose('finished',0)->isEmpty() && $enrollment->executions->whereLoose('finished',0)->first()->simulation_mode == 1){
            $execution_to_finish = $enrollment->executions->whereLoose('finished',0)->first();
            if($execution_to_finish->updated_at != $execution_to_finish->created_at){
                $this->endTime($execution_to_finish);
                $this->executions->finish($execution_to_finish);
            }

        }


        if($enrollment->executions == null || $enrollment->executions->isEmpty() || $enrollment->executions->whereLoose('finished',0)->isEmpty()){
            $attempt = $enrollment->executions->whereLoose('finished',1);
            if($attempt->isEmpty()){
                $attempt = 1;
            }else{
                $attempt = $attempt->count() + 1;
            }
            $execution = $this->executions->create($enrollment,['attempt' => $attempt,'simulation' => $simulation]);
            $questionExec = $this->questionsExecutions->create($execution, $exam)->first();
        }else{
            $execution = $enrollment->executions->whereLoose('finished',0)->first();

            $questionExec = $execution->questions_executions->sortBy('order');
            if($execution->last_question_execution_id != null){
                $questionExec = $questionExec->where('id',$execution->last_question_execution_id);
                if($questionExec->first()->answersExecution != null){
                    $next = $this->questionsExecutions->findNext($questionExec->first()->id);
                    if($next == null){
                        $this->executions->finish($questionExec->first()->execution);
                        return $this->completeResults($questionExec->first()->execution->id);
                    }else{
                        $questionExec = $next;
                    }
                }else{
                    $questionExec = $questionExec->first();
                }
            }else{
                $questionExec = $questionExec->first();
            }
            if($execution->time != null){
                $time = $execution->time;
            }
        }

        return view('frontend.studentarea.exam.index')->withExam($exam)->withQuestionExec($questionExec)->withTime($time);
    }


    public function finalExam($enrollment_id){
        $enrollment = $this->enrollments->find($enrollment_id);
        $course = $enrollment->course;
        $execution = null;
        $time = $course->exam_duration;


        $execution = $this->executions->createForCourse($enrollment, $course);

        $questionExec = $this->questionsExecutions->create($execution, $course)->first();

        return view('frontend.studentarea.exam.index')->withCourse($course)->withQuestionExec($questionExec)->withTime($time);
    }






    public function nextQuestion(){

        $actual = $this->questionsExecutions->findOrThrowException($_POST['question']);

        $questionExecution = $this->questionsExecutions->findNext($_POST['question']);

        $fromResult = $_POST['from-result'];

///*        if($questionExecution != null && $actual->group != $questionExecution->group && $fromResult == '' && $actual->group->partial_result != null){
//            return $this->results($actual->execution,$actual->group,$actual);
//        }*/


        if($questionExecution == null) {
            $finished_execution = $this->executions->finish($actual->execution);
            if(  $actual->execution->enrollment->exam == null && $actual->execution->lesson !== null ){
                Log::info('Execução da sala de aula finalizada');

                return $this->resultsClassroomExam($finished_execution);
            }else{



            return 'end';
            //return $this->results($finished_execution);
            }
        }else{
            if(  $actual->execution->enrollment->exam == null && $actual->execution->enrollment->course == null) {


                $count = $this->questionsExecutions->getSiblingsCount($questionExecution->execution_id,true);
                return view('frontend.studentarea.classroom.exam.question')->withQuestionExec($questionExecution)->withCount($count);
            }else{
                return view('frontend.studentarea.exam.question')->withQuestionExec($questionExecution);
            }
        }
    }

    public function nextQuestionWithAlreadyAnswered(){

        $actual = $this->questionsExecutions->findOrThrowException($_POST['question']);
        $questionExecution = $this->questionsExecutions->findNextWithAlreadyAnswered($_POST['question']);
        $fromResult = $_POST['from-result'];

///*        if($questionExecution != null && $actual->group != $questionExecution->group && $fromResult == '' && $actual->group->partial_result != null){
//            return $this->results($actual->execution,$actual->group,$actual);
//        }*/


        if($questionExecution == null) {
            if($actual->execution->enrollment->exam === null){
                $count = $this->questionsExecutions->getSiblingsCount($actual->execution_id,true);

                return view('frontend.studentarea.classroom.exam.question')->withQuestionExec($actual)->withCount($count);
            }else {
                return view('frontend.studentarea.exam.question')->withQuestionExec($actual);
            }
            //return $this->results($finished_execution);
        }else{
            if($actual->execution->enrollment->exam === null) {
                $count = $this->questionsExecutions->getSiblingsCount($actual->execution_id, true);

                return view('frontend.studentarea.classroom.exam.question')->withQuestionExec($questionExecution)->withCount($count);

            }else{

            return view('frontend.studentarea.exam.question')->withQuestionExec($questionExecution);
            }
        }


    }

    public function getExamDuration($execution){
        if($execution->enrollment->exam !== null){
        $total_time = $execution->enrollment->exam->time_by_question;
        if($total_time == null) $total_time = $execution->enrollment->exam->duration;
            return $total_time;
        }else{
           return  $execution->enrollment->course->exam_duration;
        }
    }


    public function results($execution, $group = null,$next = null){
        $previous_rights = 0;
        $previous_subjects = [];

        if($execution->attempt > 1){
            $previous_execution = $this->executions->getPreviousAttempt($execution);
            $previous_rights = $this->getRightsFromExecution($previous_execution,$group);
            $previous_subjects = $this->groupAnswersBySubjectTree($previous_execution,$group);
        }

        $rights = $this->getRightsFromExecution($execution,$group);

        $total = get_questions_count($this->getExam($execution),$group);
        $partial = $this->get_partial_questions_count($execution,$group);
        $time = $this->get_questions_time($execution,$group);
        //TODO: Revisar o tempo para não usar apenas time_by_question
       $total_time = $this->getExamDuration($execution);

        $results_subject = $this->groupAnswersBySubjectTree($execution,$group);

        //dd($results_subject);

        $group_view = null;


        $level = $execution->enrollment->exam != null ? $execution->enrollment->exam->result_level : "2";
            $group_view = view('frontend.studentarea.exam.groups')->withGroupResults($results_subject)->withPreviousGroupResults($previous_subjects)->withExpected($this->getExam($execution)->minimum_percentage)->withLevel($level)->withType('group')->render();
        $results_discipline = [];
        if($group == null && $level == 1){
            $results_discipline =  $this->groupAnswersByDiscipline($execution)->reverse();
            $previous_disciplines = [];

            if($execution->attempt > 1){
                $previous_disciplines = $this->groupAnswersByDiscipline($previous_execution,$group);
            }

            $results_discipline_tree = $this->groupAnswersByDisciplineTree($execution)->reverse();
            $previous_disciplines_tree = [];

            if($execution->attempt > 1){
                $previous_disciplines_tree = $this->groupAnswersByDisciplineTree($previous_execution,$group);
            }

            $group_view = view('frontend.studentarea.exam.subjects-tree')->withPreviousRights($previous_rights)->withPreviousSubjects($previous_disciplines_tree)->
            withSubjects($results_discipline_tree)->withNext($next)->withLevel($execution->enrollment->exam->result_level)->withType('discipline')->render();
            $discipline_view = view('frontend.studentarea.exam.groups')->withGroupResults($results_discipline)->withPreviousGroupResults($previous_disciplines)->withExpected($execution->enrollment->exam->minimum_percentage)->withLevel($execution->enrollment->exam->result_level)->withType('discipline')->render();
        }


        //dd($results_subject);
        if($level == 2){
            return [
                        view('frontend.studentarea.exam.results')
                         ->withGroup($group)->withTime($time)
                         ->withTotalTime($total_time)
                         ->withExam($this->getExam($execution))
                         ->withTotal($total)
                         ->withRights($rights)
                         ->withNext($next)
                         ->withPartial($partial)
                         ->render(),
                        view('frontend.studentarea.exam.subjects-tree')
                         ->withPreviousRights($previous_rights)
                         ->withPreviousSubjects($previous_subjects)
                         ->withSubjects($results_subject)
                         ->withNext($next)
                         ->withLevel($level)
                         ->withType('group')
                         ->render(),
                        $group_view,
                        $results_subject, 
                        collect([])
                    ];
        }else{
            return [view('frontend.studentarea.exam.results')->withGroup($group)->withTime($time)->withTotalTime($total_time)->withExam($this->getExam($execution))->withTotal($total)->withRights($rights)->withNext($next)->withPartial($partial)->render(),
                $group_view,
                $discipline_view,
                $results_subject,
                $results_discipline_tree];
        }

        // return view('frontend.studentarea.exam.results')->withSubjects($results_subject)->withRights($rights)->
        // withTotal($total)->withPreviousRights($previous_rights)->withPreviousSubjects($previous_subjects)->withNext($next)->withTime($time)->withExam($execution->enrollment->exam);
    }
    public function statistics(){
        $executions = $this->executions->getByUser(Auth::user());
        //dd($executions);
        $results_subject = [];
        foreach($executions as $item){
            $groups = $item->questions_executions->groupBy(function($item,$key){
                if($item->question->subject == null) return "";
                return $item->question->subject->id;
            });
            foreach($groups as $group){
                $subject_title = $group->first()->question->subject->name;
                $total_count = $group->reduce(function($carry,$item){
                    if($item->answersExecution != null)
                        return $carry + $item->answersExecution->where('question_execution_id',$item->id)->where('is_right',1)->count();
                    else
                        return $carry;
                },0);
                $total_questions = $group->count();
                $array_statistics = [$total_questions,$total_count];
                $results_subject[$subject_title] = $array_statistics;
            }
        }
        return view('frontend.studentarea.exam.statistics')->withSubjects($results_subject);
    }

    public  function resultsClassroomExam($execution){

        if($execution->grade === null) {
            $rights = $execution->questions_executions->reject(function ($item) {
                return $item->grade === null;
            })->sum('grade');


            if ($execution->finished == 1) {
                $this->executions->updateGrade($execution, $rights);
            }
        }
        return  ['end-classroom',view('frontend.studentarea.classroom.exam.results')->withExecution($execution)->render()];

    }



    public function get_partial_questions_count($execution,$group = null){
        if($group == null){

            return $execution->questions_executions->
            reject(function($item) {
                return $item->grade === null;
            })->count();
        }else{
            return $execution->questions_executions->where('group_id',$group->id);
        }

    }

    public function get_questions_time($execution,$group = null){

        if($group == null) {
            if($execution->enrollment->exam == null || $execution->enrollment->exam->time_by_question == null ) {
                $time_pieces = explode(":", $execution->time);
                if(count($time_pieces) == 1) {
                    $seconds = $execution->time;
                } else if(count($time_pieces) == 2) {
                    $seconds = ($time_pieces[0] * 60) + $time_pieces[1];
                }else{
                    $seconds = ($time_pieces[0] * 3600) + ($time_pieces[1] * 60) + ($time_pieces[2]);
                }
                $duration = ($execution->enrollment->exam !== null ? $execution->enrollment->exam->duration : $execution->enrollment->course->exam_duration );
                $total_seconds  = (($duration * 60) - $seconds);

                return $total_seconds;
            }

            return $execution->questions_executions->reduce(function ($carry, $item) {
                if ($item->time == null) return $carry + 0;
                $time_pieces = explode(":", $item->time);
                $seconds = ($time_pieces[0] * 60) + $time_pieces[1];
                return $carry + (($item->group->exam->time_by_question * 60) - $seconds);
            }, 0);
        }else{
            return $execution->questions_executions->where('group_id',$group->id)->reduce(function ($carry, $item) {
                if ($item->time == null) return $carry + 0;
                $time_pieces = explode(":", $item->time);
                $seconds = ($time_pieces[0] * 60) + $time_pieces[1];
                return $carry + (($item->group->exam->time_by_question * 60) - $seconds);
            }, 0);
        }
    }

    public function groupAnswersByDiscipline($execution){
        $disciplines = $execution->questions_executions->reject(function($item) {
            return $item->grade === null;
        })->groupBy(function($item,$key){
            if($item->question->subject->parent->parent == null) return "Sem disciplina associada";
           return $item->question->subject->parent->parent->name;
       });


        $results_discipline = collect([]);

        foreach($disciplines as $discipline){
            $object =  $discipline->first()->question->subject->parent->parent;
            $subject_title = ($object == null ? "Sem disciplina associada" : $object->name);
            $total_count = $discipline->sum('grade');
            /*            $total_count = $group->reduce(function($carry,$item){
                            return $carry + $item->answersExecution->where('is_right',1)->count();
                        },0); */
            $total_questions = $discipline->count();
            $array_statistics = ['total' => $total_questions,'rights' => $total_count, 'id' => ($object == null ? 0 : $object->id), 'object' =>  $object];
            $results_discipline[$subject_title] = $array_statistics;
        }

        $results_discipline = $results_discipline->sortByDesc(function($item,$key){
            return ($item['rights'] * 100) / $item['total'];
        });


        return $results_discipline;

    }


    public function groupAnswersBySubject($execution,$group = null){
        $groups = null;
        if($group == null){
            $groups = $execution->questions_executions->groupBy(function($item,$key){
                return $item->question->subject->id;
            });
        }else{
            $groups = $execution->questions_executions->where('group_id',$group->id)->groupBy(function($item,$key){
                return $item->question->subject->id;
            });
        }
        $results_subject = collect([]);

        foreach($groups as $group){
            $subject_title = $group->first()->question->subject->name;
            $total_count = $group->sum('grade');
            /*            $total_count = $group->reduce(function($carry,$item){
                            return $carry + $item->answersExecution->where('is_right',1)->count();
                        },0); */
            $total_questions = $group->count();
            $array_statistics = ['total' => $total_questions,'rights' => $total_count, 'id' => $group->first()->question->subject->id, 'object' =>  $group->first()->question->subject];
            $results_subject[$subject_title] = $array_statistics;
        }

        $results_subject = $results_subject->sortByDesc(function($item,$key){
            return ($item['rights'] * 100) / $item['total'];
        });

        return $results_subject;
    }

    public function groupAnswersBySubjectTree($execution,$group = null){
        $groups = null;
        if($group == null){
            $groups = $execution->questions_executions->reject(function($item) {
                return $item->grade === null;
            })->groupBy(function($item,$key){
                return $item->question->subject->id;
            });
        }else{
            $groups = $execution->questions_executions->where('group_id',$group->id)->groupBy(function($item,$key){
                return $item->question->subject->id;
            });
        }
        $results_subject = collect([]);
        $results_subject_tree = collect([]);

        foreach($groups as $group){
            $subject_title = $group->first()->question->subject->name;
            /* $total_count = $group->reduce(function($carry,$item){
                 return $carry + $item->answersExecution->where('question_execution_id',$item->id)->where('is_right',1)->count();
             },0); */
            $total_count = $group->sum('grade');
            $total_questions = $group->count();
            $array_statistics = ['total' => $total_questions,'rights' => $total_count, 'id' => $group->first()->question->subject->id, 'object' =>  $group->first()->question->subject];

            $results_subject[$subject_title] = $array_statistics;

            $subject_parent = $group->first()->question->subject->parent;


            if(isset( $results_subject_tree[$subject_parent->name])){
                $results_subject_tree[$subject_parent->name]["total"] = $results_subject_tree[$group->first()->question->subject->parent->name]["total"] + $total_questions;
                $results_subject_tree[$subject_parent->name ]["rights"] = $results_subject_tree[$group->first()->question->subject->parent->name]["rights"] + $total_count;
            }else{
                $results_subject_tree[$subject_parent->name] = collect([]);
                $results_subject_tree[$subject_parent->name]["total"] =  $total_questions;
                $results_subject_tree[$subject_parent->name]["rights"] =  $total_count;
                $results_subject_tree[$subject_parent->name]["id"] =  $subject_parent->id;
                $results_subject_tree[$subject_parent->name]["object"] =  $subject_parent;
                $results_subject_tree[$subject_parent->name]["sons"] =  collect([]);
            }
            $results_subject_tree[$subject_parent->name]["sons"][$subject_title] = $array_statistics;
        }

        $results_subject_tree = $results_subject_tree->sortBy(function($item,$key){
            return ($item['rights'] * 100) / $item['total'];
        });

        return $results_subject_tree;
    }

    public function groupAnswersByDisciplineTree($execution){
        $disciplines = $execution->questions_executions->reject(function($item) {
            return $item->grade === null;
        })->groupBy(function($item,$key){
            if($item->question->subject->parent == null) return "Sem disciplina associada";
            return $item->question->subject->parent->name;
        });


        $results_discipline = collect([]);
        $results_discipline_tree = collect([]);

        foreach($disciplines as $discipline){
            $object =  $discipline->first()->question->subject->parent;
            $subject_title = ($object == null ? "Sem disciplina associada" : $object->name);
            $total_count = $discipline->sum('grade');
            /*            $total_count = $group->reduce(function($carry,$item){
                            return $carry + $item->answersExecution->where('is_right',1)->count();
                        },0); */
            $total_questions = $discipline->count();
            $array_statistics = ['total' => $total_questions,'rights' => $total_count, 'id' => ($object == null ? 0 : $object->id), 'object' =>  $object];
            $results_discipline[$subject_title] = $array_statistics;


            $subject_parent = $discipline->first()->question->subject->parent->parent;
            $subject_parent_name =  ($subject_parent == null ? "Sem disciplina associada" : $subject_parent->name);

            if(isset( $results_discipline_tree[$subject_parent_name])){
                $results_discipline_tree[$subject_parent_name]["total"] = $results_discipline_tree[$subject_parent_name]["total"] + $total_questions;
                $results_discipline_tree[$subject_parent_name]["rights"] = $results_discipline_tree[$subject_parent_name]["rights"] + $total_count;
            }else{
                $results_discipline_tree[$subject_parent_name] = collect([]);
                $results_discipline_tree[$subject_parent_name]["total"] =  $total_questions;
                $results_discipline_tree[$subject_parent_name]["rights"] =  $total_count;
                $results_discipline_tree[$subject_parent_name]["id"] =  $subject_parent != null ? $subject_parent->id : 0;
                $results_discipline_tree[$subject_parent_name]["object"] =  $subject_parent;
                $results_discipline_tree[$subject_parent_name]["sons"] =  collect([]);
            }
            $results_discipline_tree[$subject_parent_name]["sons"][$subject_title] = $array_statistics;



        }

        $results_discipline_tree = $results_discipline_tree->sortByDesc(function($item,$key){
            return ($item['rights'] * 100) / $item['total'];
        });


        return $results_discipline_tree;

    }



    public function getExam($execution){
        if($execution->enrollment->exam != null) return $execution->enrollment->exam;
        if($execution->enrollment->course != null) return $execution->enrollment->course;
        if($execution->enrollment->lesson != null) return $execution->enrollment->lesson;
    }




    public function getRightsFromExecution($execution, $group = null){

        if($group == null){
            if($execution->grade === null) {
                $rights = $execution->questions_executions->reject(function($item) {
                    return $item->grade === null;
                    })->sum('grade');



                if($execution->finished == 1){
                    $this->executions->updateGrade($execution, $rights);
                    $this->exams->updateAverageGrade($this->getExam($execution),$rights);
                }
                return $rights;
            }else{
                return $execution->grade;
            }
        }else{
            $rights = $execution->questions_executions->reject(function($item) {
                return $item->grade === null;
            })->where('group_id',$group->id)->sum('grade');


            return $rights;
        }

    }
    public function getRightAnswers(){
        $question = $this->questions->findOrThrowException($_POST['question']);
        $answers = $question->answers->lists('is_right','id');
        return $answers;
    }

    public function getExplanationURL(){
        $questionExec = $this->questionsExecutions->findOrThrowException($_POST['question']);
        $explanation_url = ($questionExec->question->explanation_url != null ? $questionExec->question->explanation_url : '' );
        
        //Removendo comentário da questão, que ficava acima das anotações
        /*$explanation_text = ($questionExec->question->explanation_text != null ? $questionExec->question->explanation_text . '<br><br>' : '' );*/

        $teacher_name = ($questionExec->question->teacher != null ? $questionExec->question->teacher->name : '' );



        $note = $this->questionNotes->getNoteByStudentOnQuestion(auth()->id(), $questionExec->question->id );
        $notetext = "";
        if (count($note) != 0 ){
            $notetext = $note->note;
        }


        $explanation_text = /*$explanation_text . */view('frontend.studentarea.exam.explanation-tools')
        ->withQuestion($questionExec->question)
        ->withNotetext( $notetext )
        ->render();

        //dd($explanation_text);
        $views = $this->viewExams->findByExecutionAndQuestion( 
            $questionExec->execution->id, 
            $questionExec->question->id
        );
        if ((count($views) === 0) || ($views->first()->view < $views->first()->max_view)) {
            return [
                $explanation_url, 
                $explanation_text, 
                $teacher_name
            ];
        }else{
            return [
                'expired',
                $explanation_text,$teacher_name
            ];
           // return [$explanation_url,$explanation_text,$teacher_name];
        }









     //   return [$explanation_url, $explanation_text, $teacher_name];
    }

    public function saveAnswer(){
        //TODO: Levar em consideração o peso - No modelo cespe, os valores vão de 1,0,-1
        //TODO: Testar com notas parciais


        $questionExecution = $this->questionsExecutions->findOrThrowException($_POST['question']);
        if($questionExecution->grade !== null && $questionExecution->execution->simulation_mode == 1){
            $this->answersExecutions->update($questionExecution->answersExecution,$_POST['answers'],$_POST['is_right']);
        }else if($questionExecution->grade === null){
            $this->answersExecutions->create($questionExecution->id,$_POST['answers'],$_POST['is_right']);
        }






        if($questionExecution->group->exam == null && $questionExecution->group->lesson != null){
            $this->saveLessonAnswer($questionExecution, $_POST['is_right'],$_POST['answers']);
            return;
        }



        if($questionExecution->group->exam != null && $questionExecution->group->exam->time_by_question != null){

            if($questionExecution->grade !== null){
                if($questionExecution->execution->simulation_mode == 0) return;

                $grade_now = $_POST['is_right'];
                $grade_then = $questionExecution->grade;

                if($grade_now > $grade_then){
                    $this->questions->decreaseWrong($questionExecution->question);
                }else if($grade_now < $grade_then){
                    $this->questions->decreaseRight($questionExecution->question);
                }
            }


            if(isset($_POST['time']) && $_POST['time'] != "")
                $this->questionsExecutions->updateTime($questionExecution,$_POST['time']);
            $this->questionsExecutions->setGrade($questionExecution,$_POST['is_right']);
            $this->executions->updateLastQuestion($questionExecution->execution, $questionExecution->id);




            if ($_POST['is_right'] === '1'){
                $this->questions->increaseRight( $questionExecution->question );
            } else if ($_POST['is_right'] === '0'){
                $this->questions->increaseWrong( $questionExecution->question );
            } else {
                $this->questions->increasePartial( $questionExecution->question );
            }

        }else{
            if($questionExecution->grade !== null){
                if($questionExecution->execution->simulation_mode == 0) return;


                $grade_now = $_POST['is_right'];
                $grade_then = $questionExecution->grade;

                if($grade_now > $grade_then){
                    $this->questions->decreaseWrong($questionExecution->question);
                }else if($grade_now < $grade_then){
                    $this->questions->decreaseRight($questionExecution->question);
                }
            }


            if(isset($_POST['time']) && $_POST['time'] != "")
            $this->executions->updateTime($questionExecution->execution->id,$_POST['time'], $questionExecution->id);
            $this->questionsExecutions->setGrade($questionExecution,$_POST['is_right']);
            $this->executions->updateLastQuestion($questionExecution->execution, $questionExecution->id);
            if(isset($_POST['crescent-time']) && $_POST['crescent-time'] != "")
            $this->questionsExecutions->updateTime($questionExecution,$_POST['crescent-time']);


            if ($_POST['is_right'] === '1'){
                $this->questions->increaseRight( $questionExecution->question );
            } else if ($_POST['is_right'] === '0'){
                $this->questions->increaseWrong( $questionExecution->question );
            } else {
                $this->questions->increasePartial( $questionExecution->question );
            }

        }

    }

    public function saveLessonAnswer($questionExecution, $isRight, $answers){

        $this->questionsExecutions->setGrade($questionExecution,$isRight);
        $this->executions->updateLastQuestion($questionExecution->execution, $questionExecution->id);

    }


    public function saveCourseAnswer($questionExecution,$isRight){
        $this->questionsExecutions->setGrade($questionExecution,$isRight);
        $this->executions->updateLastQuestion($questionExecution->execution, $questionExecution->id);


    }

    public function completeResults($id){
        $execution = $this->executions->findEager($id);//$this->executions->findOrThrowException($id);
        
        if($execution->simulation_mode == 1 && $execution->finished == 0){
            $this->endTime($execution);
            $this->executions->finish($execution);
            $execution = $this->executions->findEager($id);
        }


        //$execution->enrollment->exam->order->packages->filter(function($item)use($exam){ return !$item->package->exams->where('exam_id',$exam->exam_id)->isEmpty(); })->first()->package;

        $packages = $this->packages->getAllPackages()->shuffle()->take(20);
        $results = $this->results($execution);
        

        $questions_count = $this->getQuestionsCount($execution);
        Log::info('log.EXECUTION');
        Log::info($execution);
        $level = $this->getExamLevel($execution);
        Log::info('log.LEVEL');
        Log::info($level);
        $duration = $this->getExamDuration($execution);
        $percentage = $this->getExamMinimumPercentage($execution);

        //Recuperando lista de Saaps para indicação


        return view('frontend.studentarea.exam.complete-results')
                ->withResults($results)
                ->withExecution($execution)
                ->withSubjectResult($results[3])
                ->withPackages($packages)
                ->withQuestionsCount($questions_count)
                ->withLevel($level)
                ->withDuration($duration)
                ->withMinimumPercentage($percentage);
    }


    public function getExamLevel($execution){
        if($execution->enrollment->course != null ) return '2';
        return $execution->enrollment->exam->result_level;
    }


    public function getExamMinimumPercentage($execution){
        if($execution->enrollment->course != null) return $execution->enrollment->course->minimum_percentage;
        return $execution->enrollment->exam->minimum_percentage;
    }

    public function getQuestionsCount($execution){
        if($execution->enrollment->exam != null){
            return $execution->enrollment->exam->questions_count;
        }else{
            return $execution->questions_executions->count();
        }
    }

    public function performance(){
        $execution = $this->executions->findOrThrowException(75);
        $results_subject = $this->groupAnswersBySubject($execution);
        return $results_subject;
    }

    public function subjectRecommendation(){
        $subject = $this->subjects->findOrThrowException($_POST['subject']);

        return view('frontend.studentarea.exam.suggestion')->withSubject($subject);
    }


    public function getCourseSuggestion(){
        $subject_id = $_POST['subject'];
        $execution = $this->executions->findOrThrowException($_POST['execution']);
        $exam_id = $execution->enrollment->exam->id;


        $lesson = $this->exams->findLessonSuggestion($subject_id,$exam_id);



        if($lesson != null){
            return ['redirection',route('frontend.classroom',[$lesson->module->course->id,$lesson->module->id,$lesson->id])];
        }else{
            $subject = $this->subjects->findOrThrowException($subject_id);
            return ['blank'];
            //return ['suggestion',view('frontend.studentarea.exam.suggestion')->withSubject($subject)->render()];
        }


    }

    public function questionExplanation(){
        $question = $this->questions->findOrThrowException($_POST['question']);
        //$enrollment_id = $_POST['enrollment'];

        $execution_id = $_POST['execution'];

        $note = $this->questionNotes->getNoteByStudentOnQuestion(auth()->id(), $question->id );
        $notetext = "";
        if (count($note) != 0 ){
            $notetext = $note->note;
        }

        $views = $this->viewExams->findByExecutionAndQuestion( $execution_id, $question->id);
        if ((count($views) === 0) || ($views->first()->view < $views->first()->max_view)) {
            if (count($views) === 0){
               // $enrollment = $this->enrollments->find($enrollment_id);
                $execution = $this->executions->findOrThrowException($execution_id);
                if($execution->enrollment->exam === null){
                    $viewExam = $this->viewExams->createViewExam( $execution, $question, $execution->lesson->max_explanations_views); //adicionar max_view na tabela exam

                }else{
                $viewExam = $this->viewExams->createViewExam( $execution, $question, $execution->enrollment->exam->max_explanation_views); //adicionar max_view na tabela exam
                }
                $viewExam->view = $viewExam->view + 1;
                $viewExam->save();
            } else {
                $views->first()->view = $views->first()->view + 1;
                $views->first()->save();
            }

            return view('frontend.studentarea.exam.explanation-box')->withQuestion($question)->withNotetext( $notetext )->withShowvideo( true );
        } else {
            return view('frontend.studentarea.exam.explanation-box')->withQuestion($question)->withNotetext( $notetext )->withShowvideo( false );
        }

    }

    public function saveCurrentTime(){

        $questionExecution = $this->questionsExecutions->findOrThrowException($_POST['question']);
        $this->executions->updateOnlyTime($questionExecution->execution->id,$_POST['current-time'], $questionExecution->id);
    }

    public function saveQuestionTime()
    {

        $questionExecution = $this->questionsExecutions->findOrThrowException($_POST['question']);
        $this->questionsExecutions->updateTime($questionExecution, $_POST['current-time']);
    }



    public function endTime($execution = null){
        $unanswereds = null;

        if(isset($_POST['execution'])) $execution = $this->executions->findOrThrowException($_POST['execution']);


        if($execution == null){
            $questionExecution =  $this->questionsExecutions->findOrThrowException($_POST['question']);
            $execution = $questionExecution->execution;
            $unanswereds = $questionExecution->execution->questions_executions->where('grade',null);
        }else{
            $unanswereds = $execution->questions_executions->where('grade',null);
        }

        foreach($unanswereds as $unaswered){
            $unaswered->grade = 0;
            $unaswered->time = '00:00';
            $unaswered->save();
            $this->answersExecutions->create($unaswered,"",0);
        }

        $this->executions->finish($execution);

        $this->getRightsFromExecution($execution);


    }

    public function saveNote(){
        $note = $this->questionNotes->getNoteByStudentOnQuestion(auth()->id(), $_POST["question"]);

        if(count($note) != 0){
            $this->questionNotes->updateNote($note, $_POST["note"]);
        }else{
            $this->questionNotes->createNote( auth()->id(), $_POST["question"], $_POST["note"]);
        }
        return "1";
    }

    function questionNote(){
        $question = $this->questions->findOrThrowException($_POST['question']);
        return $question['note' . $_POST['note']];
    }

    public function saveAskTheTeacher(){
        $this->askTheTeacher->create($_POST["question"], $_POST["question_id"], null);
        return "1";
    }

    public function questionsNotAnswered(){
        $questions = $this->questionsExecutions->getQuestionsNotAnswered($_POST["execution"]);
        return view('frontend.studentarea.exam.questionsnotanswered')->withQuestions($questions);
    }

    public function questionsList(){
        $questions = $this->questionsExecutions->getQuestionsFromExecution($_POST["execution"]);
        return view('frontend.studentarea.exam.questionsnotanswered')->withQuestions($questions);
    }

    public function specificQuestion(){
        $questionExecution = $this->questionsExecutions->findOrThrowException($_POST['question_exec_id']);

        if($questionExecution == null) {
            $this->executions->finish($questionExecution->execution);
            return $this->results($questionExecution->execution);
        }

        //$note = $this->questionNotes->getNoteByStudentOnQuestion(auth()->id(), $questionExecution->question_id );

        if($questionExecution->execution->enrollment->exam === null){
            $count = $this->questionsExecutions->getSiblingsCount($questionExecution->execution_id,true);

            return view('frontend.studentarea.classroom.exam.question')->withQuestionExec($questionExecution)->withCount($count);
        }

        return view('frontend.studentarea.exam.question')->withQuestionExec($questionExecution);
    }


    public function questionNotAnswered(){
        $questionExecution = $this->questionsExecutions->findOrThrowException($_POST['question_exec_id']);

        if ($questionExecution->grade != null){
           return null;
        }

        if($questionExecution == null) {
            $this->executions->finish($questionExecution->execution);
            return $this->results($questionExecution->execution);
        }


        return view('frontend.studentarea.exam.question')->withQuestionExec($questionExecution);
    }

    public function prevQuestion(){
        $actual = $this->questionsExecutions->findOrThrowException($_POST['question']);
        $questionExecution = $this->questionsExecutions->findPrev($_POST['question']);

        if($questionExecution == null) {
            $this->executions->finish($actual->execution);
            return $this->results($actual->execution);
        }

        if($actual->execution->enrollment->exam === null){
            $count = $this->questionsExecutions->getSiblingsCount($questionExecution->execution_id,true);

            return view('frontend.studentarea.classroom.exam.question')->withQuestionExec($questionExecution)->withCount($count);
        }


        return view('frontend.studentarea.exam.question')->withQuestionExec($questionExecution);
    }

    function examNote(){
        $exam = $this->exams->findOrThrowException($_POST['exam']);
        if ($_POST['note'] === 'R')
            return $exam->required_reading;
        else if ($_POST['note'] === 'A')
            return $exam->additional_reading;
        else
            return $exam['note' . $_POST['note']];
    }

    public function saveRating(){
        $execution = $this->executions->findOrThrowException($_POST["execution"]);
        $rating = $_POST["rating"];
        $this->executions->updateRating($execution,$rating);
        $this->exams->updateRatingNaive($execution->enrollment->exam,$rating);
        return 'saved';
    }

    public function saveComment(){
        $execution = $this->executions->findOrThrowException($_POST["execution"]);
        $comment = $_POST['comment'];
        $this->executions->updateComment($execution,$comment);
        return 'saved';
    }


    public function createTeacherRating(){
        $teacher = $_POST["teacher"];
        $execution = $_POST["execution"];
        $rating_type = $_POST["rating-type"];
        $rating = $_POST["rating"];

        $this->executions->createOrUpdateTeacherRating($teacher,$execution, $rating_type,$rating);
    }

    public function incrementExplanationView(){
        
        $questionExecution = $this->questionsExecutions->findOrThrowException($_POST["question"]);
        $execution_id = $questionExecution->execution_id;

        $question_id = $questionExecution->question_id;

        $views = $this->viewExams->findByExecutionAndQuestion($execution_id,$question_id);

        if (count($views) === 0) {
            // $enrollment = $this->enrollments->find($enrollment_id);
            $execution = $this->executions->findOrThrowException($execution_id);
            $viewExam = $this->viewExams->createViewExam($execution, $questionExecution->question, $execution->enrollment->exam->max_explanation_views); //adicionar max_view na tabela exam
            $viewExam->view = $viewExam->view + 1;
            $viewExam->save();
        } else {
            $views->first()->view = $views->first()->view + 1;
            $views->first()->save();
        }


        return;

    }

    /**
     *
     * @param $enrollment_id
     * @return int
     */
    public function countNotes($enrollment_id){
        $enrollment = $this->enrollments->find($enrollment_id);
        if ($enrollment->student_id != auth()->id()){
            return;
        }
        return count($this->questionNotes->questionNotesFromEnrollment( $enrollment->id, $enrollment->student_id));
    }

    /**
     * 
     * @param $enrollment_id
     * @return mixed
     */
    public function exportNotes($enrollment_id){

        $enrollment = $this->enrollments->find($enrollment_id);
        if ($enrollment->student_id != auth()->id()){
            return;
        }

        /*$pdf = new FPDI('P', 'mm', 'A4'); //FPDI extends TCPDF

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
*/


        $questionNotes = $this->questionNotes->questionNotesFromEnrollment( $enrollment->id, $enrollment->student_id );

        //dd($questionNotes);

        /*$txt = view('frontend.studentarea.exam.export_notes')->withEnrollment( $enrollment )->withQuestions( $questionNotes )->render();
        $pdf->writeHTMLCell(180, 30, 10, 10, $txt, 0, 0, false, true, 'C', true);

        $pdf->Output('anot_' . $enrollment_id . '_' . $enrollment->student->personal_id . '.pdf', 'D');*/

        return view('frontend.studentarea.exam.export_notes')
            ->withEnrollment( $enrollment )
            ->withQuestions( $questionNotes );
    }

}