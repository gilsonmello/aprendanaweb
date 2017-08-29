<?php namespace App\Repositories\Frontend\Exam;

/**
 * Interface UserContract
 * @package App\Repositories\Course
 */
interface ExamContract {

    /**
     * @param $id
     * @return mixed
     */
    public function findOrThrowException($id);

    public function updateAverageGrade($exam,$grade);

    public function updateRatingNaive($exam,$rating);

    public function getExamsByCourse($course);

    public function findLessonSuggestion($subject_id,$exam_id);
}