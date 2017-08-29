<?php namespace App\Repositories\Backend\WorkshopGroupTutor;

use App\WorkshopGroupTutor;
use App\Exceptions\GeneralException;

/**
 * Class EloquentWorkshopGroupTutorRepository
 * @package App\Repositories\WorkshopGroupTutor
 */
class EloquentWorkshopGroupTutorRepository implements WorkshopGroupTutorContract {


//	public function __construct() {
//	}

    /**
     * @param $id
     * @return mixed
     * @throws GeneralException
     */
    public function findOrThrowException($id) {
        $workshopgrouptutor = WorkshopGroupTutor::withTrashed()->find($id);

        if (! is_null($workshopgrouptutor)) return $workshopgrouptutor;

        throw new GeneralException('That workshopgrouptutor does not exist.');
    }

    /**
     * @param $per_page
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getWorkshopGroupTutorsPaginated($per_page, $order_by = 'id', $sort = 'asc', $f_evaluationgroup_edit = '') {
        return WorkshopGroupTutor::where('workshop_evaluation_group_id', '=', $f_evaluationgroup_edit)->orderBy($order_by, $sort)->paginate($per_page);
    }

    /**
     * @param $per_page
     * @return \Illuminate\Pagination\Paginator
     */
    public function getDeletedWorkshopGroupTutorsPaginated($per_page) {
        return WorkshopGroupTutor::onlyTrashed()->paginate($per_page);
    }

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAllWorkshopGroupTutors($order_by = 'id', $sort = 'asc') {
        return WorkshopGroupTutor::orderBy($order_by, $sort)->get();
    }

    /**
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function create($input, $evaluation_group_id) {
        $workshopgrouptutor = $this->createWorkshopGroupTutorStub($input, $evaluation_group_id);
        if($workshopgrouptutor->save())
            return $workshopgrouptutor;
        throw new GeneralException('There was a problem creating this workshopgrouptutor. Please try again.');
    }

    /**
     * @param $id
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function update($id, $input) {
        $workshopgrouptutor = $this->findOrThrowException($id);


        if ($workshopgrouptutor->update($input)) {
            $workshopgrouptutor->save();

            return $workshopgrouptutor;
        }

        throw new GeneralException('There was a problem updating this workshopgrouptutor. Please try again.');
    }

    /**
     * @param $id
     * @return bool
     * @throws GeneralException
     */
    public function destroy($id) {
        $workshopgrouptutor = $this->findOrThrowException($id);
        if ($workshopgrouptutor->delete())
            return true;

        throw new GeneralException("There was a problem deleting this workshopgrouptutor. Please try again.");
    }

    /**
     * @param $input
     * @return mixed
     */
    private function createWorkshopGroupTutorStub($input, $evaluation_group_id)
    {

        $workshopgrouptutor = new WorkshopGroupTutor;
        $workshopgrouptutor->workshop_evaluation_group_id = $evaluation_group_id;
        $workshopgrouptutor->tutor_id = $input['tutors'][0];
        $workshopgrouptutor->activity_id = $input['activities'][0];
        return $workshopgrouptutor;
    }

}