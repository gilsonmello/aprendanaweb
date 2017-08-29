<?php namespace App\Repositories\Frontend\QuestionNote;

use App\QuestionNote;
use App\Exceptions\GeneralException;


class EloquentQuestionNoteRepository implements QuestionNoteContract {


//	public function __construct() {
//	}

	/**
	 * @param $id
	 * @return mixed
	 * @throws GeneralException
	 */
	public function findOrThrowException($id) {
		$questionNote = QuestionNote::withTrashed()->find($id);

		if (! is_null($questionNote)) return $questionNote;

		throw new GeneralException('That Comentary does not exist.');
	}

	/**
	 * @param $per_page
	 * @param string $order_by
	 * @param string $sort
	 * @return mixed
	 */
	public function getQuestionNotePaginated($per_page, $order_by = 'id', $sort = 'asc') {


		$query = QuestionNote::orderBy($order_by, $sort)->paginate($per_page);

		return $query;
	}


	/**
	 * @param $per_page
	 * @return \Illuminate\Pagination\Paginator
	 */
	public function getDeletedQuestionNotePaginated($per_page) {
		return QuestionNote::onlyTrashed()->paginate($per_page);
	}

	/**
	 * @param string $order_by
	 * @param string $sort
	 * @return mixed
	 */
	public function getAllQuestionNote($order_by = 'id', $sort = 'asc') {
		return QuestionNote::orderBy($order_by, $sort)->get();
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
        $questionNote = $this->findOrThrowException($id);
        if ($questionNote->delete())
            return true;

        throw new GeneralException("There was a problem deleting this Comentary. Please try again.");
    }


	public function createNote($student_id, $question_id, $note){
        $modelNote = new QuestionNote;
        $modelNote->question_id = $question_id;
        $modelNote->student_id = $student_id;
        $modelNote->note = $note;
        if($modelNote->save()) {
            return true;
        }
        throw new GeneralException('There was a problem creating this note. Please try again.');
	}

    public function updateNote($modelNote, $note){
        $modelNote->note = $note;
        if($modelNote->save()) {
            return true;
        }
        throw new GeneralException('There was a problem creating this note. Please try again.');

    }


    public function getNoteByStudentOnQuestion($student_id, $question_id,  $order_by = 'id', $sort = 'asc'){
        return QuestionNote::distinct()->where('student_id',$student_id)->where('question_id',$question_id)->orderBy($order_by,$sort)->first();
    }


    public function questionNotesFromEnrollment($enrollment_id, $student_id){
        $query = QuestionNote::whereNotNull('question_notes.id');
        $query->select('question_notes.note', 'questions_executions.order');
        $query->join('questions_executions', 'question_notes.question_id', '=', 'questions_executions.question_id');
        $query->join('executions', 'executions.id', '=', 'questions_executions.execution_id');
        $query->where('executions.enrollment_id', '=', $enrollment_id);
        $query->where('question_notes.student_id', '=', $student_id);
        return $query->orderBy('question_notes.note', 'desc')->distinct()->get();

    }

}