<?php namespace App\Repositories\Frontend\View;

/**
 * Interface UserContract
 * @package App\Repositories\View
 */
interface ViewContract {

    /**
     * @param $id
     * @return mixed
     */
    public function findOrThrowException($id);
    public function saveState($enrollment_id,$content_id,$state,$percent,$count);
    public function findByEnrollmentAndContent($enrollment_id,$content_id);
    public function enrollmentHasView($enrollment_id, $content_id);
    public function createView($enrollment,$content,$max_view);
    public function updatePercentageForNewView($id, $percent,$accumulated_percent);
    public function saveLike($view_id,$up_down,$criteria);
    public function lessonViewed($enrollment_id, $lesson,$active = false);
    public function modulePercentageViewed($enrollment_id, $module);
    public function getTimeInEnrollment($id);
    public function getLastViewLog($enrollment_id,$content_id);

}