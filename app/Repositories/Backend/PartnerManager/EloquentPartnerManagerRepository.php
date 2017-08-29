<?php

namespace App\Repositories\Backend\PartnerManager;

use App\Partner;
use App\PartnerManager;
use App\User;
use App\Course;
use App\Content;
use App\View;
use App\Exceptions\GeneralException;
use App\Preenrollment;
use Carbon\Carbon;
use App\Execution;
use Illuminate\Support\Facades\DB;

/**
 * Class EloquentPartnerManagerRepository
 * @package App\Repositories\Backend\PartnerManager
 */
class EloquentPartnerManagerRepository implements PartnerManagerContract {

    /**
     * Função para retornar o percentual de visualização dos alunos para os gerentes de conveniados
     * @param int $partner_id
     * @param string $name
     * @param string $date_begin
     * @param string $date_end
     * @param int $course_id
     * @param int $studentgroup_id
     * @return array mixed
     */
    public function usersPartnerPerfomance($per_page, $partner_id = null, $name = null, $date_begin = null, $date_end = null, $course_id, $studentgroup_id = null, &$count_student) {
        //Get all preenrollments
        $query = Preenrollment::query()
                ->selectRaw('preenrollments.*')
                ->join('enrollments', 'enrollments.id', '=', 'preenrollments.enrollment_id')
                ->selectRaw('enrollments.date_end as date_end, enrollments.date_begin as date_begin');

        //If partner_id I do join the tables on the condition    
        //Else I do join the tables without the condition 
        if (isset($partner_id) && !empty($partner_id)) {
            $query->join('partners', 'partners.id', '=', 'preenrollments.partner_id')
                    ->where('partners.id', '=', $partner_id)
                    ->selectRaw('partners.name AS partners_name, partners.id AS partners_id');
        } else {
            $query->join('partners', 'partners.id', '=', 'preenrollments.partner_id')
                    ->whereIn('partners.id', has_permission_partner())
                    ->selectRaw('partners.name AS partners_name, partners.id AS partners_id');
        }

        //If name I do join the tables on the condition    
        //Else I do join the tables without the condition 
        if (isset($name) && !empty($name)) {
            $query->join('users', 'users.id', '=', 'preenrollments.student_id')
                    ->where('users.name', 'like', '%' . $name . '%')
                    ->selectRaw('users.name AS users_name, users.email AS users_email');
        } else {
            $query->join('users', 'users.id', '=', 'preenrollments.student_id')
                    ->selectRaw('users.name AS users_name, users.email AS users_email');
        }

        //If date_begin I do join the tables on the condition    
        //I do without the condition
        if (isset($date_begin) && $date_begin != "")
            $query->where('preenrollments.created_at', '>', parsebr($date_begin));

        //If date_end I do join the tables on the condition    
        //I do without the condition
        if (isset($date_end) && $date_end != "")
            $query->where('preenrollments.created_at', '<', parsebr($date_end)->addDay());

        //If course_id I do join the tables on the condition    
        //Else I do join the tables without the condition 
        if (isset($course_id) && !empty($course_id)) {
            $query->join('courses', 'courses.id', '=', 'preenrollments.course_id')
                    ->where('courses.id', '=', $course_id)
                    ->selectRaw('courses.id AS courses_id, courses.title AS courses_title');
        } else {
            $query->join('courses', 'courses.id', '=', 'preenrollments.course_id')
                    ->selectRaw('courses.id AS courses_id, courses.title AS courses_title');
        }

        //If studentgroup_id I do join the tables on the condition    
        //Else I do join the tables without the condition
        if (isset($studentgroup_id) && !empty($studentgroup_id)) {
            $query->join('studentgroups', 'studentgroups.id', '=', 'preenrollments.studentgroup_id')
                    ->where('studentgroups.name', '=', $studentgroup_id)
                    ->selectRaw('studentgroups.id AS studentgroups_id, studentgroups.name AS studentgroups_name');
        } else {
            $query->join('studentgroups', 'studentgroups.id', '=', 'preenrollments.studentgroup_id')
                    ->selectRaw('studentgroups.id AS studentgroups_id, studentgroups.name AS studentgroups_name');
        }

        //Get all preenrollments paged
        $preenrollments = $query->orderBy('users.name', 'ASC')->paginate($per_page);

        //Return views the enrollments and course_id
        return $this->getAllViews($preenrollments, $course_id, $count_student);
    }

    /**
     *
     * @param type $per_page
     * @param type $date_begin
     * @param type $date_end
     * @param type $exam_id
     * @param type $partner_id
     * @param type $name
     * @param type $studentgroup
     * @return type array
     */
    public function executionSaap($per_page, $date_begin, $date_end, $exam_id, $partner_id, $name, $studentgroup) {

        //Recuperar todas as excuções junto com as matrículas
        $query = Execution::query()
                ->join('enrollments', 'enrollments.id', '=', 'executions.enrollment_id');

        //Se o usuário escolheu um conveniado, fazer a busca pelo ID selecionado
        //Se não, fazer busca somente dos conveniados que o gerente tem acesso
        if (isset($partner_id) && !empty($partner_id) && in_array($partner_id, has_permission_partner())) {
            $query->join('partners', 'partners.id', '=', 'enrollments.partner_id')
                    ->where('partners.id', '=', $partner_id)
                    ->selectRaw('partners.name AS partners_name, partners.id AS partners_id');
        } else {
            $query->join('partners', 'partners.id', '=', 'enrollments.partner_id')
                    ->whereIn('partners.id', has_permission_partner())
                    ->selectRaw('partners.name AS partners_name, partners.id AS partners_id');
        }

        //Se name for diferente de vazio
        if (isset($name) && !empty($name)) {
            $query->join('users', 'users.id', '=', 'enrollments.student_id')
                    ->where('users.name', 'like', '%' . $name . '%')
                    ->selectRaw('users.name AS users_name, users.email AS users_email');
        } else {
            $query->join('users', 'users.id', '=', 'enrollments.student_id')
                    ->selectRaw('users.name AS users_name, users.email AS users_email');
        }

        if (isset($date_begin) && !empty($date_begin)) {
            $query->selectRaw('
                executions.attempt as executions_attempt,
                executions.finished as executions_finished,
                executions.grade as executions_grade,
                executions.finished_at
            ')
                    ->whereDate('executions.created_at', '>=', parsebr($date_begin));
        }
        if (isset($date_end) && !empty($date_end)) {
            $query->selectRaw('
                executions.attempt as executions_attempt,
                executions.finished as executions_finished,
                executions.grade as executions_grade,
                executions.finished_at'
                    )
                    ->whereDate('executions.finished_at', '<=', parsebr($date_end));
        }

        //If exam_id I do join the tables on the condition
        //Else I do join the tables without the condition
        if (isset($exam_id) && !empty($exam_id)) {
            $query->join('exams', 'enrollments.exam_id', '=', 'exams.id')
                    ->where('exams.id', '=', $exam_id)
                    ->selectRaw('exams.id AS exams_id, exams.title AS exams_title, exams.questions_count,
                exams.max_tries');
        } else {
            $query->join('exams', 'enrollments.exam_id', '=', 'exams.id')
                    ->selectRaw('exams.id AS exams_id, exams.title AS exams_title, exams.questions_count,
                exams.max_tries');
        }

        //If studentgroup_id I do join the tables on the condition
        //Else I do join the tables without the condition
        if (isset($studentgroup) && !empty($studentgroup)) {
            $query->join('studentgroups', 'studentgroups.id', '=', 'enrollments.studentgroup_id')
                    ->where('studentgroups.name', 'like', '%' . $studentgroup . '%')
                    ->selectRaw('studentgroups.id AS studentgroups_id, studentgroups.name AS studentgroups_name');
        } else {
            $query->join('studentgroups', 'studentgroups.id', '=', 'enrollments.studentgroup_id')
                    ->selectRaw('studentgroups.id AS studentgroups_id, studentgroups.name AS studentgroups_name');
        }

        return $query->orderBy('users.name', 'ASC')->paginate($per_page);
    }

    /**
     * Função para fazer o cálculo de quantas visualização o aluno teve por bloco
     * @param array $preenrollments
     * @param int $course_id
     * @param int &$count_student
     * @return array mixed
     */
    private function getAllViews($preenrollments, $course_id, &$count_student) {

        //Get all contents the course_id
        $query = Content::query()
                ->join('lessons', 'lessons.id', '=', 'contents.lesson_id')
                ->join('modules', 'modules.id', '=', 'lessons.module_id')
                ->where('modules.course_id', '=', $course_id)
                ->where('contents.is_video', '=', 1)
                ->selectRaw('COUNT(name) as blocks');

        //Get count blocks in course_id
        $blocks = $query->first()->blocks;

        //Foreach all enrollments
        foreach ($preenrollments as $preenrollment) {

            //Get views the enrollment
            $query = View::where('enrollment_id', '=', $preenrollment->enrollment_id)
                    ->join('contents', 'view.content_id', '=', 'contents.id')
                    ->join('lessons', 'lessons.id', '=', 'contents.lesson_id')
                    ->select('view.*')
                    ->where('contents.is_video', '=', 1);

            //
            $views = $query->orderBy('created_at', 'ASC')->get();

            //Assigning a new collection to the object views
            $preenrollment->views = $views;

            //View counter
            $count_views = 0;

            //Going through all views
            foreach ($views as $view) {
                if ($view->view != 0) {
                    $count_views = $count_views + 1;
                }
            }
            //Creating a new object count_views and assigning the amount views of enrollment
            $preenrollment->count_views = $count_views;

            //Creating a new object contents and assigning the amount blocks of course
            $preenrollment->contents = $blocks;

            if ($preenrollment->contents === 0) {
                $preenrollment->contents = 1;
            }

            if (($preenrollment->date_end != null) && ($preenrollment->date_begin != null)) {
                if ((new Carbon($preenrollment->date_end))->gte(Carbon::now())) {
                    $weeks_to_end = (new Carbon($preenrollment->date_end))->diffInWeeks(Carbon::now());
                    if ($weeks_to_end === 0) {
                        $weeks_to_end = 1;
                    }
                    $preenrollment->pace_needed = ($preenrollment->contents - $preenrollment->count_views) / $weeks_to_end;
                    $date_to_end = Carbon::now();
                } else {

                    $preenrollment->pace_needed = -1;
                    $date_to_end = new Carbon($preenrollment->date_end);
                }

                //Calculating the percentage of views
                $preenrollment->percent_finished = $preenrollment->count_views / $preenrollment->contents * 100;

                $weeks_from_begin = (new Carbon($preenrollment->date_begin))->diffInWeeks($date_to_end);
                //
                if ($weeks_from_begin === 0) {
                    $weeks_from_begin = 1;
                }
                //
                $preenrollment->pace_per_week = $preenrollment->count_views / $weeks_from_begin;
            }
            //
            $count_student++;
        }

        return $preenrollments;
    }

    /**
     * Function to return all users
     * @return mixed
     */
    public function allPartnersUser() {
        return PartnerManager::join('partners', 'partners.id', '=', 'partner_managers.partner_id')
                        ->join('users', 'users.id', '=', 'partner_managers.user_id')
                        ->where('users.id', '=', Auth()->user()->id)
                        ->selectRaw('partners.id as partners_id, partners.name as partners_name')->get();
    }

    /**
     * Function to return all courses
     * @return array
     */
    public function allCourses() {
        return Course::all();
    }

    /**
     * Function to return all users
     * @return mixed
     */
    public function allUsers() {
        return User::selectRaw('id, name')
                        ->where('status', '=', '1')
                        ->where('name', '!=', '')
                        ->orderBy('name', 'ASC')
                        ->get();
    }

    /**
     * @param $id
     * @return mixed
     * @throws GeneralException
     */
    public function findOrThrowException($id) {
        $partner = Partner::withTrashed()->find($id);

        if (!is_null($partner))
            return $partner;

        throw new GeneralException('Parceiro inexistente.');
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getAllPartnerManagers($id) {
        return PartnerManager::where('partner_id', '=', $id)->get();
    }

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getPartner($id, $order_by = 'id', $sort = 'asc') {
        return Partner::where('id', '=', $id)->get();
    }

    /**
     * Function to delete partner
     * @param $partner_id
     */
    private function deleteAllUsersPartner($partner_id) {
        $query = PartnerManager::where('partner_id', '=', $partner_id);
        foreach ($query->get() as $partners) {
            $partners->delete();
        }
    }

    /**
     * @param $input
     * @return array|null
     */
    public function create($input) {

        $partnermanagers = new PartnerManager();

        //get id partner
        $partner_id = $input['partner_id'];

        //if there is no user, all records will be deleted
        if (count($input['users']) == 0) {
            $this->deleteAllUsersPartner($partner_id);
            return $partnermanagers;
        }

        //if any user or users, all records are deleted and inserted again
        if (count($input['users']) > 0) {
            $this->deleteAllUsersPartner($partner_id);
            foreach ($input['users'] as $user) {
                $partnermanagers->users()->attach([
                    $user => [
                        'partner_id' => $input['partner_id'],
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ]
                ]);
            }
            return $partnermanagers;
        }

        throw new GeneralException('There was a problem creating this partner manager. Please try again.');
    }

    public function getPerformanceInSaap($per_page, $date_begin, $date_end, $course_id = NULL, $partner_id = NULL, $saap = NULL, $saap_in_lesson = NULL, $proof = NULL, $studentgroup = NULL) {

        $where = '';
        $select = '';
        $join = '';
        if (!empty($date_begin) && isset($date_begin)) {
            $where .= " AND executions.created_at >= '" . parsebr($date_begin) . "'";
        }

        if (!empty($date_end) && isset($date_end)) {
            $where .= " AND executions.created_at <= '" . parsebr($date_end) . "'";
        }

        if (!empty($course_id) && isset($course_id)) {
            $join .= " INNER JOIN courses ON courses.id = executions.course_id";
            $select .= ", courses.minimum_percentage AS course_minimum_percentage";
            $where .= ' AND courses.id = ' . $course_id;
        }

        if (!empty($partner_id) && isset($partner_id)) {
            $ids_partner_managers = $partner_id;
        } else {
            $ids_partner_managers = implode(',', has_permission_partner());
        }

        if (!empty($studentgroup) && isset($studentgroup)) {
            $join .= " INNER JOIN studentgroups ON enrollments.studentgroup_id = studentgroups.id";
            $where .= " AND studentgroups.name like '%" . $studentgroup . "%'";
        }
        //dd($join, $select,$where);
        $query = DB::select(
                        DB::raw("
                SELECT executions.*,
                COUNT(
                  IF(questions_executions.grade = 1.00, 1, NULL)
                ) AS 'answered',
                COUNT(
                  IF(questions_executions.grade = 0.00, 1, NULL)
                ) AS 'errors',
                COUNT(
                  IF(questions_executions.grade IS NULL, 1, NULL)
                ) AS 'not_answered',
                students.name AS student_name,
                students.email AS student_email
                $select
                FROM executions
                INNER JOIN enrollments ON enrollments.id = executions.enrollment_id
                INNER JOIN questions_executions ON questions_executions.execution_id = executions.id
                INNER JOIN partners ON partners.id = enrollments.partner_id
                INNER JOIN users AS students ON students.id = enrollments.student_id
                $join
                WHERE partners.id IN ($ids_partner_managers)
                $where
                GROUP BY enrollments.id
            ")
        );
        dd($query);
        return $query;
    }

}
