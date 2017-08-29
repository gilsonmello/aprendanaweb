<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Services\CourseAlert\Traits\CourseAlertAttributes;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property  user_admin_id
 */
class CourseAlert extends Model {

    use CourseAlertAttributes, SoftDeletes;

    public $timestamps = true;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'courses_alerts';

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

    public function course()
    {
        return $this->belongsTo('App\Course');
    }

}
