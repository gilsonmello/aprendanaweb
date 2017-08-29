<?php namespace App\Repositories\Backend\Preenrollment;

use App\Preenrollment;
use App\Exceptions\GeneralException;

/**
 * Class EloquentPreenrollmentRepository
 * @package App\Repositories\Preenrollment
 */
class EloquentPreenrollmentRepository implements PreenrollmentContract {


//	public function __construct() {
//	}

	/**
	 * @param $id
	 * @return mixed
	 * @throws GeneralException
	 */
	public function findOrThrowException($id) {
		$preenrollment = Preenrollment::withTrashed()->find($id);

		if (! is_null($preenrollment)) return $preenrollment;

		throw new GeneralException('That preenrollment does not exist.');
	}

	/**
	 * @param $per_page
	 * @param string $order_by
	 * @param string $sort
	 * @return mixed
	 */
	public function getPreenrollmentsPaginated($per_page = NULL, $partner_id, $f_PreenrollmentController_studentname = '', $f_PreenrollmentController_status = '', $order_by = 'preenrollments.id', $sort = 'asc') {

        $query = Preenrollment::whereNotNull('preenrollments.id');
        $query->select('preenrollments.*');

        $query->join('users', 'users.id', '=', 'preenrollments.student_id')
        ->whereNull('users.deleted_at');

        if (isset($partner_id) && $partner_id != "" && $partner_id != "0"){
            $query->where('partner_id', '=', $partner_id);
        }
        if ($f_PreenrollmentController_status == '1'){
            $query->whereNotNull('date_activation');
        } else if ($f_PreenrollmentController_status == '0'){
            $query->whereNull('date_activation');
        }

        if (isset($f_PreenrollmentController_studentname) && $f_PreenrollmentController_studentname != ""){
            $query->where('users.name', 'like', '%' . $f_PreenrollmentController_studentname . '%');
        }

        if(!is_null($per_page) ){
            return $query->orderBy($order_by, $sort)->paginate($per_page);
        }

        return $query->orderBy($order_by, $sort)->get();
	}

	/**
	 * @param $per_page
	 * @return \Illuminate\Pagination\Paginator
	 */
	public function getDeletedPreenrollmentsPaginated($per_page) {
		return Preenrollment::onlyTrashed()->paginate($per_page);
	}

	/**
	 * @param string $order_by
	 * @param string $sort
	 * @return mixed
	 */
	public function getAllPreenrollments($partner_id, $f_PreenrollmentController_studentname = '', $f_PreenrollmentController_status = '', $order_by = 'id', $sort = 'asc') {
        $query = Preenrollment::whereNotNull('preenrollments.id');
        $query->select('preenrollments.*');

        if (isset($partner_id) && $partner_id != "" && $partner_id != "0"){
            $query->where('partner_id', '=', $partner_id);
        }
        if ($f_PreenrollmentController_status == '1'){
            $query->whereNotNull('date_activation');
        } else if ($f_PreenrollmentController_status == '0'){
            $query->whereNull('date_activation');
        }

        if (isset($f_PreenrollmentController_studentname) && $f_PreenrollmentController_studentname != ""){
            $query->join('users', 'users.id', '=', 'preenrollments.student_id');
            $query->where('users.name', 'like', '%' . $f_PreenrollmentController_studentname . '%');
        }

        return $query->orderBy($order_by, $sort)->get();
	}

    /**
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function create($input) {
        $preenrollment = $this->createPreenrollmentStub($input);
        $preenrollment->course()->associate($input['course_id']);        unset($input['course_id']);
        $preenrollment->partner()->associate($input['partner_id']);        unset($input['partner_id']);
        if($preenrollment->save())
            return $preenrollment;
        throw new GeneralException('There was a problem creating this preenrollment. Please try again.');
    }

    /**
     * @param $id
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function update($id, $input) {
        $preenrollment = $this->findOrThrowException($id);

        $preenrollment->external_course_id = $input['external_course_id'];
        $preenrollment->html_email = $input['html_email'];
        $preenrollment->html_subscribe = $input['html_subscribe'];
        $preenrollment->save();

        return $preenrollment;

        throw new GeneralException('There was a problem updating this preenrollment. Please try again.');
    }

    /**
     * @param $id
     * @return bool
     * @throws GeneralException
     */
    public function destroy($id) {
        $preenrollment = $this->findOrThrowException($id);
        if ($preenrollment->delete())
            return true;

        throw new GeneralException("There was a problem deleting this preenrollment. Please try again.");
    }

    /**
     * @param $input
     * @return mixed
     */
    private function createPreenrollmentStub($input)
    {

        $preenrollment = new Preenrollment;
        $preenrollment->date = parsebr($input['date']);
        $preenrollment->total_enrollments = $input['total_enrollments'];
        $preenrollment->used_enrollments = 0;
        $preenrollment->external_course_id = $input['external_course_id'];
        $preenrollment->html_email = $input['html_email'];
        $preenrollment->html_subscribe = $input['html_subscribe'];
        return $preenrollment;
    }

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getPendingPreenrollmentsPerStudentgroup($studentgroup_id, $order_by = 'id', $sort = 'asc'){
        return Preenrollment::where('studentgroup_id', '=', $studentgroup_id )->whereNull('date_activation')->orderBy($order_by, $sort)->get();
    }
}