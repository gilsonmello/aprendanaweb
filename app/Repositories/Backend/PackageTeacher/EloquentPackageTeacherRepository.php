<?php namespace App\Repositories\Backend\PackageTeacher;

use App\Package;
use App\PackageTeacher;
use App\Exceptions\GeneralException;
use App\Repositories\Backend\PackageTeacher\PackageTeacherContract;
use App\User;

/**
 * Class EloquentPackageTeacherRepository
 * @package App\Repositories\PackageTeacher
 */
class EloquentPackageTeacherRepository implements PackageTeacherContract {


	/**
	 * @param $id
	 * @return mixed
	 * @throws GeneralException
	 */
	public function findOrThrowException($id) {
		$packageTeacher = PackageTeacher::withTrashed()->find($id);

		if (! is_null($packageTeacher)) return $packageTeacher;

		throw new GeneralException('That packageTeacher does not exist.');
	}

    public function findByPackageAndTeacher($package,$teacher){
        $packageTeacher = PackageTeacher::where('package_id',$package)->where('teacher_id',$teacher)->get()->first();

        if(! is_null($packageTeacher)) return $packageTeacher;
        else return null;

    }

	/**
	 * @param $per_page
	 * @param string $order_by
	 * @param string $sort
	 * @return mixed
	 */
	public function getPackageTeachersPaginated($per_page, $order_by = 'id', $sort = 'asc') {
		return PackageTeacher::orderBy($order_by, $sort)->paginate($per_page);
	}

	/**
	 * @param $per_page
	 * @return \Illuminate\Pagination\Paginator
	 */
	public function getDeletedPackageTeachersPaginated($per_page) {
		return PackageTeacher::onlyTrashed()->paginate($per_page);
	}

	/**
	 * @param string $order_by
	 * @param string $sort
	 * @return mixed
	 */
	public function getAllPackageTeachers($order_by = 'id', $sort = 'asc') {
		return PackageTeacher::orderBy($order_by, $sort)->get();
	}

    public function getAllPackageTeachersPerPackage($package, $order_by = 'id', $sort = 'asc') {
        return PackageTeacher::where('package_id', '=', $package)->orderBy($order_by, $sort)->get();
    }

    /**
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function create($teacher,$package,$percentage) {

        $packageTeacher = $this->createPackageTeacherStub($percentage);
        $packageTeacher->teacher()->associate(User::find($teacher));
        $packageTeacher->package()->associate(Package::find($package));
        if($packageTeacher->save())
            return $packageTeacher;
        throw new GeneralException('There was a problem creating this packageTeacher. Please try again.');
    }

    /**
     * @param $id
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function update($id, $percentage) {
        $packageTeacher = $this->findOrThrowException($id);



        if ($packageTeacher->update(['percentage' => $percentage])) {

            $packageTeacher->save();

            return $packageTeacher;
        }

        throw new GeneralException('There was a problem updating this packageTeacher. Please try again.');
    }

    /**
     * @param $id
     * @param $new_file_name
     * @return bool
     * @throws GeneralException
     */

    /**
     * @param $id
     * @return bool
     * @throws GeneralException
     */
    public function destroy($id) {
        $packageTeacher = $this->findOrThrowException($id);
        if ($packageTeacher->delete())
            return true;

        throw new GeneralException("There was a problem deleting this packageTeacher. Please try again.");
    }

    /**
     * @param $input
     * @return mixed
     */
    private function createPackageTeacherStub($percentage)
    {
        $packageTeacher = new PackageTeacher;
        $packageTeacher->percentage = $percentage;
        return $packageTeacher;
    }

    public function add($teacher_id, $package_id, $percentage){
        $packageteacher = new PackageTeacher;
        $packageteacher->teacher_id = $teacher_id;
        $packageteacher->package_id = $package_id;
        $packageteacher->percentage = $percentage;
        $packageteacher->save();
    }


}