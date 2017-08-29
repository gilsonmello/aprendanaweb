<?php namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Services\Course\Traits\CourseAttributes;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property  user_admin_id
 */
class MyWorkshopActivity extends Model {

//    use MyWorkshopActivityAttributes, SoftDeletes;
    use SoftDeletes;

    public $timestamps = true;

    protected $table = 'my_workshop_activities';

    protected $guarded = ['id'];

    protected $dates = ['deleted_at'];

    public function workshop()
    {
        return $this->belongsTo('App\Workshop');
    }

    public function activity()
    {
        return $this->belongsTo('App\WorkshopActivity');
    }

    public function enrollment()
    {
        return $this->belongsTo('App\Enrollment');
    }

    public function evaluation(){
        return $this->hasMany('App\MyWorkshopEvaluation','my_activity_id');
    }

}
