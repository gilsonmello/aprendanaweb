<?php namespace App;

use App\Services\Group\Traits\GroupAttributes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Group extends Model {

    use GroupAttributes, SoftDeletes;

    public $timestamps = true;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'groups';

    public function exam()
    {
        return $this->belongsTo('App\Exam');
    }

    public function questions_executions()
    {
        return $this->hasMany('App\QuestionExecution');
    }


    public function questions()
    {
        return $this->belongsToMany('App\Question')->withPivot('sequence');
    }

    public function subjects()
    {
        return $this->belongsToMany('App\Subject')->withPivot('questions_count','source_id');
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

    public function lesson()
    {
        return $this->belongsTo('App\Lesson');
    }

    public function course()
    {
        return $this->belongsTo('App\Course');
    }


}
