<?php namespace App\Repositories\Frontend\Newsletter;

/**
 * Interface UserContract
 * @package App\Repositories\Video
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
    //public function getNewslettersPaginated($per_page, $order_by = 'id', $sort = 'asc');

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAllNewsletters($order_by = 'id', $sort = 'asc');

    /**
     * @param string $email
     * @return mixed
     */
    public function getNewsletterByEmail($email);

    /**
     * @param string $name
     * @param string $email
     * @return mixed
     */
    public function subscribeToNewsletter($name, $email);

    /**
     * @param $id
     * @return mixed
     */
    public function unsubscribeNewsletter($id);

}