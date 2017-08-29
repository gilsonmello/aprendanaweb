<?php namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
//use App\Services\WorkshopCoordinator\Traits\WorkshopTutorAttributes;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property  user_admin_id
 */
class WorkshopCoordinator extends Model {

    use WorkshopTutorAttributes, SoftDeletes;

    public $timestamps = true;

    protected $table = 'workshop_coordinators';

    protected $guarded = ['id'];

    protected $dates = ['deleted_at'];

    /*public function workshop()
    {
        return $this->belongsTo('App\Workshop');
    }

    public function criteria()
    {
        return $this->belongsTo('App\WorkshopCriteria');
    }

    public function tutor()
    {
        return $this->belongsTo('App\User');
    }*/

}
