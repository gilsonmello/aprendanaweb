<?php namespace App\Repositories\Frontend\Question;

/**
 * Interface UserContract
 * @package App\Repositories\Course
 */
interface QuestionContract {

    /**
     * @param $id
     * @return mixed
     */
    public function findOrThrowException($id);

    public function findByExam($exam_id);

    public function increaseRight($question);
    public function increaseWrong($question);
    public function increasePartial($question);

    public function decreaseRight($question);
    public function decreaseWrong($question);
    public function decreasePartial($question);


}