<?php namespace App\Repositories\Backend\Answer;

use App\Answer;
use App\Exceptions\GeneralException;

/**
 * Class EloquentAnswerRepository
 * @package App\Repositories\Answer
 */
class EloquentAnswerRepository implements AnswerContract {


//	public function __construct() {
//	}

    /**
     * @param $id
     * @return mixed
     * @throws GeneralException
     */
    public function findOrThrowException($id) {
        $answer = Answer::withTrashed()->find($id);

        if (! is_null($answer)) return $answer;

        throw new GeneralException('That answer does not exist.');
    }

    /**
     * @param $per_page
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */

    public function getAnswersPaginated($per_page, $order_by = 'id', $sort = 'asc', $f_AnswerController_text = '') {
        return Answer::where('text', 'like', '%'.$f_AnswerController_text.'%')->orderBy($order_by, $sort)->paginate($per_page);
    }

    /**
     * @param $per_page
     * @return \Illuminate\Pagination\Paginator
     */
    public function getDeletedAnswersPaginated($per_page) {
        return Answer::onlyTrashed()->paginate($per_page);
    }

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAllAnswers($order_by = 'id', $sort = 'asc') {
        return Answer::orderBy($order_by, $sort)->get();
    }

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAllAnswersByQuestion($question_id, $order_by = 'id', $sort = 'asc')
    {
        return Answer::where('question_id', '=', $question_id)->orderBy($order_by, $sort)->get();
    }

    /**
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function create($input) {
        $answer = $this->createAnswerStub($input);
        if($answer->save())
            return $answer;
        throw new GeneralException('There was a problem creating this answer. Please try again.');
    }

    /**
     * @param $id
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function update($id, $input) {
        $answer = $this->findOrThrowException($id);


        if ($answer->update($input)) {
            $answer->save();

            return $answer;
        }

        throw new GeneralException('There was a problem updating this answer. Please try again.');
    }

    /**
     * @param $id
     * @return bool
     * @throws GeneralException
     */
    public function destroy($id) {
        $answer = $this->findOrThrowException($id);
        if ($answer->delete())
            return true;

        throw new GeneralException("There was a problem deleting this answer. Please try again.");
    }

    /**
     * @param $input
     * @return mixed
     */
    private function createAnswerStub($input)
    {

        $answer = new Answer;
        $answer->text = $input['text'];
            return $answer;
    }

}