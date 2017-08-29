<?php namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

use App\Services\MyWorkshopTutor\Traits\MyWorkshopTutorAttributes;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property  user_admin_id
 */
class MyWorkshopTutor extends Model {

//    use MyWorkshopTutorAttributes, SoftDeletes;
    use SoftDeletes, MyWorkshopTutorAttributes;

    public $timestamps = true;

    protected $table = 'my_workshop_tutors';

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
    
    public function criteria()
    {
        return $this->belongsTo('App\WorkshopCriteria');
    }

    public function tutor()
    {
        return $this->belongsTo('App\User');
    }

    public function enrollment()
    {
        return $this->belongsTo('App\Enrollment');
    }

}
