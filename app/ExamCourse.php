<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Services\ExamCourse\Traits\ExamCourseAttributes;

/**
 * @property  user_admin_id
 */
class ExamCourse extends Model {

    use ExamCourseAttributes, SoftDeletes;

    public $timestamps = true;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'exams_courses';

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

    public function exam()
    {
        return $this->belongsTo('App\Exam');
    }

    public function course()
    {
        return $this->belongsTo('App\Course');
    }

}
