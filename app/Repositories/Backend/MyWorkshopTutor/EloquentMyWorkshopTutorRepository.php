<?php namespace App\Repositories\Backend\MyWorkshopTutor;

use App\MyWorkshopTutor;
use App\Exceptions\GeneralException;
use App\User;
use App\Enrollment;
use App\WorkshopCriteria;
use App\WorkshopActivity;
use App\Workshop;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

/**
 * Class EloquentMyWorkshopTutorRepository
 * @package App\Repositories\MyWorkshopTutor
 */
class EloquentMyWorkshopTutorRepository implements MyWorkshopTutorContract {


//	public function __construct() {
//	}

    /**
     * @param $id
     * @return mixed
     * @throws GeneralException
     */
    public function findOrThrowException($id) {
        $myworkshoptutor = MyWorkshopTutor::withTrashed()->find($id);

        if (! is_null($myworkshoptutor)) return $myworkshoptutor;

        throw new GeneralException('That myworkshoptutor does not exist.');
    }

    /**
     * @return mixed
     */
    public function getAllTutors($param = ''){
        if(!empty($param)){
            return User::teachers()->where('users.name', 'like', '%'.$param.'%')->orderBy('name', 'asc')->get();
        }
        return User::teachers()->orderBy('name', 'asc')->get();
    }

    /**
     * @param array $param
     * @return mixed
     */
    public function getAllCriterias($param = null){
        if(isset($param)){
            return WorkshopCriteria::where('workshop_id', '=', $param['other'])->where('description', 'like', '%'.$param['term'].'%')->orderBy('description', 'asc')->get();
        }
        return WorkshopCriteria::orderBy('description', 'asc')->get();
    }

    /**
     * @param array $param
     * @return mixed
     */
    public function getAllActivities($param = null){
        if(isset($param)){
            return WorkshopActivity::where('workshop_id', '=', $param['other'])->where('description', 'like', '%'.$param['term'].'%')->orderBy('description', 'asc')->get();
        }
        return WorkshopActivity::orderBy('description', 'asc')->get();
    }

    /**
     * @param array $param
     * @return mixed
     */
    public function getAllWorkshops(){
        return Workshop::selectRaw('workshops.id AS Workshop_id, CONCAT(courses.title, " [ ", workshops.description, " ]") AS Title')
        ->join('courses', 'courses.id', '=', 'workshops.course_id')
        ->orderBy('workshops.description', 'asc')->get();
    }

    /**
     * @param $per_page
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getMyWorkshopTutorsPaginated($per_page, $order_by = 'id', $sort = 'asc', $student = '', $has_tutor = '', $workshop = '') {

        //Se não possui tutor
        if($has_tutor == '0'){

            //Pego todas as matrículas que possuem workshop e estão ativas
            $enrollments = Enrollment::where('enrollments.date_end', '>=', date('Y-m-d H:i:s'))
            ->where('enrollments.is_active', '=', 1)
            ->join('courses', 'courses.id', '=', 'enrollments.course_id')
            ->join('workshops', 'workshops.course_id', '=', 'courses.id')
            ->select('enrollments.*', 'courses.id AS Course_id', 'workshops.id AS Workshop_id')
            ->orderBy('workshops.id', 'asc');

            if(!empty($student)){
                $enrollments->join('users AS students', 'students.id', '=', 'enrollments.student_id')
                ->where('students.name', 'like', '%'.$student.'%');
            }
            
            if(!empty($workshop)){
                $enrollments->where('workshops.id', '=', $workshop);
            }

            $workshops = [];
            
            //Recupero todas as matrículas que não possuem tutor
            foreach($enrollments->get() as $enrollment){
                $query = MyWorkshopTutor::where('enrollment_id', '=', $enrollment->id)
                ->where('workshop_id', '=', $enrollment->Workshop_id)
                ->get()
                ->toArray();
                if(count($query) == 0){
                    $workshops[] = [$enrollment];
                }
            }

            //
            $items = [];

            //Retirando os índices desnecessários, exemplo: 0 => [ 0 => Enrollment {#2056 ▶}]
            //Para ficar somente 0 => Enrollment {#2056 ▶}
            foreach($workshops as $workshop){
                foreach($workshop as $result){
                    $items[] = $result;
                }
            }

            //Fazendo uma nova coleção
            $items = new Collection($items);
                
            //Get current page form url e.g. &page=1
            $currentPage = LengthAwarePaginator::resolveCurrentPage();

            //Slice the collection to get the items to display in current page
            $currentPageItems = $items->slice(($currentPage - 1) * $per_page, $per_page);

            return new LengthAwarePaginator($currentPageItems, 
                count($items), 
                $per_page, 
                Paginator::resolveCurrentPage(), 
                ['path' => Paginator::resolveCurrentPath()]
            );

        }else{

            //Se possui tutor
            
            $query = MyWorkshopTutor::query();
            $query->join('users', 'users.id', '=', 'my_workshop_tutors.tutor_id');
            $query->join('workshops', 'workshops.id', '=', 'my_workshop_tutors.workshop_id');

            if(!empty($workshop)){
                $query->where('workshops.id', '=', $workshop);
            }

            if(!empty($student)){
                $query->join('enrollments', 'enrollments.id', '=', 'my_workshop_tutors.enrollment_id')
                ->join('users AS students', 'students.id', '=', 'enrollments.student_id')
                ->where('students.name', 'like', '%'.$student.'%');
            }

            $query->select('my_workshop_tutors.*', 'workshops.id AS Workshop_id');

            return $query->orderBy('workshops.id', $sort)->paginate($per_page);
        }

        return false;
    }

    /**
     * @param $per_page
     * @return \Illuminate\Pagination\Paginator
     */
    public function getDeletedMyWorkshopTutorsPaginated($per_page) {
        return MyWorkshopTutor::onlyTrashed()->paginate($per_page);
    }

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAllMyWorkshopTutors($order_by = 'id', $sort = 'asc') {
        return MyWorkshopTutor::orderBy($order_by, $sort)->get();
    }

    /**
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function create($input) {
        $myworkshoptutor = $this->createMyWorkshopTutorStub($input);
        if($myworkshoptutor->save())
            return true;
        throw new GeneralException('There was a problem creating this myworkshoptutor. Please try again.');
    }

    /**
     * @param $id
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function update($id, $input) {

        $myworkshoptutor = $this->findOrThrowException($id);

        if ($myworkshoptutor->update($input)) {
            $myworkshoptutor->tutor_id = $input['tutor_id'];
            $myworkshoptutor->save();

            return $myworkshoptutor;
        }

        throw new GeneralException('There was a problem updating this myworkshoptutor. Please try again.');
    }

    /**
     * @param $id
     * @return bool
     * @throws GeneralException
     */
    public function destroy($id) {
        $myworkshoptutor = $this->findOrThrowException($id);
        if ($myworkshoptutor->delete())
            return true;

        throw new GeneralException("There was a problem deleting this myworkshoptutor. Please try again.");
    }

    /**
     * @param $input
     * @return mixed
     */
    private function createMyWorkshopTutorStub($input)
    {

        $myworkshoptutor = new MyWorkshopTutor;
        $myworkshoptutor->workshop_id = !empty($input['workshop_id']) ? $input['workshop_id'] : null;
        $myworkshoptutor->enrollment_id = !empty($input['enrollment_id']) ? $input['enrollment_id'] : null;
        $myworkshoptutor->tutor_id = !empty($input['tutor_id']) ? $input['tutor_id'] : null;
        $myworkshoptutor->activity_id = !empty($input['activity_id']) ? $input['activity_id'] : null;
        $myworkshoptutor->criteria_id = !empty($input['criteria_id']) ? $input['criteria_id'] : null;
        return $myworkshoptutor;
    }

}