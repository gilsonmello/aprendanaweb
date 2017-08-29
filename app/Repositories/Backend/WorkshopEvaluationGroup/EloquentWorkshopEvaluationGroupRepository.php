<?php namespace App\Repositories\Backend\WorkshopEvaluationGroup;

use App\WorkshopEvaluationGroup;
use App\Exceptions\GeneralException;

/**
 * Class EloquentWorkshopEvaluationGroupRepository
 * @package App\Repositories\WorkshopEvaluationGroup
 */
class EloquentWorkshopEvaluationGroupRepository implements WorkshopEvaluationGroupContract {


//	public function __construct() {
//	}

    /**
     * @param $id
     * @return mixed
     * @throws GeneralException
     */
    public function findOrThrowException($id) {
        $workshopevaluationgroup = WorkshopEvaluationGroup::withTrashed()->find($id);

        if (! is_null($workshopevaluationgroup)) return $workshopevaluationgroup;

        throw new GeneralException('That workshopevaluationgroup does not exist.');
    }

    /**
     * @param $per_page
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getWorkshopEvaluationGroupsPaginated($per_page, $order_by = 'id', $sort = 'asc', $f_workshop_edit = '') {
        return WorkshopEvaluationGroup::where('workshop_id', '=', $f_workshop_edit)->orderBy($order_by, $sort)->paginate($per_page);
    }

    /**
     * @param $per_page
     * @return \Illuminate\Pagination\Paginator
     */
    public function getDeletedWorkshopEvaluationGroupsPaginated($per_page) {
        return WorkshopEvaluationGroup::onlyTrashed()->paginate($per_page);
    }

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAllWorkshopEvaluationGroups($order_by = 'id', $sort = 'asc') {
        return WorkshopEvaluationGroup::orderBy($order_by, $sort)->get();
    }

    /**
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function create($input, $workshop_id) {
        $workshopevaluationgroup = $this->createWorkshopEvaluationGroupStub($input, $workshop_id);
        if($workshopevaluationgroup->save())
            return $workshopevaluationgroup;
        throw new GeneralException('There was a problem creating this workshopevaluationgroup. Please try again.');
    }

    /**
     * @param $id
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function update($id, $input) {
        $workshopevaluationgroup = $this->findOrThrowException($id);


        if ($workshopevaluationgroup->update($input)) {
            $workshopevaluationgroup->position = $input['position'];
            $workshopevaluationgroup->max_students = $input['max_students'];
            $workshopevaluationgroup->is_active = isset($input['is_active']) ? 1 : 0;
            $workshopevaluationgroup->save();

            return $workshopevaluationgroup;
        }

        throw new GeneralException('There was a problem updating this workshopevaluationgroup. Please try again.');
    }

    /**
     * @param $id
     * @return bool
     * @throws GeneralException
     */
    public function destroy($id) {
        $workshopevaluationgroup = $this->findOrThrowException($id);
        if ($workshopevaluationgroup->delete())
            return true;

        throw new GeneralException("There was a problem deleting this workshopevaluationgroup. Please try again.");
    }

    /**
     * @param $input
     * @return mixed
     */
    private function createWorkshopEvaluationGroupStub($input, $workshop_id)
    {

        $workshopevaluationgroup = new WorkshopEvaluationGroup;
        $workshopevaluationgroup->workshop_id = $workshop_id;
        $workshopevaluationgroup->description = $input['description'];
        $workshopevaluationgroup->position = $input['position'];
        $workshopevaluationgroup->max_students = $input['max_students'];
        $workshopevaluationgroup->num_students = 0;
        $workshopevaluationgroup->is_active = isset($input['is_active']) ? 1 : 0;

        return $workshopevaluationgroup;
    }

}