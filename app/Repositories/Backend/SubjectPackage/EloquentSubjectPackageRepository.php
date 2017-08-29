<?php namespace App\Repositories\Backend\SubjectPackage;

use App\SubjectPackage;
use App\Exceptions\GeneralException;
use App\Repositories\Backend\Tag\TagContract;

/**
 * Class EloquentSubjectCourseRepository
 * @package App\Repositories\SubjectCourse
 */
class EloquentSubjectPackageRepository implements SubjectPackageContract {


    public function __construct(TagContract $tags) {
        $this->tags = $tags;
    }

    /**
     * @param $id
     * @return mixed
     * @throws GeneralException
     */
    public function findOrThrowException($id) {
        $subjectpackage = SubjectPackage::withTrashed()->find($id);

        if (! is_null($subjectpackage)) return $subjectpackage;

        throw new GeneralException('That subjectpackage does not exist.');
    }

    /**
     * @param $per_page
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */

    public function getSubjectPackagesPaginated($per_page, $order_by = 'id', $sort = 'asc', $f_subject_edit = 0) {
        return SubjectPackage::where('subject_id', '=', $f_subject_edit)->orderBy($order_by, $sort)->paginate($per_page);
    }

    /**
     * @param $per_page
     * @return \Illuminate\Pagination\Paginator
     */
    public function getDeletedSubjectPackagesPaginated($per_page) {
        return SubjectPackage::onlyTrashed()->paginate($per_page);
    }

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAllSubjectPackages($order_by = 'id', $sort = 'asc', $f_subject_edit = 0) {
        return SubjectPackage::where('subject_id', '=', $f_subject_edit)->orderBy($order_by, $sort)->get();
    }

    /**
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function create($input, $f_subject_edit) {
        $subjectpackage = $this->createSubjectPackageStub($input);
        $subjectpackage->subject_id = $f_subject_edit;
        $subjectpackage->package_id = $input['package_id'];
        if($subjectpackage->save())
            return $subjectpackage;
        throw new GeneralException('There was a problem creating this subjectcourse. Please try again.');
    }

    /**
     * @param $id
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function update($id, $input) {
        $subjectpackage = $this->findOrThrowException($id);
        if ($subjectpackage->update($input)) {
            $subjectpackage->is_random = isset($input['is_random']) ? 1 : 0;
            $subjectpackage->save();
            return $subjectpackage;
        }

        throw new GeneralException('There was a problem updating this subjectcourse. Please try again.');
    }

    /**
     * @param $id
     * @return bool
     * @throws GeneralException
     */
    public function destroy($id) {
        $subjectpackage = $this->findOrThrowException($id);
        if ($subjectpackage->delete())
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

    public function add($package_id, $exam_id, $subject_id){
        $subjectpackage = new SubjectPackage;
        $subjectpackage->package_id = $package_id;
        $subjectpackage->subject_id = $subject_id;
        if (($exam_id != null) && ($exam_id != '0') && (isset($exam_id))){
            $subjectpackage->exam_id = $exam_id;
        } else {
            $subjectpackage->exam_id = null;
        }
        $subjectpackage->save();
    }
}