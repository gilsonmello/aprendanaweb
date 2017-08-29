<?php

namespace App\Repositories\Backend\MyWorkshopEvaluation;

use App\MyWorkshopEvaluation;
use App\Exceptions\GeneralException;
use Carbon\Carbon;
use App\Workshop;
use App\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * Class EloquentMyWorkshopEvaluationRepository
 * @package App\Repositories\MyWorkshopEvaluation
 */
class EloquentMyWorkshopEvaluationRepository implements MyWorkshopEvaluationContract {
//	public function __construct() {
//	}

    /**
     * @return mixed
     */
    public function getAllTutors($param = '') {
        if (!empty($param)) {
            return User::teachers()->where('users.name', 'like', '%' . $param . '%')->orderBy('name', 'asc')->get();
        }
        return User::teachers()->orderBy('name', 'asc')->get();
    }

    /**
     * @param $id
     * @return mixed
     * @throws GeneralException
     */
    public function findOrThrowException($id) {
        $myworkshopevaluation = MyWorkshopEvaluation::withTrashed()->find($id);

        if (!is_null($myworkshopevaluation))
            return $myworkshopevaluation;

        throw new GeneralException('That myworkshopevaluation does not exist.');
    }

    /**
     * @param $type_report
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getActivitiesReport($type_report, $order_by = 'id', $sort = 'asc') {

        switch ($type_report) {
            case '1':
                return $this->getCountActivityAnsweredAndNotAnsweredTypeDetailed();
                break;
            case '0':
                return $this->getCountActivityAnsweredAndNotAnsweredTypeReduced();
                break;
        }
    }

    /**
     * @return mixed
     */
    private function getCountActivityAnsweredAndNotAnsweredTypeDetailed() {
        $query = MyWorkshopEvaluation::query()
                ->join('my_workshop_activities', 'my_workshop_activities.id', '=', 'my_workshop_evaluations.my_activity_id')
                ->join('workshop_activities', 'workshop_activities.id', '=', 'my_workshop_activities.activity_id')
                ->join('workshops', 'workshops.id', '=', 'workshop_activities.workshop_id')
                ->join('enrollments', 'enrollments.id', '=', 'my_workshop_activities.enrollment_id')
                ->join('users', 'users.id', '=', 'enrollments.student_id')
                ->select(
                        'my_workshop_evaluations.*', 'workshop_activities.id as workshopActivitiesID', 'workshop_activities.description AS workshopActivitiesDescription', 'workshops.description AS workshopDescription', 'users.name AS userName', 'users.email AS userEmail'
                )
                ->groupBy('workshop_activities.id')
                ->get();
        foreach ($query as $result) {

            $result->not_answer = NULL;
            $result->answer = NULL;

            $notAnswer = MyWorkshopEvaluation::query()
                            ->where('workshop_activities.id', '=', $result->workshopActivitiesID)
                            ->whereNotNull('my_workshop_evaluations.date_evaluation')
                            ->join('my_workshop_activities', 'my_workshop_activities.id', '=', 'my_workshop_evaluations.my_activity_id')
                            ->join('workshop_activities', 'workshop_activities.id', '=', 'my_workshop_activities.activity_id')
                            ->join('workshops', 'workshops.id', '=', 'workshop_activities.workshop_id')
                            ->join('enrollments', 'enrollments.id', '=', 'my_workshop_activities.enrollment_id')
                            ->join('users', 'users.id', '=', 'enrollments.student_id')
                            ->select(
                                    'my_workshop_evaluations.*', 'workshop_activities.id as workshopActivitiesID', 'workshop_activities.description AS workshopActivitiesDescription', 'workshops.description AS workshopDescription', 'users.name AS userName', 'users.email AS userEmail', 'users.cel AS userCel'
                            )->get();

            if (count($notAnswer) > 0) {
                $result->not_answer = $notAnswer;
            }

            $answer = MyWorkshopEvaluation::query()
                            ->where('workshop_activities.id', '=', $result->workshopActivitiesID)
                            ->whereNull('my_workshop_evaluations.date_evaluation')
                            ->join('my_workshop_activities', 'my_workshop_activities.id', '=', 'my_workshop_evaluations.my_activity_id')
                            ->join('workshop_activities', 'workshop_activities.id', '=', 'my_workshop_activities.activity_id')
                            ->join('workshops', 'workshops.id', '=', 'workshop_activities.workshop_id')
                            ->join('enrollments', 'enrollments.id', '=', 'my_workshop_activities.enrollment_id')
                            ->join('users', 'users.id', '=', 'enrollments.student_id')
                            ->select(
                                    'my_workshop_evaluations.*', 'workshop_activities.id as workshopActivitiesID', 'workshop_activities.description AS workshopActivitiesDescription', 'workshops.description AS workshopDescription', 'users.name AS userName', 'users.email AS userEmail', 'users.cel AS userCel'
                            )->get();
            if (count($answer) > 0) {
                $result->answer = $answer;
            }
        }
        return new Collection($query);
    }

    /**
     * @return mixed
     */
    private function getCountActivityAnsweredAndNotAnsweredTypeReduced() {
        $query = MyWorkshopEvaluation::query()
                ->join('my_workshop_activities', 'my_workshop_activities.id', '=', 'my_workshop_evaluations.my_activity_id')
                ->join('workshop_activities', 'workshop_activities.id', '=', 'my_workshop_activities.activity_id')
                ->join('workshops', 'workshops.id', '=', 'workshop_activities.workshop_id')
                ->select(
                        'my_workshop_evaluations.*', 'workshop_activities.id as workshopActivitiesID', 'workshop_activities.description AS workshopActivitiesDescription', 'workshops.description AS workshopDescription'
                )
                ->groupBy('workshop_activities.id')
                ->get();

        //dd($query);
        foreach ($query as $result) {
            $result->not_aswer = NULL;
            $result->answer = NULL;
            $notAnswer = MyWorkshopEvaluation::whereNull('my_workshop_evaluations.date_evaluation')
                    ->where('activity_id', '=', $result->workshopActivitiesID)
                    ->join('my_workshop_activities', 'my_workshop_activities.id', '=', 'my_workshop_evaluations.my_activity_id')
                    ->join('workshop_activities', 'workshop_activities.id', '=', 'my_workshop_activities.activity_id')
                    ->select(
                            'my_workshop_evaluations.*', 'workshop_activities.id AS activity_id', DB::raw('count(activity_id) as total'), 'workshop_activities.description AS workshopActivitiesDescription'
                    )
                    ->groupBy('workshop_activities.id')
                    ->get()
                    ->first();
            if (count($notAnswer) > 0) {
                $result->not_answer = $notAnswer;
            }


            $answer = MyWorkshopEvaluation::whereNotNull('my_workshop_evaluations.date_evaluation')
                    ->where('activity_id', '=', $result->workshopActivitiesID)
                    ->join('my_workshop_activities', 'my_workshop_activities.id', '=', 'my_workshop_evaluations.my_activity_id')
                    ->join('workshop_activities', 'workshop_activities.id', '=', 'my_workshop_activities.activity_id')
                    ->select(
                            'my_workshop_evaluations.*', 'workshop_activities.id as activity_id', DB::raw('count(activity_id) as total'), 'workshop_activities.description AS workshopActivitiesDescription'
                    )
                    ->groupBy('workshop_activities.id')
                    ->get()
                    ->first();

            if (count($answer) > 0) {
                $result->answer = $answer;
            }
        }
        return new Collection($query);
    }

    /**
     * @param $per_page
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getMyWorkshopEvaluationsPaginated($per_page = NULL, $f_evaluation_deadline_begin, $f_evaluation_deadline_end, $f_evaluation_status, $f_evaluation_workshop_id, $f_evaluation_student_name, $f_MyWorkshopEvaluationController_question, $order_by, $f_MyWorkshopEvaluationController_export_to_csv, $sort = 'asc') {

        $query = MyWorkshopEvaluation::query();

        $workshop = Workshop::query();

        $isCoordinator = false;
        $idsWorkshop = [];

        //Verificando se o usuário é coordenador e se for, guardo os ids dos workshops que ele tem acesso
        foreach ($workshop->get() as $workshop) {
            if (count($workshop->coordinators) > 0) {
                foreach ($workshop->coordinators as $coordinator) {
                    if ($coordinator->id == auth()->user()->id) {
                        $isCoordinator = true;
                        $idsWorkshop[] = $workshop->id;
                    }
                }
            }
        }

        //Se o usuário for administrador, lista todas as atividades dos workshops
        if (access()->hasRole('Administrador')) {
            $query->join('my_workshop_activities', 'my_workshop_evaluations.my_activity_id', '=', 'my_workshop_activities.id')
                    ->join('workshops', 'workshops.id', '=', 'my_workshop_activities.workshop_id');
        }
        //Se o usuário for coordenador, listar atividades do workshop que ele coordena
        else if ($isCoordinator === true) {
            $query->join('my_workshop_activities', 'my_workshop_evaluations.my_activity_id', '=', 'my_workshop_activities.id')
                    ->whereIn('my_workshop_activities.workshop_id', $idsWorkshop);
        }
        //Se o usuário for tutor, lista atividades que está direcionadas a ele
        else {
            $query = MyWorkshopEvaluation::where('my_workshop_evaluations.tutor_id', '=', auth()->user()->id);
            $query->join('my_workshop_activities', 'my_workshop_evaluations.my_activity_id', '=', 'my_workshop_activities.id')
                    ->join('workshops', 'workshops.id', '=', 'my_workshop_activities.workshop_id');
        }

        $query->select('my_workshop_evaluations.*');
        $query->where('my_workshop_evaluations.date_begin', '<=', Carbon::today());

        if (isset($f_MyWorkshopEvaluationController_question) && !empty($f_MyWorkshopEvaluationController_question)) {
            $query
                    ->join('workshop_activities', 'workshop_activities.id', '=', 'my_workshop_activities.activity_id')
                    ->where('workshop_activities.description', 'like', '%' . $f_MyWorkshopEvaluationController_question . '%');
        }

        if (!empty($f_evaluation_student_name) && isset($f_evaluation_student_name)) {
            $query
                    ->join('enrollments', 'enrollments.id', '=', 'my_workshop_activities.enrollment_id')
                    ->join('users', 'users.id', '=', 'enrollments.student_id')
                    ->where('users.name', 'like', '%' . $f_evaluation_student_name . '%');
        }

        if (isset($f_evaluation_deadline_begin) && $f_evaluation_deadline_begin != "") {
            $query
                    ->where('date_deadline', '>=', parsebr($f_evaluation_deadline_begin));
        }
        if (isset($f_evaluation_deadline_end) && $f_evaluation_deadline_end != "") {
            $query
                    ->where('date_deadline', '<', parsebr($f_evaluation_deadline_end)->addDay());
        }

        if (isset($f_evaluation_status) && $f_evaluation_status == "0")
            $query->whereNull('date_evaluation');
        else if (isset($f_evaluation_status) && $f_evaluation_status == "1")
            $query->whereNotNull('date_evaluation');

        if (($f_evaluation_workshop_id != null) && ($f_evaluation_workshop_id != '')) {
            $query->where('my_workshop_activities.workshop_id', '=', $f_evaluation_workshop_id);
        }

        //Possibilidades de ordenamento
        switch ($order_by) {
            //Ordenar pela data prazo de avaliação
            case '0':
                $query->orderBy('my_workshop_evaluations.date_deadline', 'desc');
                break;
            //Ordenar pela atividade e nome do aluno
            case '1':
                //Verifico se a variável existe, se existir é porque já foi feito o join
                //Se não, faço o join
                if (isset($f_MyWorkshopEvaluationController_question) && !empty($f_MyWorkshopEvaluationController_question)) {
                    $query->orderBy('workshop_activities.description', 'asc');
                } else {
                    $query->join('workshop_activities', 'workshop_activities.id', '=', 'my_workshop_activities.activity_id');
                    $query->orderBy('workshop_activities.description', 'asc');
                }
                if (!empty($f_evaluation_student_name) && isset($f_evaluation_student_name)) {
                    $query->orderBy('users.name', 'asc');
                } else {
                    $query->join('enrollments', 'enrollments.id', '=', 'my_workshop_activities.enrollment_id')
                            ->join('users', 'users.id', '=', 'enrollments.student_id')
                            ->orderBy('users.name', 'asc');
                }
                break;
            //Ordenar pela data de envio da resposta
            case '2':
                $query->orderBy('my_workshop_evaluations.date_evaluation', 'desc');
                break;
        }

        //$query->orderBy('my_workshop_evaluations.date_deadline', 'asc');
        if (isset($per_page))
            return $query->paginate($per_page);

        return $query->get();
    }

    /**
     * @param $per_page
     * @return \Illuminate\Pagination\Paginator
     */
    public function getDeletedMyWorkshopEvaluationsPaginated($per_page) {
        return MyWorkshopEvaluation::onlyTrashed()->paginate($per_page);
    }

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAllMyWorkshopEvaluations($order_by = 'id', $sort = 'asc') {
        return MyWorkshopEvaluation::join('courses', 'courses.id', '=', 'workshops.course_id')
                        ->selectRaw('*, CONCAT(workshops.description, " - ", courses.title) as description')
                        ->orderBy($order_by, $sort)->get();
    }

    /**
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function create($input, $workshop_id) {
        $myworkshopevaluation = $this->createMyWorkshopEvaluationStub($input, $workshop_id);
        if ($myworkshopevaluation->save())
            return $myworkshopevaluation;
        throw new GeneralException('There was a problem creating this myworkshopevaluation. Please try again.');
    }

    /**
     * @param $id
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function update($id, $input) {
        $myworkshopevaluation = $this->findOrThrowException($id);

        //if (Carbon::today()->gt( parsebr($myworkshopevaluation->date_deadline) )) return null;

        if ($myworkshopevaluation->update($input)) {
            $myworkshopevaluation->evaluation = $input['evaluation'];
            if (isset($input['grade'])) {
                $myworkshopevaluation->grade = str_replace("_", "", $input['grade']);               
            }
            $myworkshopevaluation->date_evaluation = Carbon::today();
            $myworkshopevaluation->save();
            return $myworkshopevaluation;
        }

        throw new GeneralException('There was a problem updating this myworkshopevaluation. Please try again.');
    }

    /**
     * @param $id
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function updateTutor($id, $input) {

        $myworkshopevaluation = $this->findOrThrowException($id);

        if ($myworkshopevaluation->update($input)) {
            if (isset($input['tutor_id'])) {
                $myworkshopevaluation->tutor_id = $input['tutor_id'];
            }
            $myworkshopevaluation->save();
            return true;
        }
        return false;
    }

    /**
     * @param $id
     * @return bool
     * @throws GeneralException
     */
    public function destroy($id) {
//        $myworkshopevaluation = $this->findOrThrowException($id);
//        if ($myworkshopevaluation->delete())
//            return true;
//
//        throw new GeneralException("There was a problem deleting this myworkshopevaluation. Please try again.");
    }

    /**
     * @param $input
     * @return mixed
     */
    private function createMyWorkshopEvaluationStub($input, $workshop_id) {
        
    }

    /**
     * @param $id
     * @param $new_file_name
     * @return bool
     * @throws GeneralException
     */
    public function updateUrlEvaluation($id, $new_file_name) {
        $package = $this->findOrThrowException($id);
        $package->url_evaluation = $new_file_name;
        if ($package->save())
            return true;

        throw new GeneralException('There was a problem updating this article. Please try again.');
    }

}
