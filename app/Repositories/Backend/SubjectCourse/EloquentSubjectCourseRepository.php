<?php namespace App\Repositories\Backend\SubjectCourse;

use App\SubjectCourse;
use App\Exceptions\GeneralException;
use App\Repositories\Backend\Tag\TagContract;

/**
 * Class EloquentSubjectCourseRepository
 * @package App\Repositories\SubjectCourse
 */
class EloquentSubjectCourseRepository implements SubjectCourseContract {


    public function __construct(TagContract $tags) {
        $this->tags = $tags;
    }

    /**
     * @param $id
     * @return mixed
     * @throws GeneralException
     */
    public function findOrThrowException($id) {
        $subjectcourse = SubjectCourse::withTrashed()->find($id);

        if (! is_null($subjectcourse)) return $subjectcourse;

        throw new GeneralException('That subjectcourse does not exist.');
    }

    /**
     * @param $per_page
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */

    public function getSubjectCoursesPaginated($per_page, $order_by = 'id', $sort = 'asc', $f_subject_edit = 0) {
        return SubjectCourse::where('subject_id', '=', $f_subject_edit)->orderBy($order_by, $sort)->paginate($per_page);
    }

    /**
     * @param $per_page
     * @return \Illuminate\Pagination\Paginator
     */
    public function getDeletedSubjectCoursesPaginated($per_page) {
        return SubjectCourse::onlyTrashed()->paginate($per_page);
    }

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAllSubjectCourses($order_by = 'id', $sort = 'asc', $f_subject_edit = 0) {
        return SubjectCourse::where('subject_id', '=', $f_subject_edit)->orderBy($order_by, $sort)->get();
    }

    public function getAllSubjectCoursesConference() {
        return SubjectCourse::
            join('subjects as s1', 's1.id', '=', 'subjects_courses.subject_id')
            ->join('subjects as s2', 's2.id', '=', 's1.subject_id')
            ->select('subjects_courses.*')
            ->orderBy("s2.name", "asc")->orderBy("s1.name", "asc")->get();
    }

    /**
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function create($input, $f_subject_edit) {
        $subjectcourse = $this->createSubjectCourseStub($input);
        $subjectcourse->subject_id = $f_subject_edit;
        $subjectcourse->course_id = $input['course_id'];
        if($subjectcourse->save())
            return $subjectcourse;
        throw new GeneralException('There was a problem creating this subjectcourse. Please try again.');
    }

    /**
     * @param $id
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function update($id, $input) {
        $subjectcourse = $this->findOrThrowException($id);
        if ($subjectcourse->update($input)) {
            $subjectcourse->is_random = isset($input['is_random']) ? 1 : 0;
            $subjectcourse->save();
            return $subjectcourse;
        }

        throw new GeneralException('There was a problem updating this subjectcourse. Please try again.');
    }

    /**
     * @param $id
     * @return bool
     * @throws GeneralException
     */
    public function destroy($id) {
        $subjectcourse = $this->findOrThrowException($id);
        if ($subjectcourse->delete())
            return true;

        throw new GeneralException("There was a problem deleting this subjectcourse. Please try again.");
    }

    /**
     * @param $input
     * @return mixed
     */
    private function createSubjectCourseStub($input)
    {
    }

    public function add($course_id, $exam_id, $subject_id){
        $subjectcourse = new SubjectCourse;
        $subjectcourse->course_id = $course_id;
        $subjectcourse->subject_id = $subject_id;
        if (($exam_id != null) && ($exam_id != '0') && (isset($exam_id))){
            $subjectcourse->exam_id = $exam_id;
        } else {
            $subjectcourse->exam_id = null;
        }
        $subjectcourse->save();
    }
}