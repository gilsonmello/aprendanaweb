<?php namespace App\Repositories\Frontend\ViewLog;

/**
 * Interface UserContract
 * @package App\Repositories\View
 */
interface ViewLogContract {

    /**
     * @param $id
     * @return mixed
     */
    public function findOrThrowException($id);

    public function findByEnrollmentAndContent($enrollment_id,$content_id);
    public function createViewLog($enrollment,$content,$max_view);
    public function updateLogViewDate($id);

}