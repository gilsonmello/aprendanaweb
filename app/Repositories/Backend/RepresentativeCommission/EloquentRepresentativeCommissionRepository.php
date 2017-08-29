<?php

namespace App\Repositories\Backend\RepresentativeCommission;

use App\RepresentativeCommission;
use App\Exceptions\GeneralException;
use Carbon\Carbon;

/**
 * Class EloquentRepresentativeCommissionRepository
 * @package App\Repositories\RepresentativeCommission
 */
class EloquentRepresentativeCommissionRepository implements RepresentativeCommissionContract {
//	public function __construct() {
//	}

    /**
     * @param $id
     * @return mixed
     * @throws GeneralException
     */
    public function findOrThrowException($id) {
        $representativecommission = RepresentativeCommission::withTrashed()->find($id);

        if (!is_null($representativecommission))
            return $representativecommission;

        throw new GeneralException('That representativecommission does not exist.');
    }

    /**
     * @param $id
     * @return mixed
     * @throws GeneralException
     */
    public function getRepresentativeCommission($id) {
        return RepresentativeCommission::withTrashed()->find($id);
    }

    /**
     * @param $per_page
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getRepresentativeCommissionsPaginated($per_page, $f_RepresentativeCommissionController_name = '', $order_by = 'id', $sort = 'asc', $includePartner = false) {
        $query = RepresentativeCommission::where('name', 'like', '%' . $f_RepresentativeCommissionController_name . '%')
                ->orWhere('code', 'like', '%' . $f_RepresentativeCommissionController_name . '%');
        if ($includePartner === false) {
            $query->whereNull('partner_id');
            $query->whereNull('advertisingpartner_id');
        }
        return $query->orderBy($order_by, $sort)->paginate($per_page);
    }

    /**
     * @param $per_page
     * @return \Illuminate\Pagination\Paginator
     */
    public function getDeletedRepresentativeCommissionsPaginated($per_page) {
        return RepresentativeCommission::onlyTrashed()->paginate($per_page);
    }

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAllRepresentativeCommissions($order_by = 'id', $sort = 'asc') {
        return RepresentativeCommission::orderBy($order_by, $sort)->get();
    }

    /**
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function create($input) {
        $representativecommission = $this->createRepresentativeCommissionStub($input);
        if ($representativecommission->save()) {
            $representativecommission->users()->attach($input['students']);
            $representativecommission->courses()->attach($input['courses']);
            $representativecommission->modules()->attach($input['modules']);
            return true;
        }
        throw new GeneralException('There was a problem creating this representativecommission. Please try again.');
    }

    /**
     * @param $id
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function update($id, $input, $students, $courses, $modules) {
        $representativecommission = $this->findOrThrowException($id);

        if ($representativecommission->update($input)) {
            $representativecommission->period_type = 1;
            $representativecommission->date_begin = parsebr($input['date_begin']);
            $representativecommission->range_begin = $input['range_begin'];
            $representativecommission->range_end = $input['range_end'];
            $representativecommission->commission_percentage = $input['commission_percentage'];
            $representativecommission->save();
            return true;
        }

        throw new GeneralException('There was a problem updating this representativecommission. Please try again.');
    }

    /**
     * @param $id
     * @return bool
     * @throws GeneralException
     */
    public function destroy($id) {
        $representativecommission = $this->findOrThrowException($id);
        if ($representativecommission->delete())
            return true;

        throw new GeneralException("There was a problem deleting this representativecommission. Please try again.");
    }

    /**
     * @param $input
     * @return mixed
     */
    private function createRepresentativeCommissionStub($input) {

        $representativecommission = new RepresentativeCommission;
        $representativecommission->representative_id = $input['representative_id'];
        $representativecommission->period_type = 1;
        $representativecommission->date_begin = parsebr($input['date_begin']);
        $representativecommission->range_begin = $input['range_begin'];
        $representativecommission->range_end = $input['range_end'];
        $representativecommission->commission_percentage = $input['commission_percentage'];
        return $representativecommission;
    }


    public function getRepresentativeCommissionsRepresentative($representative){
        return RepresentativeCommission::where('representative_id', '=', $representative)->orderBy("id", "desc")->get();
    }

    public function createRepresentativeCommissionsRepresentative($userrepresentative){
        $representativecommission = new RepresentativeCommission;
        $timestp = Carbon::now()->timestamp;
        $representativecommission->name = $userrepresentative->name . ' - ' . $timestp;
        $representativecommission->code = $userrepresentative->id . '-' .$timestp;
        $representativecommission->start_date = Carbon::now();
        $representativecommission->due_date = Carbon::now()->addYear(2);
        $representativecommission->limit = 9999;
        $representativecommission->used = 0;
        $representativecommission->percentage = 5;
        $representativecommission->value = 0;
        $representativecommission->user_id_created_by = auth()->user()->id;
        $representativecommission->user_id_representative = $userrepresentative->id;
        $representativecommission->description = $userrepresentative . ' - ' . $timestp;

        $representativecommission->save();

        return $representativecommission;

    }
}
