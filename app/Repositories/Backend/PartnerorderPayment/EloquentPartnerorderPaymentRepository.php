<?php namespace App\Repositories\Backend\PartnerorderPayment;

use App\PartnerorderPayment;
use App\Exceptions\GeneralException;


/**
 * Class EloquentPartnerorderPaymentRepository
 * @package App\Repositories\PartnerorderPayment
 */
class EloquentPartnerorderPaymentRepository implements PartnerorderPaymentContract {


    /**
     * @param $id
     * @return mixed
     * @throws GeneralException
     */
    public function findOrThrowException($id) {
        $partnerorderPayment = PartnerorderPayment::withTrashed()->find($id);

        if (! is_null($partnerorderPayment)) return $partnerorderPayment;

        throw new GeneralException('That partnerorderPayment does not exist.');
    }

    /**
     * @param $per_page
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */

    public function getPartnerorderPaymentsPaginated($per_page, $order_by = 'id', $sort = 'asc', $f_partnerorder_edit = 0) {
        return PartnerorderPayment::where('partnerorder_id', '=', $f_partnerorder_edit)->orderBy($order_by, $sort)->paginate($per_page);
    }

    /**
     * @param $per_page
     * @return \Illuminate\Pagination\Paginator
     */
    public function getDeletedPartnerorderPaymentsPaginated($per_page) {
        return PartnerorderPayment::onlyTrashed()->paginate($per_page);
    }

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAllPartnerorderPayments($order_by = 'id', $sort = 'asc', $f_partnerorder_edit = 0) {
        return PartnerorderPayment::where('partnerorder_id', '=', $f_partnerorder_edit)->orderBy($order_by, $sort)->get();
    }

    /**
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function create($input, $f_partnerorder_edit) {
        $partnerorderPayment = $this->createPartnerorderPaymentStub($input);
        $partnerorderPayment->partnerorder_id = $f_partnerorder_edit;
        $partnerorderPayment->user_id_create = auth()->user()->id;

        if ($partnerorderPayment->paid_date != null){
            $partnerorderPayment->user_id_paid = auth()->user()->id;
        }

        if($partnerorderPayment->save())
            return $partnerorderPayment;
        throw new GeneralException('There was a problem creating this partnerorderPayment. Please try again.');
    }

    /**
     * @param $id
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function update($id, $input) {
        $partnerorderPayment = $this->findOrThrowException($id);

        if ($partnerorderPayment->processed == 1){
            return false;
        }

        $paid = $partnerorderPayment->paid_date;

        if ($partnerorderPayment->update($input)) {
            $partnerorderPayment->due_date = parsebr($input['due_date']);
            $partnerorderPayment->value = parsemoneybr($input['value']);
            if (($input['paid_date'] != null) && ($input['paid_date'] !== ''))
                $partnerorderPayment->paid_date = parsebr($input['paid_date']);
            else
                $partnerorderPayment->paid_date = null;
            $partnerorderPayment->paid_value = parsemoneybr($input['paid_value']);

            if (($paid != null) && ($partnerorderPayment->paid_date != null)){
                $partnerorderPayment->user_id_paid = auth()->user()->id;
            }

            $partnerorderPayment->save();
            return $partnerorderPayment;
        }

        throw new GeneralException('There was a problem updating this partnerorderPayment. Please try again.');
    }

    /**
     * @param $id
     * @return bool
     * @throws GeneralException
     */
    public function destroy($id) {
        $partnerorderPayment = $this->findOrThrowException($id);

        if ($partnerorderPayment->processed == 1){
            return false;
        }

        if ($partnerorderPayment->delete())
            return true;

        throw new GeneralException("There was a problem deleting this partnerorderPayment. Please try again.");
    }

    /**
     * @param $input
     * @return mixed
     */
    private function createPartnerorderPaymentStub($input)
    {

        $partnerorderPayment = new PartnerorderPayment;
        $partnerorderPayment->due_date = parsebr($input['due_date']);
        $partnerorderPayment->value = parsemoneybr($input['value']);
        if (($input['paid_date'] != null) && ($input['paid_date'] !== ''))
            $partnerorderPayment->paid_date = parsebr($input['paid_date']);
        else
            $partnerorderPayment->paid_date = null;
        $partnerorderPayment->paid_value = parsemoneybr($input['paid_value']);

        return $partnerorderPayment;
    }

    public function getPartnerOrdersForPayment($datebegin, $dateend = null) {
        if ($dateend == null)
            $dateend = $datebegin;

        $query = PartnerorderPayment::where('paid_date', '>=', parsebr($datebegin));
        $query->where('paid_date', '<', parsebr($dateend)->addDay());
        return $query->orderBy('id', 'asc')->get();
    }

}