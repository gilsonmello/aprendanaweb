<?php namespace App\Repositories\Backend\ExamCourse;

use App\ExamCourse;
use App\Exceptions\GeneralException;
use App\Repositories\Backend\Tag\TagContract;

/**
 * Class EloquentExamCourseRepository
 * @package App\Repositories\ExamCourse
 */
class EloquentExamCourseRepository implements ExamCourseContract {


    public function __construct(TagContract $tags) {
        $this->tags = $tags;
    }

    /**
     * @param $id
     * @return mixed
     * @throws GeneralException
     */
    public function findOrThrowException($id) {
        $examcourse = ExamCourse::withTrashed()->find($id);

        if (! is_null($examcourse)) return $examcourse;

        throw new GeneralException('That examcourse does not exist.');
    }

    /**
     * @param $per_page
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */

    public function getExamCoursesPaginated($per_page, $order_by = 'id', $sort = 'asc', $f_exam_edit = 0) {
        return ExamCourse::where('exam_id', '=', $f_exam_edit)->orderBy($order_by, $sort)->paginate($per_page);
    }

    /**
     * @param $per_page
     * @return \Illuminate\Pagination\Paginator
     */
    public function getDeletedExamCoursesPaginated($per_page) {
        return ExamCourse::onlyTrashed()->paginate($per_page);
    }

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAllExamCourses($order_by = 'id', $sort = 'asc', $f_exam_edit = 0) {
        return ExamCourse::where('exam_id', '=', $f_exam_edit)->orderBy($order_by, $sort)->get();
    }

    /**
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function create($input, $f_exam_edit) {
        $examcourse = $this->createExamCourseStub($input);
        $examcourse->exam_id = $f_exam_edit;
        $examcourse->course_id = $input['course_id'];
        if($examcourse->save())
            return $examcourse;
        throw new GeneralException('There was a problem creating this examcourse. Please try again.');
    }

    /**
     * @param $id
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function update($id, $input) {
        $examcourse = $this->findOrThrowException($id);
        if ($examcourse->update($input)) {
            $examcourse->is_random = isset($input['is_random']) ? 1 : 0;
            $examcourse->save();
            return $examcourse;
        }

        throw new GeneralException('There was a problem updating this examcourse. Please try again.');
    }

    /**
     * @param $id
     * @return bool
     * @throws GeneralException
     */
    public function destroy($id) {
        $examcourse = $this->findOrThrowException($id);
        if ($examcourse->delete())
            return true;

        throw new GeneralException("There was a problem deleting this examcourse. Please try again.");
    }

    /**
     * @param $input
     * @return mixed
     */
    private function createExamCourseStub($input)
    {
    }

    public function add($course_id, $exam_id){
        $examcourse = new ExamCourse;
        $examcourse->course_id = $course_id;
        $examcourse->exam_id = $exam_id;
        $examcourse->save();
    }
}