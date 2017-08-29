<?php namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Services\Course\Traits\CourseAttributes;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property  user_admin_id
 */
class Rating extends Model {

    public $timestamps = false;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'ratings';

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

    function student(){
        return $this->belongsTo('App\User','student_id');
    }

    function criterion(){
        return $this->belongsTo('App\Criterion');
    }

    function course(){
        return $this->belongsTo('App\Course');
    }

    function enrollment(){
        return $this->belongsTo('App\Enrollment');
    }


}
