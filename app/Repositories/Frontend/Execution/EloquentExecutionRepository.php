<?php namespace App\Repositories\Frontend\Execution;

use App\Execution;
use App\Exceptions\GeneralException;
use App\TeacherRating;
use Carbon\Carbon;


/**
 * Class EloquentCourseRepository
 * @package App\Repositories\Course
 */
class EloquentExecutionRepository implements ExecutionContract {



	/**
	 * @param $id
	 * @return mixed
	 * @throws GeneralException
	 */
	public function findOrThrowException($id) {
		$execution = Execution::withTrashed()->find($id);

		if (! is_null($execution)) return $execution;

		throw new GeneralException('That execution does not exist.');
	}


	public function findEager($id){
		$execution = Execution::with('questions_executions.answersExecution',
			'questions_executions.group','questions_executions.question.subject','questions_executions.question.answers')->find($id);

		if (! is_null($execution)) return $execution;

		throw new GeneralException('That execution does not exist.');
	}


	public function findByEnrollmentAndLesson($enrollment,$lesson){

		$execution = Execution::where('enrollment_id',$enrollment)->where('lesson_id',$lesson)->orderBy('id','desc')->first();







		return $execution;



	}


	public function create($enrollment, $input)
	{
		$execution = new Execution();
		$execution->attempt = $input['attempt'];
		$execution->enrollment()->associate($enrollment);
		if($input['simulation'] == 1){
			$execution->display_explanation = 0;
			$execution->simulation_mode = 1;
		}else{
			$execution->display_explanation = 1;
			$execution->simulation_mode = 0;
		}

		/*
		if($enrollment->exam->display_explanation == 0){
			$execution->display_explanation = 0;
		}else{
			$execution->display_explanation = $input['display'];
		}*/

		$execution->finished = 0;
		$execution->save();
		return $execution;
	}

	public function createForLesson($enrollment,$lesson, $attempt = 1){
		$execution = new Execution();
		$execution->attempt = $attempt;
		$execution->enrollment()->associate($enrollment);
		$execution->lesson()->associate($lesson);
		$execution->display_explanation = 0;
		$execution->simulation_mode = 0;
		$execution->finished = 0;
		$execution->save();
		return $execution;
	}

	public function createForCourse($enrollment, $course,$attempt = 1){
		$execution = new Execution();
        $execution->attempt = $attempt;
        $execution->enrollment()->associate($enrollment);
        $execution->course()->associate($course);
        $execution->display_explanation = 0;
        $execution->simulation_mode = 1;
        $execution->finished = 0;
        $execution->save();
        return $execution;

	}

	public function updateTime($id, $time, $question_execution){
		$execution = $this->findOrThrowException($id);
		$execution->time = $time;
		$execution->last_question_execution()->associate($question_execution);
		$execution->save();



	}


	public function updateOnlyTime($id, $time){
		$execution = $this->findOrThrowException($id);
		$execution->time = $time;
		$execution->save();



	}


	public function updateLastQuestion($execution,$question_execution){
		$execution->last_question_execution()->associate($question_execution);
		$execution->save();
	}

	public function finish($execution){
		$execution->finished = 1;
		$execution->finished_at = Carbon::now();
		if($execution->save()){
			return $execution;
		}
	}

	public function getPreviousAttempt($execution)
	{
		$prev_execution = Execution::with('questions_executions.answersExecution','questions_executions.question.subject')->where('enrollment_id',$execution->enrollment->id)->where('attempt',($execution->attempt - 1))->first();

		return $prev_execution;
	}

	public function getByUser($user){
		$executions = Execution::join('enrollments',function($join) use($user){
			$join->on('executions.enrollment_id','=','enrollments.id')->where('enrollments.student_id','=', $user->id);
		})->select("executions.*")->get();

		return $executions;
	}

	public function updateGrade($execution, $rights){
		$execution->grade = $rights;
		$execution->save();
	}

	public function updateRating($execution,$rating){
		$execution->rating = $rating;
		$execution->save();
	}

	public function updateComment($execution,$comment){
		$execution->comment = $comment;
		$execution->save();
	}

	public function createOrUpdateTeacherRating($teacher, $execution,$rating_type,$rating){
		$teacher_rating  = TeacherRating::where('execution_id',$execution)->where('teacher_id',$teacher)->get();
		if($teacher_rating == null || $teacher_rating->isEmpty()) {
			$teacher_rating = new TeacherRating();
			$teacher_rating->execution()->associate($execution);
			$teacher_rating->exam()->associate(Execution::find($execution)->enrollment->exam->id);
			$teacher_rating->teacher()->associate($teacher);

		}else{
			$teacher_rating = $teacher_rating->first();
		}

		if($rating_type == 'teaching'){
			$teacher_rating->teaching_rating = $rating;
		}else{
			$teacher_rating->content_rating = $rating;

		}

		$teacher_rating->save();

	}




}