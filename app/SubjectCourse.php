<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Services\SubjectCourse\Traits\SubjectCourseAttributes;

/**
 * @property  user_admin_id
 */
class SubjectCourse extends Model {

    use SubjectCourseAttributes, SoftDeletes;

    public $timestamps = true;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'subjects_courses';

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

    public function subject()
    {
        return $this->belongsTo('App\Subject');
    }

    public function course()
    {
        return $this->belongsTo('App\Course');
    }

    public function exam()
    {
        return $this->belongsTo('App\Exam');
    }


}
