<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Services\Enrollment\Traits\EnrollmentAttributes;
use Illuminate\Database\Eloquent\SoftDeletes;

class Enrollment extends Model {

    use EnrollmentAttributes, SoftDeletes;

    public $timestamps = true;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'enrollments';

    public function course()
    {
        return $this->belongsTo('App\Course');
    }

    public function module()
    {
        return $this->belongsTo('App\Module');
    }

    public function lesson()
    {
        return $this->belongsTo('App\Lesson');
    }

    public function exam()
    {
        return $this->belongsTo('App\Exam');
    }

    public function student()
    {
        return $this->belongsTo('App\User');
    }

    public function views(){
        return $this->hasMany('App\View')->orderBy('updated_at');
    }

    public function ratings(){
        return $this->hasMany('App\Rating');
    }

    public function executions(){
        return $this->hasMany('App\Execution');
    }


    public function order()
    {
        return $this->belongsTo('App\Order');
    }

    public function partner()
    {
        return $this->belongsTo('App\Partner');
    }

    public function studentgroup()
    {
        return $this->belongsTo('App\Studentgroup');
    }

    public function myWorkshopTutor()
    {
        return $this->hasMany('App\MyWorkshoTutor');
    }



    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    public function view_logs()
    {
        return $this->hasMany('App\ViewLog');
    }

    public function createdBy()
    {
        return $this->belongsTo('App\User', 'user_id_created_by');
    }
}
