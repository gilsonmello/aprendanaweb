<?php namespace App\Repositories\Backend\Group;

use App\Group;
use App\Exceptions\GeneralException;
use App\Repositories\Backend\Tag\TagContract;

/**
 * Class EloquentGroupRepository
 * @package App\Repositories\Group
 */
class EloquentGroupRepository implements GroupContract {


	public function __construct(TagContract $tags) {
        $this->tags = $tags;
	}

    /**
     * @param $id
     * @return mixed
     * @throws GeneralException
     */
    public function findOrThrowException($id) {
        $group = Group::withTrashed()->find($id);

        if (! is_null($group)) return $group;

        throw new GeneralException('That group does not exist.');
    }

    /**
     * @param $per_page
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */

    public function getGroupsPaginated($per_page, $order_by = 'id', $sort = 'asc', $f_exam_edit = 0) {
        return Group::where('exam_id', '=', $f_exam_edit)->orderBy($order_by, $sort)->paginate($per_page);
    }

    /**
     * @param $per_page
     * @return \Illuminate\Pagination\Paginator
     */
    public function getDeletedGroupsPaginated($per_page) {
        return Group::onlyTrashed()->paginate($per_page);
    }

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAllGroups($order_by = 'id', $sort = 'asc', $f_exam_edit = 0) {
        return Group::where('exam_id', '=', $f_exam_edit)->orderBy($order_by, $sort)->get();
    }

    /**
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function create($input, $f_exam_edit) {
        $group = $this->createGroupStub($input);
        $group->exam_id = $f_exam_edit;
        if($group->save())
            return $group;
        throw new GeneralException('There was a problem creating this group. Please try again.');
    }

    /**
     * @param $id
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function update($id, $input) {
        $group = $this->findOrThrowException($id);
        if ($group->update($input)) {
            $group->is_random = isset($input['is_random']) ? 1 : 0;
            $group->save();
            return $group;
        }

        throw new GeneralException('There was a problem updating this group. Please try again.');
    }

    /**
     * @param $id
     * @return bool
     * @throws GeneralException
     */
    public function destroy($id) {
        $group = $this->findOrThrowException($id);
        if ($group->delete())
            return true;

        throw new GeneralException("There was a problem deleting this group. Please try again.");
    }

    /**
     * @param $input
     * @return mixed
     */
    private function createGroupStub($input)
    {

        $group = new Group;
        $group->title = $input['title'];
        $group->answer_type = $input['answer_type'];
        $group->is_random = isset($input['is_random']) ? 1 : 0;
        $group->weight = $input['weight'];
        return $group;
    }


    public function createForLesson($lesson)
    {
        $input['title'] = '';
        $input['answer_type'] = 'M';
        $input['is_random'] = 1;
        $input['weight'] = 1;
        $group = $this->createGroupStub($input);
        $group->lesson_id = $lesson;
        if($group->save())
            return $group;
        throw new GeneralException('There was a problem creating this group. Please try again.');
    }

    public function createForCourse($course)
    {
        $input['title'] = '';
        $input['answer_type'] = 'M';
        $input['is_random'] = 1;
        $input['weight'] = 1;
        $group = $this->createGroupStub($input);
        $group->course_id = $course;
        if($group->save())
            return $group;
        throw new GeneralException('There was a problem creating this group. Please try again.');
    }


    public function createSubjectRelations($input)
    {
        $group = $this->findOrThrowException($input['group-id']);
        $group->title = $input['group-name'];


        $relation_array = [];
        for($i = 0; $i < count($input['subjects']); $i++){
            $source =   null;
            if(isset($input['sources']) && $input['sources'] != null && $input['sources'] != ""){
                $source = $input['sources'][$i];
                if($source == "") $source = null;
            }
            $relation_array += [$input['subjects'][$i] => ['source_id' => $source, 'questions_count' => $input['question_count'][$i]]];
        }
       
            $group->subjects()->sync($relation_array);


        $group->save();
    }

    public function createCourseSubjectRelations($input)
    {
        $group = $this->findOrThrowException($input['course-group-id']);
        $group->title = $input['course-group-name'];
        $course = $group->course;
        $course->exam_duration = $input['course-group-duration'];

        $relation_array = [];
        for($i = 0; $i < count($input['subjects-course']); $i++){
            $relation_array += [$input['subjects-course'][$i] => ['questions_count' => $input['question_count'][$i]]];
        }

        $group->subjects()->sync($relation_array);


        $group->save();
        $course->save();
    }
}