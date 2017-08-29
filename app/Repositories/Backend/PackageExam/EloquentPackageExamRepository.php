<?php namespace App\Repositories\Backend\PackageExam;

use App\PackageExam;
use App\Exceptions\GeneralException;
use App\Repositories\Backend\Tag\TagContract;

/**
 * Class EloquentPackageExamRepository
 * @package App\Repositories\PackageExam
 */
class EloquentPackageExamRepository implements PackageExamContract {


    public function __construct(TagContract $tags) {
        $this->tags = $tags;
    }

    /**
     * @param $id
     * @return mixed
     * @throws GeneralException
     */
    public function findOrThrowException($id) {
        $packageexam = PackageExam::withTrashed()->find($id);

        if (! is_null($packageexam)) return $packageexam;

        throw new GeneralException('That packageexam does not exist.');
    }

    /**
     * @param $per_page
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */

    public function getPackageExamsPaginated($per_page, $order_by = 'sequence', $sort = 'asc', $f_package_edit = 0) {
        return PackageExam::where('package_id', '=', $f_package_edit)->orderBy($order_by, $sort)->paginate($per_page);
    }

    /**
     * @param $per_page
     * @return \Illuminate\Pagination\Paginator
     */
    public function getDeletedPackageExamsPaginated($per_page) {
        return PackageExam::onlyTrashed()->paginate($per_page);
    }

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAllPackageExams($order_by = 'sequence', $sort = 'asc', $f_package_edit = 0) {
        return PackageExam::where('package_id', '=', $f_package_edit)->orderBy($order_by, $sort)->get();
    }

    /**
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function create($input, $f_package_edit) {
        $packageexam = $this->createPackageExamStub($input);
        $packageexam->package_id = $f_package_edit;
        $packageexam->exam_id = $input['exam_id'];
        if($packageexam->save())
            return $packageexam;
        throw new GeneralException('There was a problem creating this packageexam. Please try again.');
    }

    /**
     * @param $id
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function update($id, $input) {
        $packageexam = $this->findOrThrowException($id);
        if ($packageexam->update($input)) {
            $packageexam->is_random = isset($input['is_random']) ? 1 : 0;
            $packageexam->save();
            return $packageexam;
        }

        throw new GeneralException('There was a problem updating this packageexam. Please try again.');
    }

    /**
     * @param $id
     * @return bool
     * @throws GeneralException
     */
    public function destroy($id) {
        $packageexam = $this->findOrThrowException($id);
        if ($packageexam->delete())
            return true;

        throw new GeneralException("There was a problem deleting this packageexam. Please try again.");
    }

    /**
     * @param $input
     * @return mixed
     */
    private function createPackageExamStub($input)
    {
    }

    public function add($exam_id, $package_id){
        $packageexam = new PackageExam;
        $packageexam->exam_id = $exam_id;
        $packageexam->package_id = $package_id;
        $packageexam->save();
    }
}