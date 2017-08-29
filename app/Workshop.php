<?php namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Services\Workshop\Traits\WorkshopAttributes;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property  user_admin_id
 */
class Workshop extends Model {

    use WorkshopAttributes, SoftDeletes;

    public $timestamps = true;

    protected $table = 'workshops';

    protected $guarded = ['id'];

    protected $dates = ['deleted_at'];

    public function asktheteacher()
    {
        return $this->hasMany('App\AskTheTeacher');
    }

    public function course()
    {
        return $this->belongsTo('App\Course');
    }

    public function criterias()
    {
        return $this->hasMany('App\WorkshopCriteria');
    }

    public function activities()
    {
        return $this->hasMany('App\WorkshopActivity');
    }

    public function tutors()
    {
        return $this->hasMany('App\WorkshopTutor');
    }

    public function coordinators(){
        return $this->belongsToMany('App\User', 'workshop_coordinators',  'workshop_id', 'teacher_id');
    }

    public function myWorkshopTutors(){
        return $this->hasMany('App\MyWorkshopTutor');
    }
}
