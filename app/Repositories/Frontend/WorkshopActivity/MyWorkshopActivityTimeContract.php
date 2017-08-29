<?php namespace App\Repositories\Frontend\WorkshopActivity;



/**
 * Interface UserContract
 * @package App\Repositories\Enrollment
 */
interface MyWorkshopActivityTimeContract {

    public function findOrThrowException($id);
    public function findByActivityAndEnrollment($activity_id,$enrollment_id);
    public function createOrUpdate($activity_id,$enrollment_id,$time_spent,$time_left);

}