<?php namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Services\WorkshopActivity\Traits\WorkshopActivityAttributes;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property  user_admin_id
 */
class WorkshopActivity extends Model {

    use WorkshopActivityAttributes, SoftDeletes;

    public $timestamps = true;

    protected $table = 'workshop_activities';

    protected $guarded = ['id'];

    protected $dates = ['deleted_at'];

    public function workshop()
    {
        return $this->belongsTo('App\Workshop');
    }

    public function myWorkshopTutor()
    {
        return $this->hasMany('App\MyWorkshopTutor');
    }

    public function myActivities(){
        return $this->hasMany('App\MyWorkshopActivity','activity_id');
    }

    public function lessons(){
        return $this->belongsToMany('App\Lesson','workshop_activities_lessons');
    }

    public function workshopGroupTutor(){
        return $this->hasOne('App\WorkshopGroupTutor', 'activity_id');
    }

    public function workshopEvaluationGroup(){
        return $this->belongsTo('App\WorkshopEvaluationGroup');
    }


}
