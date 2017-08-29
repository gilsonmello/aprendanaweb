<?php namespace App\Repositories\Frontend\WorkshopActivity;

use App\MyWorkshopActivityTime;
use App\Exceptions\GeneralException;


/**
 * Class EloquentEnrollmentRepository
 * @package App\Repositories\Enrollment
 */
class EloquentMyWorkshopActivityTimeRepository implements MyWorkshopActivityTimeContract {

    public function findOrThrowException($id){
        $mwat = MyWorkshopActivityTime::withTrashed()->find($id);

        if (! is_null($mwat)) return $mwat;

        throw new GeneralException('That object does not exist.');
    }


    public function findByActivityAndEnrollment($activity_id,$enrollment_id){
        return MyWorkshopActivityTime::where('activity_id',$activity_id)->where('enrollment_id',$enrollment_id);
    }


    public function createOrUpdate($activity_id,$enrollment_id,$time_spent,$time_left){
        $mwat = $this->findByActivityAndEnrollment($activity_id,$enrollment_id)->get();

        if($mwat == null || $mwat->isEmpty()){
            $mwat = new MyWorkshopActivityTime();
            $mwat->activity()->associate($activity_id);
            $mwat->enrollment()->associate($enrollment_id);

        }else{
            $mwat = $mwat->first();
        }

        $mwat->time_spent = $time_spent;
        $mwat->time_left = $time_left;
        $mwat->save();

        return $mwat;

    }

}