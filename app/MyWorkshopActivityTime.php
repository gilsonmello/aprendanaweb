<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property  user_admin_id
 */
class MyWorkshopActivityTime extends Model {

    use SoftDeletes;

    public $timestamps = true;

    protected $table = 'my_workshop_activities_time';

    protected $guarded = ['id'];

    protected $dates = ['deleted_at'];

    public function activity()
    {
        return $this->belongsTo('App\WorkshopActivity');
    }

    public function enrollment()
    {
        return $this->belongsTo('App\Enrollment');
    }

}
