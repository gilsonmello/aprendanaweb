<?php namespace App\Repositories\Frontend\ContentNotes;

/**
 * Interface UserContract
 * @package App\Repositories\FaqCategory
 */
interface ContentNotesContract {

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
    public function getContentNotesPaginated($per_page, $order_by = 'id', $sort = 'asc');

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAllContentNotes($order_by = 'id', $sort = 'asc');


    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id);


    public function createNote($input);

    public function getNotesByStudentOnContent($student_id, $content_id, $order_by = 'video_index_seconds', $sort = 'asc');



}