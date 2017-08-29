<?php namespace App\Repositories\Backend\WorkshopTutor;

use App\WorkshopTutor;
use App\Exceptions\GeneralException;

/**
 * Class EloquentWorkshopTutorRepository
 * @package App\Repositories\WorkshopTutor
 */
class EloquentWorkshopTutorRepository implements WorkshopTutorContract {


//	public function __construct() {
//	}

    /**
     * @param $id
     * @return mixed
     * @throws GeneralException
     */
    public function findOrThrowException($id) {
        $workshoptutor = WorkshopTutor::withTrashed()->find($id);

        if (! is_null($workshoptutor)) return $workshoptutor;

        throw new GeneralException('That workshoptutor does not exist.');
    }

    /**
     * @param $per_page
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getWorkshopTutorsPaginated($per_page, $order_by = 'id', $sort = 'asc', $f_workshop_edit = '') {
        return WorkshopTutor::where('workshop_id', '=', $f_workshop_edit)->orderBy($order_by, $sort)->paginate($per_page);
    }

    /**
     * @param $per_page
     * @return \Illuminate\Pagination\Paginator
     */
    public function getDeletedWorkshopTutorsPaginated($per_page) {
        return WorkshopTutor::onlyTrashed()->paginate($per_page);
    }

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAllWorkshopTutors($order_by = 'id', $sort = 'asc') {
        return WorkshopTutor::orderBy($order_by, $sort)->get();
    }

    /**
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function create($input, $workshop_id) {
        $workshoptutor = $this->createWorkshopTutorStub($input, $workshop_id);
        if($workshoptutor->save())
            return $workshoptutor;
        throw new GeneralException('There was a problem creating this workshoptutor. Please try again.');
    }

    /**
     * @param $id
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function update($id, $input) {
        $workshoptutor = $this->findOrThrowException($id);


        if ($workshoptutor->update($input)) {
            $workshoptutor->position = $input['position'];
            $workshoptutor->max_students = $input['max_students'];
            $workshoptutor->is_active = isset($input['is_active']) ? 1 : 0;
            $workshoptutor->save();

            return $workshoptutor;
        }

        throw new GeneralException('There was a problem updating this workshoptutor. Please try again.');
    }

    /**
     * @param $id
     * @return bool
     * @throws GeneralException
     */
    public function destroy($id) {
        $workshoptutor = $this->findOrThrowException($id);
        if ($workshoptutor->delete())
            return true;

        throw new GeneralException("There was a problem deleting this workshoptutor. Please try again.");
    }

    /**
     * @param $input
     * @return mixed
     */
    private function createWorkshopTutorStub($input, $workshop_id)
    {

        $workshoptutor = new WorkshopTutor;
        $workshoptutor->workshop_id = $workshop_id;
        $workshoptutor->tutor_id = $input['tutors'][0];
        $workshoptutor->criteria_id = $input['criterias'][0];
        $workshoptutor->position = $input['position'];
        $workshoptutor->max_students = $input['max_students'];
        $workshoptutor->num_students = 0;
        $workshoptutor->is_active = isset($input['is_active']) ? 1 : 0;

        return $workshoptutor;
    }

}