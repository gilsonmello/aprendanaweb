<?php namespace App\Repositories\Backend\WorkshopCriteria;

use App\WorkshopCriteria;
use App\Exceptions\GeneralException;

/**
 * Class EloquentWorkshopCriteriaRepository
 * @package App\Repositories\WorkshopCriteria
 */
class EloquentWorkshopCriteriaRepository implements WorkshopCriteriaContract {


//	public function __construct() {
//	}

    /**
     * @param $id
     * @return mixed
     * @throws GeneralException
     */
    public function findOrThrowException($id) {
        $workshopcriteria = WorkshopCriteria::withTrashed()->find($id);

        if (! is_null($workshopcriteria)) return $workshopcriteria;

        throw new GeneralException('That workshopcriteria does not exist.');
    }

    /**
     * @param $per_page
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getWorkshopCriteriasPaginated($per_page, $order_by = 'id', $sort = 'asc', $f_workshop_edit = '') {
        return WorkshopCriteria::where('workshop_id', '=', $f_workshop_edit)->orderBy($order_by, $sort)->paginate($per_page);
    }

    /**
     * @param $per_page
     * @return \Illuminate\Pagination\Paginator
     */
    public function getDeletedWorkshopCriteriasPaginated($per_page) {
        return WorkshopCriteria::onlyTrashed()->paginate($per_page);
    }

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAllWorkshopCriterias($order_by = 'id', $sort = 'asc') {
        return WorkshopCriteria::orderBy($order_by, $sort)->get();
    }

    /**
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function create($input, $workshop_id) {
        $workshopcriteria = $this->createWorkshopCriteriaStub($input, $workshop_id);
        if($workshopcriteria->save())
            return $workshopcriteria;
        throw new GeneralException('There was a problem creating this workshopcriteria. Please try again.');
    }

    /**
     * @param $id
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function update($id, $input) {
        $workshopcriteria = $this->findOrThrowException($id);


        if ($workshopcriteria->update($input)) {
            $workshopcriteria->save();
            $workshopcriteria->description = $input['description'];
            $workshopcriteria->explanation = $input['explanation'];
            if(isset($input['max_grade'])) $workshopcriteria->max_grade = parsemoneybr($input['max_grade']);

            return $workshopcriteria;
        }

        throw new GeneralException('There was a problem updating this workshopcriteria. Please try again.');
    }

    /**
     * @param $id
     * @return bool
     * @throws GeneralException
     */
    public function destroy($id) {
        $workshopcriteria = $this->findOrThrowException($id);
        if ($workshopcriteria->delete())
            return true;

        throw new GeneralException("There was a problem deleting this workshopcriteria. Please try again.");
    }

    /**
     * @param $input
     * @return mixed
     */
    private function createWorkshopCriteriaStub($input, $workshop_id)
    {

        $workshopcriteria = new WorkshopCriteria;
        $workshopcriteria->workshop_id = $workshop_id;
        $workshopcriteria->description = $input['description'];
        $workshopcriteria->explanation = $input['explanation'];
        if(isset($input['max_grade'])) $workshopcriteria->max_grade = parsemoneybr($input['max_grade']);
        return $workshopcriteria;
    }

}