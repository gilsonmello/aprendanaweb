<?php namespace App;

use App\Services\Exam\Traits\ExamAttributes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Exam extends Model {

    use ExamAttributes, SoftDeletes;

    public $timestamps = true;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'exams';

    public function groups()
    {
        return $this->hasMany('App\Group');
    }

    public function executions()
    {
        return $this->hasMany('App\Enrollment');
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


    public function courses() {
        return $this->belongsToMany('App\Course', 'exams_courses', 'exam_id', 'course_id');
    }

    public function teacherMessage()
    {
        return $this->belongsTo('App\User', 'teacher_message_id');
    }

    public function subsection()
    {
        return $this->belongsTo('App\Subsection', 'subsection_id');
    }

    public function lesson(){
        return $this->belongsToMany('App\Lesson');
    }

    public function course(){
        return $this->belongsToMany('App\Course');
    }




}
