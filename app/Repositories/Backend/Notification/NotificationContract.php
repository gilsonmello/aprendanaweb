<?php namespace App\Repositories\Backend\Notification;

/**
 * Interface UserContract
 * @package App\Repositories\FaqCategory
 */
interface NotificationContract {

    /**
     * @param $id
     * @return mixed
     */
    public function save_notification($message,$url,$icon);

    public function broadcast($id,$users);

    public function read_notification($id);

    public function save_and_broadcast($users, $message, $url,$icon = '');

    public function remove_by_time($days, $is_read);
}