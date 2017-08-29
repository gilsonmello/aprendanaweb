<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Execution extends Model {

    //use ContentsAttributes, SoftDeletes;
    use SoftDeletes;

    public $timestamps = true;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'executions';

    public function questions_executions()
    {
        return $this->hasMany('App\QuestionsExecution');
    }

    public function enrollment()
    {
        return $this->belongsTo('App\Enrollment');
    }

    public function lesson()
    {
        return $this->belongsTo('App\Lesson');
    }


    public function course()
    {
        return $this->belongsTo('App\Course');
    }


    public function last_question_execution(){
        return $this->belongsTo('App\QuestionsExecution');
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

}
