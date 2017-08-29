<?php namespace App\Repositories\Backend\Newsletter;

/**
 * Interface UserContract
 * @package App\Repositories\Newsletter
 */
interface NewsletterContract {

    /**
     * @param $id
     * @return mixed
     */
    public function findOrThrowException($id);

    /**
     * @param $per_page
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getNewslettersPaginated($per_page, $f_NewsletterController_name, $campaign_id, $status = 1, $order_by = 'id', $sort = 'asc');

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAllNewsletters($campaign_id = NULL, $order_by = 'name', $sort = 'asc');

    /**
     * @param $input
     * @return mixed
     */
    public function create($input);

    /**
     * @param $id
     * @param $input
     * @return mixed
     */
    public function update($id, $input);

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id);

    public function getDeletedNewslettersPaginated($per_page);

}