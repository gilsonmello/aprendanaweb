<?php namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Services\WorkshopGroupTutor\Traits\WorkshopGroupTutorAttributes;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property  user_admin_id
 */
class WorkshopGroupTutor extends Model {

    use WorkshopGroupTutorAttributes, SoftDeletes;

    public $timestamps = true;

    protected $table = 'workshop_group_tutors';

    protected $guarded = ['id'];

    protected $dates = ['deleted_at'];

    public function group()
    {
        return $this->belongsTo('App\WorkshopEvaluationGroup');
    }

    public function activity()
    {
        return $this->hasOne('App\WorkshopActivity');
    }

    public function tutor()
    {
        return $this->belongsTo('App\User');
    }

}
