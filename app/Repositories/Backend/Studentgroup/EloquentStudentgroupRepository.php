<?php namespace App\Repositories\Backend\Studentgroup;

use App\Studentgroup;
use App\Exceptions\GeneralException;

/**
 * Class EloquentStudentgroupRepository
 * @package App\Repositories\Studentgroup
 */
class EloquentStudentgroupRepository implements StudentgroupContract
{


//	public function __construct() {
//	}

    /**
     * @param $id
     * @return mixed
     * @throws GeneralException
     */
    public function findOrThrowException($id)
    {
        $studentgroup = Studentgroup::withTrashed()->find($id);

        if (!is_null($studentgroup)) return $studentgroup;

        throw new GeneralException('That studentgroup does not exist.');
    }

    /**
     * @param $per_page
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getStudentgroupsPaginated($per_page, $partner_id, $order_by = 'id', $sort = 'asc', $f_StudentgroupController_name = '')
    {
        $query = Studentgroup::whereNotNull('id');
        if (isset($partner_id) && $partner_id != "" && $partner_id != "0")
            $query->where('partner_id', '=', $partner_id);

        return $query->orderBy($order_by, $sort)->paginate($per_page);
    }

    public function getStundentGroupByPartnerAndName($partner_id, $name){
        $studentgroups = Studentgroup::where('partner_id', '=', $partner_id)->where('name', '=', $name)->get();
        if (count($studentgroups) != 0){
            return $studentgroups->first();
        } else {
            return null;
        }
    }
	/**
	 * @param $per_page
	 * @return \Illuminate\Pagination\Paginator
	 */
	public function getDeletedStudentgroupsPaginated($per_page) {
		return Studentgroup::onlyTrashed()->paginate($per_page);
	}

	/**
	 * @param string $order_by
	 * @param string $sort
	 * @return mixed
	 */
	public function getAllStudentgroups($order_by = 'id', $sort = 'asc') {
		return Studentgroup::orderBy($order_by, $sort)->get();
	}

    /**
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function create($input) {
        $studentgroup = $this->createStudentgroupStub($input);
        $studentgroup->partner()->associate($input['partner_id']);        unset($input['partner_id']);
        if($studentgroup->save())
            return $studentgroup;
        throw new GeneralException('There was a problem creating this studentgroup. Please try again.');
    }

    /**
     * @param $id
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function update($id, $input) {
        $studentgroup = $this->findOrThrowException($id);
        $studentgroup->name = $input['name'];
        $studentgroup->save();

        return $studentgroup;

        throw new GeneralException('There was a problem updating this studentgroup. Please try again.');
    }

    /**
     * @param $id
     * @return bool
     * @throws GeneralException
     */
    public function destroy($id) {
        $studentgroup = $this->findOrThrowException($id);
        if ($studentgroup->delete())
            return true;

        throw new GeneralException("There was a problem deleting this studentgroup. Please try again.");
    }

    /**
     * @param $input
     * @return mixed
     */
    private function createStudentgroupStub($input)
    {

        $studentgroup = new Studentgroup;
        $studentgroup->name = $input['name'];
        return $studentgroup;
    }

}