<?php

namespace App\Repositories\Backend\WorkshopActivity;

use App\MyWorkshopActivity;
use App\MyWorkshopEvaluation;
use App\Workshop;
use App\Enrollment;
use App\WorkshopActivity;
use App\Exceptions\GeneralException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * Class EloquentWorkshopActivityRepository
 * @package App\Repositories\WorkshopActivity
 */
class EloquentWorkshopActivityRepository implements WorkshopActivityContract {

	
    public function __construct() {

    }

    public function notifyActivities(){
        $activities = WorkshopActivity::join('workshops', 'workshops.id', '=', 'workshop_activities.workshop_id');
        dd($activities->get());
    }
    /**
     * @param $id
     * @return mixed
     * @throws GeneralException
     */
    public function findOrThrowException($id) {
        $workshopactivity = WorkshopActivity::withTrashed()->find($id);

        /*$activities = DB::select('
                SELECT enrollments.id as enrollment_id,
                "N" as answered,
                users.id as student_id,
                users.email as student_email,
                users.name as student,
                users.cel as student_cel,
                courses.id as course_id,
                courses.title as course,
                workshops.id as workshop_id,
                workshops.description as workshop,
                workshop_activities.id as activity_id,
                workshop_activities.description as activity,
                workshop_activities.evaluation_deadline_date, NULL, NULL, NULL
                FROM workshop_activities
                INNER JOIN workshops ON workshops.id = workshop_activities.workshop_id
                INNER JOIN courses ON courses.id = workshops.course_id
                INNER JOIN enrollments ON enrollments.course_id = courses.id
                INNER JOIN users ON users.id = enrollments.student_id
                WHERE(
                    workshop_activities.id NOT IN (
                        SELECT my_workshop_activities.activity_id FROM my_workshop_activities
                        WHERE my_workshop_activities.enrollment_id = enrollments.id
                    )
                    AND workshop_activities.deleted_at IS NULL
                    AND courses.deleted_at IS NULL
                    AND workshops.deleted_at IS NULL
                    AND enrollments.deleted_at IS NULL
                    AND workshop_activities.evaluation_deadline_date > NOW()
                )

                ORDER BY course, workshop, activity, answered, student

        ');
        $day = date('d')+01;
        dd($activities, date('Y-m-'.$day.' H:i:s'), $day);*/
        if (!is_null($workshopactivity))
            return $workshopactivity;

        throw new GeneralException('That workshopactivity does not exist.');
    }

    /**
     * @param $per_page
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getWorkshopActivitysPaginated($per_page, $order_by = 'id', $sort = 'asc', $f_workshop_edit = '') {
        return WorkshopActivity::where('workshop_id', '=', $f_workshop_edit)->orderBy($order_by, $sort)->paginate($per_page);
    }

    /**
     * @param $per_page
     * @return \Illuminate\Pagination\Paginator
     */
    public function getDeletedWorkshopActivitysPaginated($per_page) {
        return WorkshopActivity::onlyTrashed()->paginate($per_page);
    }

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAllWorkshopActivitys($order_by = 'id', $sort = 'asc') {
        return WorkshopActivity::orderBy($order_by, $sort)->get();
    }

    /**
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function create($input, $workshop_id) {
        $workshopactivity = $this->createWorkshopActivityStub($input, $workshop_id);
        if ($workshopactivity->save())
            return $workshopactivity;
        throw new GeneralException('There was a problem creating this workshopactivity. Please try again.');
    }

    /**
     * @param $type_report
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getActivityReport($group_report, $workshop){

        $orderBy = NULL;
        if($group_report == 'S'){
            $orderBy = 'course, workshop, student, answered, activity';
        }else if($group_report == 'A'){
            $orderBy = 'course, workshop, activity, answered, student';
        }
        //dd($workshop);
        $query = DB::select('
            SELECT 
                enrollments.id AS enrollment_id, 
                "C" as answered,
                users.id as student_id,
                users.email as student_email,
                users.name as student,
                users.cel as student_cel, 
                courses.id as course_id,
                courses.title as course,
                workshops.id as workshop_id, 
                workshops.description as workshop,
                workshop_activities.id as activity_id, 
                workshop_activities.description as activity, 
                workshop_criterias.description as criteria, 
                my_workshop_activities.date_submit, 
                my_workshop_evaluations.date_evaluation, 
                my_workshop_evaluations.grade
                FROM my_workshop_evaluations
                INNER JOIN workshop_criterias ON workshop_criterias.id = my_workshop_evaluations.criteria_id
                INNER JOIN my_workshop_activities ON my_workshop_activities.id = my_workshop_evaluations.my_activity_id
                INNER JOIN workshop_activities ON workshop_activities.id = my_workshop_activities.activity_id
                INNER JOIN workshops ON workshops.id = my_workshop_activities.workshop_id
                INNER JOIN courses ON courses.id = workshops.course_id
                INNER JOIN enrollments ON enrollments.id = my_workshop_activities.enrollment_id
                INNER JOIN users ON users.id = enrollments.student_id
                WHERE(
                    my_workshop_evaluations.grade IS NOT NULL
                    AND workshop_activities.deleted_at IS NULL
                    AND courses.deleted_at IS NULL
                    AND workshops.deleted_at IS NULL
                    AND enrollments.deleted_at IS NULL
                    AND workshop_activities.personal_evaluation = 1
                )
            UNION(
                SELECT 
                    enrollments.id as enrollment_id, 
                    "A" as answered, 
                    users.id as student_id,
                    users.email as student_email, 
                    users.name as student,
                    users.cel as student_cel,  
                    courses.id as course_id, 
                    courses.title as course, 
                    workshops.id as workshop_id,
                    workshops.description as workshop, 
                    workshop_activities.id as activity_id, 
                    workshop_activities.description as activity, 
                    workshop_criterias.description as criteria, 
                    my_workshop_activities.date_submit, 
                    NULL, 
                    NULL 
                FROM my_workshop_evaluations
                INNER JOIN workshop_criterias ON workshop_criterias.id = my_workshop_evaluations.criteria_id
                INNER JOIN my_workshop_activities ON my_workshop_activities.id = my_workshop_evaluations.my_activity_id
                INNER JOIN workshops ON workshops.id = my_workshop_activities.workshop_id
                INNER JOIN workshop_activities ON workshop_activities.id = my_workshop_activities.activity_id
                INNER JOIN enrollments ON enrollments.id = my_workshop_activities.enrollment_id
                INNER JOIN courses ON courses.id = enrollments.course_id
                INNER JOIN users ON users.id = enrollments.student_id
                WHERE(
                    my_workshop_evaluations.grade IS NULL
                    AND workshop_activities.deleted_at IS NULL
                    AND courses.deleted_at IS NULL
                    AND workshops.deleted_at IS NULL
                    AND enrollments.deleted_at IS NULL
                    AND workshop_activities.personal_evaluation = 1
                )
            )
            UNION(
                SELECT enrollments.id as enrollment_id, 
                "N" as answered, 
                users.id as student_id,
                users.email as student_email, 
                users.name as student, 
                users.cel as student_cel, 
                courses.id as course_id, 
                courses.title as course, 
                workshops.id as workshop_id, 
                workshops.description as workshop, 
                workshop_activities.id as activity_id, 
                workshop_activities.description as activity, 
                NULL, NULL, NULL, NULL 
                FROM workshop_activities 
                INNER JOIN workshops ON workshops.id = workshop_activities.workshop_id 
                INNER JOIN courses ON courses.id = workshops.course_id 
                INNER JOIN enrollments ON enrollments.course_id = courses.id 
                INNER JOIN users ON users.id = enrollments.student_id 
                WHERE(
                    workshop_activities.id NOT IN ( 
                        SELECT my_workshop_activities.activity_id FROM my_workshop_activities 
                        WHERE my_workshop_activities.enrollment_id = enrollments.id 
                    )
                    AND workshop_activities.deleted_at IS NULL
                    AND courses.deleted_at IS NULL
                    AND workshops.deleted_at IS NULL
                    AND enrollments.deleted_at IS NULL
                    AND workshop_activities.personal_evaluation = 1
                    
                )
                ORDER BY "'.$orderBy.'"
            )
        ');
            
        //dd($query);

        if($group_report == 'S'){
            
            $i = 0;
            $y = 0;
            $z = 0;

            $students = Enrollment::select(
                'workshops.id as workshop_id',
                'workshops.description as workshop_description',
                'courses.id as course_id',
                'courses.title as oourse_title',
                'users.name as users_name',
                'users.id as users_id',
                'users.cel AS users_cel',
                'users.email AS users_email',
                'enrollments.id AS enrollments_id'
            )
            ->join('users', 'users.id', '=', 'enrollments.student_id')
            ->join('courses', 'courses.id', '=', 'enrollments.course_id')
            ->join('workshops', 'workshops.course_id', '=', 'courses.id')
            ->whereRaw('1=(SELECT count(*) from assigned_roles WHERE user_id = users.id)');
            if(!empty($workshop)){
                //dd($workshop);
                $students->where('workshops.id', '=', $workshop);
            }
            $studentsl = $students->orderBy('users.id')
            ->orderBy('courses.title')
            ->orderBy('workshops.description')->get();
                //dd($activities);
            //dd($students);
            foreach($studentsl as $value){
                

                $value->answered = new Collection([]);
                $value->not_answered = new Collection([]);
                $value->corrected = new Collection([]);
                foreach($query as $val){
                    if($value->users_id == $val->student_id && $value->enrollments_id == $val->enrollment_id
                        && $value->workshop_id == $val->workshop_id && $value->course_id == $val->course_id){
                        if($val->answered == "C"){
                            $value->corrected->put($i, $val);
                            $i++;
                        }else if($val->answered == "A"){
                            $value->answered->put($y, $val);
                            $y++;
                        }else if($val->answered == "N"){
                            $value->not_answered->put($z, $val);
                            $z++;
                        }
                    }
                }
                $y = 0;
                $i = 0;
                $z = 0;
            }
            //dd($students);
            return $studentsl;

        }else if($group_report == 'A'){
           
            $i = 0;
            $y = 0;
            $z = 0;

            $activities = WorkshopActivity::select(
                'workshop_activities.id',
                'workshop_activities.description',
                'workshops.id as workshop_id',
                'workshops.description as workshop_description',
                'courses.id as course_id',
                'courses.title as oourse_title'
            )
                ->join('workshops', 'workshops.id', '=', 'workshop_activities.workshop_id')
                ->join('courses', 'courses.id', '=', 'workshops.course_id')
                ->where('workshop_activities.personal_evaluation', '=', 1);
            if(!empty($workshop)){
                //dd($workshop);
                $activities->where('workshops.id', '=', $workshop);
            }
            $activitiesl = $activities->orderBy('courses.title')->orderBy('workshops.description')->orderBy('id')->get();
            
            //dd($activities);
            foreach($activitiesl as $activity){
                $activity->answered = new Collection([]);
                $activity->not_answered = new Collection([]);
                $activity->corrected = new Collection([]);
                foreach($query as $val){
                    
                    if($activity->id == $val->activity_id && $activity->workshop_id == $val->workshop_id && $activity->course_id == $val->course_id){
                        
                        if($val->answered == "C"){
                            $activity->corrected->put($i, $val);
                            $i++;
                        }else if($val->answered == "A"){
                            $activity->answered->put($y, $val);
                            $y++;
                        }else if($val->answered == "N"){
                            //dd($val);
                            $activity->not_answered->put($z, $val);
                            $z++;
                        }
                    }
                }
                $y = 0;
                $i = 0;
                $z = 0;
            }
            return $activitiesl;
        }
        
        return false;
        
    }

    /**
     * @param $id
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function update($id, $input) {
        $workshopactivity = $this->findOrThrowException($id);


        $workshopactivity->text = $input['text'];
        $workshopactivity->description = $input['description'];
        $workshopactivity->text_response = $input['text_response'];
        $workshopactivity->personal_evaluation = isset($input['personal_evaluation']) ? 1 : 0;
        $workshopactivity->estimated_duration = $input['estimated_duration'];
        $workshopactivity->explanation_url = $input['explanation_url'];

        if (isset($input['minimum_grade']))
            $workshopactivity->minimum_grade = parsemoneybr($input['minimum_grade']);

        if ((isset($input['available_days_after_workshop'])) && ($input['available_days_after_workshop'] != ''))
            $workshopactivity->available_days_after_workshop = $input['available_days_after_workshop'];
        else
            $workshopactivity->available_days_after_workshop = null;

        if ((isset($input['available_date'])) && ($input['available_date'] != ''))
            $workshopactivity->available_date = parsebr($input['available_date']);
        else
            $workshopactivity->available_date = null;

        if ((isset($input['submit_deadline_days'])) && ($input['submit_deadline_days'] != ''))
            $workshopactivity->submit_deadline_days = $input['submit_deadline_days'];
        else
            $workshopactivity->submit_deadline_days = null;

        if ((isset($input['submit_deadline_date'])) && ($input['submit_deadline_date'] != ''))
            $workshopactivity->submit_deadline_date = parsebr($input['submit_deadline_date']);
        else
            $workshopactivity->submit_deadline_date = null;

        if ((isset($input['evaluation_deadline_days'])) && ($input['evaluation_deadline_days'] != ''))
            $workshopactivity->evaluation_deadline_days = $input['evaluation_deadline_days'];
        else
            $workshopactivity->evaluation_deadline_days = null;

        if ((isset($input['evaluation_deadline_date'])) && ($input['evaluation_deadline_date'] != ''))
            $workshopactivity->evaluation_deadline_date = parsebr($input['evaluation_deadline_date']);
        else
            $workshopactivity->evaluation_deadline_date = null;

        if (isset($input['lessons']))
            $workshopactivity->lessons()->sync($input['lessons']);

        $workshopactivity->save();

        return $workshopactivity;


        throw new GeneralException('There was a problem updating this workshopactivity. Please try again.');
    }

    /**
     * @param $id
     * @return bool
     * @throws GeneralException
     */
    public function destroy($id) {
        $workshopactivity = $this->findOrThrowException($id);
        if ($workshopactivity->delete())
            return true;

        throw new GeneralException("There was a problem deleting this workshopactivity. Please try again.");
    }

    /**
     * @param $input
     * @return mixed
     */
    private function createWorkshopActivityStub($input, $workshop_id) {

        $workshopactivity = new WorkshopActivity;
        $workshopactivity->workshop_id = $workshop_id;
        $workshopactivity->description = $input['description'];
        $workshopactivity->text_response = $input['text_response'];
        $workshopactivity->personal_evaluation = isset($input['personal_evaluation']) ? 1 : 0;
        $workshopactivity->estimated_duration = $input['estimated_duration'];
        $workshopactivity->explanation_url = $input['explanation_url'];

        if (isset($input['minimum_grade']))
            $workshopactivity->minimum_grade = parsemoneybr($input['minimum_grade']);

        if ((isset($input['available_days_after_workshop'])) && ($input['available_days_after_workshop'] != ''))
            $workshopactivity->available_days_after_workshop = $input['available_days_after_workshop'];
        else
            $workshopactivity->available_days_after_workshop = null;

        if ((isset($input['available_date'])) && ($input['available_date'] != ''))
            $workshopactivity->available_date = parsebr($input['available_date']);
        else
            $workshopactivity->available_date = null;

        if ((isset($input['submit_deadline_days'])) && ($input['submit_deadline_days'] != ''))
            $workshopactivity->submit_deadline_days = $input['submit_deadline_days'];
        else
            $workshopactivity->submit_deadline_days = null;

        if ((isset($input['submit_deadline_date'])) && ($input['submit_deadline_date'] != ''))
            $workshopactivity->submit_deadline_date = parsebr($input['submit_deadline_date']);
        else
            $workshopactivity->submit_deadline_date = null;

        if ((isset($input['evaluation_deadline_days'])) && ($input['evaluation_deadline_days'] != ''))
            $workshopactivity->evaluation_deadline_days = $input['evaluation_deadline_days'];
        else
            $workshopactivity->evaluation_deadline_days = null;

        if ((isset($input['evaluation_deadline_date'])) && ($input['evaluation_deadline_date'] != ''))
            $workshopactivity->evaluation_deadline_date = parsebr($input['evaluation_deadline_date']);
        else
            $workshopactivity->evaluation_deadline_date = null;

        return $workshopactivity;
    }

    /**
     * @param $id
     * @param $new_file_name
     * @return bool
     * @throws GeneralException
     */
    public function updateUrlDocument($id, $new_file_name) {
        $package = $this->findOrThrowException($id);
        $package->url_document = $new_file_name;
        if ($package->save())
            return true;

        throw new GeneralException('There was a problem updating this article. Please try again.');
    }

    /**
     * @param $id
     * @param $new_file_name
     * @return bool
     * @throws GeneralException
     */
    public function updateUrlResponse($id, $new_file_name) {
        $package = $this->findOrThrowException($id);
        $package->url_response = $new_file_name;
        if ($package->save())
            return true;

        throw new GeneralException('There was a problem updating this article. Please try again.');
    }

}
