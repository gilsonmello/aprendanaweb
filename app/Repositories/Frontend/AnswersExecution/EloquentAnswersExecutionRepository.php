<?php namespace App\Repositories\Frontend\AnswersExecution;

use App\AnswerExecution;
use App\Exceptions\GeneralException;


/**
 * Class EloquentCourseRepository
 * @package App\Repositories\Course
 */
class EloquentAnswersExecutionRepository implements AnswersExecutionContract {



	/**
	 * @param $id
	 * @return mixed
	 * @throws GeneralException
	 */
	public function findOrThrowException($id) {
		$answer_execution = AnswerExecution::find($id);

		if (! is_null($answer_execution)) return $answer_execution;

		throw new GeneralException('That execution does not exist.');
	}


	public function create($question_execution, $answers, $is_right)
	{


		$answer_execution = new AnswerExecution();
		$answer_execution->is_right = $is_right;
		$answer_execution->questionExecution()->associate($question_execution);
		$answer_execution->answers_chosen = $answers;
		$answer_execution->save();


	}

	public function update($answer_execution, $answers, $is_right)
	{
		$answer_execution->is_right = $is_right;
		$answer_execution->answers_chosen = $answers;
		$answer_execution->save();
	}
}