<?php namespace App\Repositories\Backend\Workshop;

use App\Workshop;
use App\Exceptions\GeneralException;
use Illuminate\Support\Facades\Auth;

/**
 * Class EloquentWorkshopRepository
 * @package App\Repositories\Workshop
 */
class EloquentWorkshopRepository implements WorkshopContract {


//	public function __construct() {
//	}

    /**
     * @param $id
     * @return mixed
     * @throws GeneralException
     */
    public function findOrThrowException($id) {
        $workshop = Workshop::withTrashed()->find($id);

        if (! is_null($workshop)) return $workshop;

        throw new GeneralException('That workshop does not exist.');
    }

    /**
     * @param $per_page
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getWorkshopsPaginated($per_page, $order_by = 'id', $sort = 'asc', $f_WorkshopController_description = '') {

        if(access()->hasRole('Administrador')){
            return Workshop::select('workshops.*')
            ->where('description', 'like', '%'.$f_WorkshopController_description.'%')
            ->orderBy($order_by, $sort)->paginate($per_page);
        }
        return Workshop::select('workshops.*')
            ->join('workshop_coordinators', 'workshop_coordinators.workshop_id', '=', 'workshops.id')
            ->join('users', 'users.id', '=', 'workshop_coordinators.teacher_id')
            ->where('workshop_coordinators.teacher_id', '=', Auth::user()->id)
            ->where('description', 'like', '%'.$f_WorkshopController_description.'%')->orderBy($order_by, $sort)->paginate($per_page);
    }

    /**
     * @param $per_page
     * @return \Illuminate\Pagination\Paginator
     */
    public function getDeletedWorkshopsPaginated($per_page) {
        return Workshop::onlyTrashed()->paginate($per_page);
    }

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAllWorkshops($order_by = 'workshops.id', $sort = 'asc') {
        return Workshop::join('courses', 'courses.id', '=', 'workshops.course_id')
            ->selectRaw('workshops.id AS Workshop_id, workshops.description, courses.title, CONCAT(courses.title, " - ", workshops.description) as workshop_course')
            ->orderBy($order_by, $sort)->get();
    }

    /**
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function create($input) {
        $workshop = $this->createWorkshopStub($input);
        if($workshop->save())
            $workshop->coordinators()->attach($input['teachers']);
            return $workshop;
        throw new GeneralException('There was a problem creating this workshop. Please try again.');
    }

    /**
     * @param $id
     * @param $input
     * @param $coordinators
     * @return bool
     * @throws GeneralException
     */
    public function update($id, $input, $coordinators) {
        $workshop = $this->findOrThrowException($id);

        if ($workshop->update($input)) {
            if(isset($input['minimum_grade'])) {
                $workshop->minimum_grade = parsemoneybr($input['minimum_grade']);
            }

            if ((isset($input['minimum_grade'])) && ($input['minimum_grade'] != '')) {
                $workshop->available_days_after_enrollment = $input['available_days_after_enrollment'];
            }
            else {
                $workshop->available_days_after_enrollment = null;
            }

            if ((isset($input['available_date'])) && ($input['available_date'] != '')) {
                $workshop->available_date = parsebr($input['available_date']);
            }
            else {
                $workshop->available_date = null;
            }

            if($workshop->save()){
                if(count($coordinators['teachers']) > 0){
                    $workshop->coordinators()->sync($coordinators['teachers']);
                }else{
                    $workshop->coordinators()->sync([]);
                }
            }
            return $workshop;
        }

        throw new GeneralException('There was a problem updating this workshop. Please try again.');
    }

    /**
     * @param $id
     * @return bool
     * @throws GeneralException
     */
    public function destroy($id) {
        $workshop = $this->findOrThrowException($id);
        if ($workshop->delete())
            return true;

        throw new GeneralException("There was a problem deleting this workshop. Please try again.");
    }

    /**
     * @param $input
     * @return mixed
     */
    private function createWorkshopStub($input)
    {

        $workshop = new Workshop;
        $workshop->description = $input['description'];
        $workshop->content = $input['content'];

        $workshop->course_id = $input['courses'][0];

        if(isset($input['minimum_grade'])) $workshop->minimum_grade = parsemoneybr($input['minimum_grade']);
        if ((isset($input['available_days_after_enrollment'])) && ($input['available_days_after_enrollment'] != ''))
            $workshop->available_days_after_enrollment = $input['available_days_after_enrollment'];
        else
            $workshop->available_days_after_enrollment = null;

        if ((isset($input['available_date'])) && ($input['available_date'] != ''))
            $workshop->available_date = parsebr($input['available_date']);
        else
            $workshop->available_date = null;

        return $workshop;
    }

    public function isCoordinator($order_by = 'workshops.id', $sort = 'asc'){
        $user = auth()->user()->id;
        $query = Workshop::query();
        $query->join('workshop_coordinators', 'workshop_coordinators.workshop_id', '=', 'workshops.id');
        $query->join('users', 'users.id', '=', 'workshop_coordinators.teacher_id');
        $query->where('users.id', '=', $user);
        $query->select('users.id AS User_id', 'users.name AS User_name',
            'workshops.id AS Workshop_id',
            'workshops.description AS Workshop_description');
        return count($query->orderBy($order_by, $sort)->get()) ? true : false;
    }

    public function getAllActivitiesAndTutors($order_by = 'workshops.id', $sort = 'asc'){
        $user = auth()->user()->id;
        $query = Workshop::query();
        $query->join('workshop_coordinators', 'workshop_coordinators.workshop_id', '=', 'workshops.id');
        $query->join('users', 'users.id', '=', 'workshop_coordinators.teacher_id');
        $query->join('workshop_activities', 'workshop_activities.workshop_id', '=', 'workshops.id')
        ->where('users.id', '=', $user);
        $query->select('users.id AS User_id', 'users.name AS User_name',
            'workshops.id AS Workshop_id',
            'workshops.description AS Workshop_description',
            'workshop_activities.description AS WorkshopActivities_description',
            'workshop_activities.url_response AS WorkshopActivities_url_response');
        return $query->get();
    }
}