<?php namespace App\Repositories\Frontend\QuestionsExecution;

use App\Question;
use App\QuestionsExecution;
use App\Exceptions\GeneralException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


/**
 * Class EloquentCourseRepository
 * @package App\Repositories\Course
 */
class EloquentQuestionsExecutionRepository implements QuestionsExecutionContract {



    /**
     * @param $id
     * @return mixed
     * @throws GeneralException
     */
    public function findOrThrowException($id) {
        $questions_execution = QuestionsExecution::find($id);

        if (! is_null($questions_execution)) return $questions_execution;

        throw new GeneralException('That execution does not exist.');
    }


    public function findNextWithRemain($id){
        $current = QuestionsExecution::find($id);


        $next = QuestionsExecution::where('execution_id',$current->execution_id)->where('grade',null);
        $size = $next->get()->count();
        $sequence_next = $next->where('order','>',$current->order)->orderBy('order','asc')->get()->first();
        if($sequence_next == null){
            $next = $next->orderBy('order','asc')->get()->first();
            $next->questions_remaining = $size;
            return $next;
        }else{
            $sequence_next->questions_remaining = $size;
            return $sequence_next;
        }
    }


    public function findNext($id){
        $current = QuestionsExecution::find($id);



        $next = QuestionsExecution::with('question.answers')->where('execution_id',$current->execution_id)->where('grade',null)->where('order','>',$current->order)->orderBy('order','asc')->get()->first();
        if($next == null) $next = QuestionsExecution::with('question.answers')->where('execution_id',$current->execution_id)->where('grade',null)->orderBy('order','asc')->get()->first();



        return $next;
    }

    public function findNextWithAlreadyAnswered($id){
        $current = QuestionsExecution::find($id);


        $next = QuestionsExecution::with('question.answers')->where('execution_id',$current->execution_id)->where('order','>',$current->order)->orderBy('order','asc')->get()->first();
        if($next == null) $next = QuestionsExecution::with('question.answers')->where('execution_id',$current->execution_id)->orderBy('order','asc')->get()->first();

        return $next;
    }


    public function create($execution, $exam)
    {
        $taken = [];
        $order = 0;

        Log::info($exam->groups);
        foreach($exam->groups->sortBy('id') as $group){


            if(!$group->subjects->isEmpty())$order = $this->createBasedOnSubject($execution,$group);

            foreach($group->questions->sortBy(function($item){
                return $item->pivot->sequence;
            }) as $question){
                $questionExecution = new QuestionsExecution();
                $questionExecution->execution()->associate($execution);
                $questionExecution->question()->associate($question);
                $questionExecution->group()->associate($group);
                if($group->is_random == 1){
                    $random = rand(1,$group->questions->count());
                    while(in_array($random,$taken)){
                        $random = rand(1,$group->questions->count());
                    }
                    $questionExecution->order = $random + $order;
                    array_push($taken,$random);
                }else{
                    $questionExecution->order = count($taken) + 1 + $order;
                    array_push($taken,count($taken) + 1) ;
                }
                $questionExecution->save();
            }

        }
        return $execution->questions_executions();

    }


    public function createBasedOnSubject($execution,$group){


        $order = 0;


        $question_ids = $this->getQuestionsAnsweredInEnrollment($execution->enrollment);




        foreach($group->subjects()->get() as $subject_parent){
            $questions = Collect([]);



            foreach($subject_parent->children->shuffle() as $subject){

                Log::info('[Children]');
                Log::info($subject);



                if($subject_parent->pivot->source_id === null){
                    $questions_subject = $subject->questions->reject(function($item){ return $item->is_active != 1;})->shuffle()->sortBy(function($item,$key) use($question_ids){
                        if($question_ids->contains($key)) return 0;
                        else return 1;
                    });
                }else{
                    $source_id = $subject_parent->pivot->source_id;


                    $questions_subject = $subject->questions->reject(function($item) use($source_id) { return $item->is_active != 1 || $item->source_id != $source_id;})->shuffle()->sortBy(function($item,$key) use($question_ids){
                        if($question_ids->contains($key)) return 0;
                        else return 1;
                    });
                }


                $questions_subject = $questions_subject->take($subject_parent->pivot->questions_count);


                $questions = $questions->merge($questions_subject);

            }


            $questions = $questions->shuffle()->take($subject_parent->pivot->questions_count);
            foreach($questions as $question){

                $questionExecution = new QuestionsExecution();
                $questionExecution->execution()->associate($execution);
                $questionExecution->question()->associate($question);
                $questionExecution->group()->associate($group);

                $questionExecution->order = ++$order;



                $questionExecution->save();

            }
        }

        return $order;


    }



    public function getQuestionsAnsweredInEnrollment(){

        return Question::join('questions_executions','questions_executions.question_id','=','questions.id')->
        join('executions','questions_executions.execution_id','=','executions.id')->
        join('enrollments','executions.enrollment_id','=','enrollments.id')->
        where('enrollments.student_id','=',Auth::user()->id)->select("questions.id")->distinct()->get();


    }



    public function updateTime($object, $time)
    {
        $object->time = $time;
        $object->save();
    }

    public function setGrade($object, $grade)
    {
        $object->grade = $grade;
        $object->save();
    }

    public function getQuestionsNotAnswered( $execution ){
        return QuestionsExecution::where('execution_id', $execution)->where('grade',null)->orderBy('order','asc')->get();
    }

    public function getQuestionsFromExecution($execution){
        return QuestionsExecution::where('execution_id',$execution)->orderBy('order','asc')->get();
    }

    public function findPrev($id){
        $current = QuestionsExecution::find($id);

        $next = QuestionsExecution::with('question.answers')->where('execution_id',$current->execution_id)->where('order','<',$current->order)->orderBy('order','desc')->get()->first();
        if($next == null) $next = QuestionsExecution::with('question.answers')->where('execution_id',$current->execution_id)->orderBy('order','asc')->get()->first();


        return $next;
    }

    public function getSiblingsCount( $execution, $includeSelf ){
        if($includeSelf) return QuestionsExecution::where('execution_id', $execution)->count();
        return QuestionsExecution::where('execution_id', $execution)->count() - 1;

    }

}