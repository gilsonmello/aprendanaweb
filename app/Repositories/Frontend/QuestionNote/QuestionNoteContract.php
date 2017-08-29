<?php namespace App\Repositories\Frontend\QuestionNote;

/**
 * Interface UserContract
 * @package App\Repositories\FaqCategory
 */
interface QuestionNoteContract {

    /**
     * @param $id
     * @return mixed
     */
    public function findOrThrowException($id);

    /**
     * @param $per_page
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getQuestionNotePaginated($per_page, $order_by = 'id', $sort = 'asc');

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAllQuestionNote($order_by = 'id', $sort = 'asc');


    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id);


    public function createNote($student_id, $question_id, $note);

    public function updateNote($modelNote, $note);

    public function getNoteByStudentOnQuestion($student_id, $question_id,  $order_by = 'id', $sort = 'asc');

    public function questionNotesFromEnrollment($enrollment_id, $student_id);

}