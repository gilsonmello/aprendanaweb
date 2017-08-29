<?php namespace App\Repositories\Frontend\ContentNotes;

use App\ContentNote;
use App\Exceptions\GeneralException;


class EloquentContentNotesRepository implements ContentNotesContract {


//	public function __construct() {
//	}

	/**
	 * @param $id
	 * @return mixed
	 * @throws GeneralException
	 */
	public function findOrThrowException($id) {
		$contentNotes = ContentNote::withTrashed()->find($id);

		if (! is_null($contentNotes)) return $contentNotes;

		throw new GeneralException('That Comentary does not exist.');
	}

	/**
	 * @param $per_page
	 * @param string $order_by
	 * @param string $sort
	 * @return mixed
	 */
	public function getContentNotesPaginated($per_page, $order_by = 'id', $sort = 'asc') {


		$query = ContentNote::orderBy($order_by, $sort)->paginate($per_page);

		return $query;
	}


	/**
	 * @param $per_page
	 * @return \Illuminate\Pagination\Paginator
	 */
	public function getDeletedContentNotesPaginated($per_page) {
		return ContentNote::onlyTrashed()->paginate($per_page);
	}

	/**
	 * @param string $order_by
	 * @param string $sort
	 * @return mixed
	 */
	public function getAllContentNotes($order_by = 'id', $sort = 'asc') {
		return ContentNote::orderBy($order_by, $sort)->get();
	}

    /**
     * @param $input
     * @return bool
     * @throws GeneralException
     */

    /**
     * @param $id
     * @return bool
     * @throws GeneralException
     */
    public function destroy($id) {
        $contentNotes = $this->findOrThrowException($id);
        if ($contentNotes->delete())
            return true;

        throw new GeneralException("There was a problem deleting this Comentary. Please try again.");
    }


	public function createNote($input){
        $note = $this->createNoteStub($input);
        $note->content()->associate($input["content"]);
        $note->student()->associate($input["student"]);

        if($note->save()) {



            return true;
        }
        throw new GeneralException('There was a problem creating this note. Please try again.');

	}

    public function createNoteStub($input){
        $note = new ContentNote();
        $note->note = $input["note"];
        $note->video_index_seconds = $input["seconds"];

        return $note;
        
    }

    public function getNotesByStudentOnContent($student_id, $content_id, $order_by = 'video_index_seconds', $sort = 'asc'){
        return ContentNote::distinct()->where('student_id',$student_id)->where('content_id',$content_id)->orderBy($order_by,$sort);
    }



}