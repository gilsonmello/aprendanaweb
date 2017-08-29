<?php

namespace App\Repositories\Backend\Newsletter;

use App\Newsletter;
use App\Exceptions\GeneralException;

/**
 * Class EloquentNewsletterRepository
 * @package App\Repositories\Newsletter
 */
class EloquentNewsletterRepository implements NewsletterContract {
//	public function __construct() {
//	}

    /**
     * @param $id
     * @return mixed
     * @throws GeneralException
     */
    public function findOrThrowException($id) {
        $newsletter = Newsletter::withTrashed()->find($id);

        if (!is_null($newsletter))
            return $newsletter;

        throw new GeneralException('That newsletters does not exist.');
    }

    /**
     * @param $per_page
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getNewslettersPaginated($per_page, $f_NewsletterController_name, $campaign_id, $status = 1, $order_by = 'id', $sort = 'asc') {

        $newsletter = Newsletter::where(function ($query) use ($f_NewsletterController_name) {
                    $query->where('name', 'like', '%' . $f_NewsletterController_name . '%')
                            ->orWhere('email', 'like', '%' . $f_NewsletterController_name . '%');
                });
        if (!is_null($campaign_id) && !empty($campaign_id)) {
            $newsletter->where('campaign_id', '=', $campaign_id);
        }
        return $newsletter->orderBy($order_by, $sort)->paginate($per_page);
    }

    /**
     * @param $per_page
     * @return \Illuminate\Pagination\Paginator
     */
    public function getDeletedNewslettersPaginated($per_page) {
        return Newsletter::onlyTrashed()->paginate($per_page);
    }

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAllNewsletters($campaign_id = NULL, $order_by = 'id', $sort = 'asc') {
        $query = Newsletter::query();
        if(isset($campaign_id) && !empty($campaign_id)){
            $query->where('campaign_id', '=', $campaign_id);
        }
        return $query->orderBy($order_by, $sort)->get();
    }

    /**
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function create($input) {
        $newsletter = $this->createNewsletterStub($input);
        if ($newsletter->save())
            return true;
        throw new GeneralException('There was a problem creating this newsletters. Please try again.');
    }

    /**
     * @param $id
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function update($id, $input) {
        $newsletter = $this->findOrThrowException($id);

        if ($newsletter->update($input)) {
            $newsletter->email = $input['email'];
            $newsletter->name = $input['name'];
            $newsletter->save();

            return true;
        }

        throw new GeneralException('There was a problem updating this newsletters. Please try again.');
    }

    /**
     * @param $id
     * @return bool
     * @throws GeneralException
     */
    public function destroy($id) {
        $newsletter = $this->findOrThrowException($id);
        if ($newsletter->delete())
            return true;

        throw new GeneralException("There was a problem deleting this newsletters. Please try again.");
    }

    /**
     * @param $input
     * @return mixed
     */
    private function createNewsletterStub($input) {
        $newsletter = new Newsletter;
        $newsletter->email = $input['email'];
        $newsletter->name = $input['name'];
        return $newsletter;
    }

}
