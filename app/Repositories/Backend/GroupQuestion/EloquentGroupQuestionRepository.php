<?php namespace App\Repositories\Backend\GroupQuestion;

use App\GroupQuestion;
use App\Subject;
use App\Question;
use App\Exceptions\GeneralException;
use App\Repositories\Backend\Tag\TagContract;


/**
 * Class EloquentGroupQuestionRepository
 * @package App\Repositories\GroupQuestion
 */
class EloquentGroupQuestionRepository implements GroupQuestionContract {


    public function __construct(TagContract $tags) {
        $this->tags = $tags;
    }

    /**
     * @param $id
     * @return mixed
     * @throws GeneralException
     */
    public function findOrThrowException($id) {
        $groupquestion = GroupQuestion::find($id);

        if (! is_null($groupquestion)) return $groupquestion;

        throw new GeneralException('That groupquestion does not exist.');
    }

    /**
     * @param $per_page
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */

    public function getGroupQuestionsPaginated($per_page, $order_by = 'sequence', $sort = 'asc', $f_group_edit = 0) {
        return GroupQuestion::where('group_id', '=', $f_group_edit)->orderBy($order_by, $sort)->paginate($per_page);
    }

    /**
     * @param $per_page
     * @return \Illuminate\Pagination\Paginator
     */
    public function getDeletedGroupQuestionsPaginated($per_page) {
        return GroupQuestion::onlyTrashed()->paginate($per_page);
    }

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAllGroupQuestions($order_by = 'sequence', $sort = 'asc', $f_group_edit = 0) {
        return GroupQuestion::where('group_id', '=', $f_group_edit)->orderBy($order_by, $sort)->get();
    }

    /**
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function create($input, $f_group_edit) {
        $groupquestion = $this->createGroupQuestionStub($input);
        $groupquestion->group_id = $f_group_edit;
        $groupquestion->question_id = $input['question_id'];
        if($groupquestion->save())
            return $groupquestion;
        throw new GeneralException('There was a problem creating this groupquestion. Please try again.');
    }

    /**
     * @param $id
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function update($id, $input) {
        $groupquestion = $this->findOrThrowException($id);
        if ($groupquestion->update($input)) {
            $groupquestion->is_random = isset($input['is_random']) ? 1 : 0;
            $groupquestion->save();
            return $groupquestion;
        }

        throw new GeneralException('There was a problem updating this groupquestion. Please try again.');
    }

    /**
     * @param $id
     * @return bool
     * @throws GeneralException
     */
    public function destroy($id) {
        $groupquestion = $this->findOrThrowException($id);
        if ($groupquestion->delete())
            return true;

        throw new GeneralException("There was a problem deleting this groupquestion. Please try again.");
    }

    /**
     * @param $input
     * @return mixed
     */
    private function createGroupQuestionStub($input)
    {
    }

    public function nextSequence($groupid){
        return GroupQuestion::where("group_id",$groupid)->max("sequence");

    }

    public function changeSequence($groupid, $newsequence){
        if ($newsequence <=0){
            return false;
        }

        try{
            \DB::beginTransaction();
            $groupquestion = $this->findOrThrowException($groupid);
            if ($groupquestion->sequence  ==$newsequence){
                return false;
            } else if ($groupquestion->sequence  < $newsequence){
                GroupQuestion::where('group_id', '=', $groupquestion->group_id)
                    ->where('sequence', '>', $groupquestion->sequence)
                    ->where('sequence', '<=', $newsequence)
                    ->where('id', '!=', $groupquestion->id)
                    ->update(['sequence' => \DB::raw('sequence - 1')]);
                $groupquestion->sequence = $newsequence;
                $groupquestion->save();

            } else if ($groupquestion->sequence  > $newsequence){
                GroupQuestion::where('group_id', '=', $groupquestion->group_id)
                    ->where('sequence', '<', $groupquestion->sequence)
                    ->where('sequence', '>=', $newsequence)
                    ->where('id', '!=', $groupquestion->id)
                    ->update(['sequence' => \DB::raw('sequence + 1')]);
                $groupquestion->sequence = $newsequence;
                $groupquestion->save();
            }
            \DB::commit();
        } catch (Exception $e) {
            \DB::rollback();
        }


    }

    public function add($question_id, $group_id){
        $groupquestion = new GroupQuestion;
        $groupquestion->question_id = $question_id;
        $groupquestion->group_id = $group_id;
        $groupquestion->sequence = $this->nextSequence( $group_id ) + 1;
        $groupquestion->save();
    }

    public function getThemesOccurence($groupQuestion){
        $themes = Subject::join('questions', 'subjects.id', '=', 'questions.subject_id')
            ->join('group_question', 'questions.id', '=', 'group_question.question_id')
            ->join('subjects as sb2', 'subjects.subject_id', '=', 'sb2.id')
            ->join('subjects as sb3', 'sb2.subject_id', '=', 'sb3.id')
            ->where('group_question.group_id', '=', $groupQuestion)
            ->groupBy('sb3.name', 'sb2.name' )
            ->select( 'sb3.name as discipline', 'sb2.name as name' ,  \DB::raw('count(*) as questions '))
            ->orderBy('discipline','asc')->orderBy('questions','desc')->get();

       return $themes;
    }

    public function getSubthemesOccurence($groupQuestion){
        $subthemes = Subject::join('questions', 'subjects.id', '=', 'questions.subject_id')
            ->join('group_question', 'questions.id', '=', 'group_question.question_id')
            ->join('subjects as sb2', 'subjects.subject_id', '=', 'sb2.id')
            ->join('subjects as sb3', 'sb2.subject_id', '=', 'sb3.id')
            ->where('group_question.group_id', '=', $groupQuestion)
            ->groupBy('sb3.name', 'sb2.name', 'subjects.name' )
            ->select( 'sb3.name as discipline', 'sb2.name as theme' , 'subjects.name as name', \DB::raw('count(*) as questions '))
            ->orderBy('discipline','asc')->orderBy('questions','desc')->get();

        return $subthemes;
    }


    public function getOriginalsOccurence($groupQuestion){
        $originals = Question::join('group_question', 'questions.id', '=', 'group_question.question_id')
            ->where('group_question.group_id', '=', $groupQuestion)
            ->groupBy('questions.original' )
            ->select( 'questions.original as original', \DB::raw('count(*) as questions '))
            ->orderBy('questions','desc')->get();

        return $originals;
    }


}