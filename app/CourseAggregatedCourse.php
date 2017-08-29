<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Services\SubjectCourse\Traits\SubjectCourseAttributes;

/**
 * @property  user_admin_id
 */
class CourseAggregatedCourse extends Model {

//    use SubjectCourseAttributes, SoftDeletes;
    use SoftDeletes;

    public $timestamps = true;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'courses_aggregated_courses';

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

    public function course_bought() {
        return $this->belongsTo('App\Course', 'course_id_bought');
    }

    public function course_extra() {
        return $this->belongsTo('App\Course', 'course_id_extra');
    }

}
