<?php namespace App\Repositories\Frontend\Question;

use App\Question;
use App\Exceptions\GeneralException;
use App\QuestionNote;

/**
 * Class EloquentCourseRepository
 * @package App\Repositories\Course
 */
class EloquentQuestionRepository implements QuestionContract {


	/**
	 * @param $id
	 * @return mixed
	 * @throws GeneralException
	 */
	public function findOrThrowException($id) {
		$question = Question::withTrashed()->find($id);

		if (! is_null($question)) return $question;

		throw new GeneralException('That exam does not exist.');
	}


	public function findByExam($exam_id)
	{
		$questions = Question::all()->where('exam_id',$exam_id);

		return $questions;


	}

	public function increaseRight($question){
		$question->count_right = $question->count_right + 1;
		$question->save();
	}
	public function increaseWrong($question){
		$question->count_wrong = $question->count_wrong + 1;
		$question->save();
	}
	public function increasePartial($question){
		$question->count_partial = $question->count_partial + 1;
		$question->save();
	}

	public function decreaseRight($question){
		$question->count_right = $question->count_right - 1;
		$question->save();
	}
	public function decreaseWrong($question){
		$question->count_wrong = $question->count_wrong - 1;
		$question->save();
	}
	public function decreasePartial($question){
		$question->count_partial = $question->count_partial - 1;
		$question->save();
	}

}