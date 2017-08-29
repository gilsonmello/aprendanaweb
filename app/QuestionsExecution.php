<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuestionsExecution extends Model {

    //use ContentsAttributes, SoftDeletes;
    use SoftDeletes;

    public $timestamps = true;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'questions_executions';

    public function execution()
    {
        return $this->belongsTo('App\Execution');
    }

    public function answersExecution()
    {
        return $this->hasOne('App\AnswerExecution','question_execution_id');
    }


    public function question(){
        return $this->belongsTo('App\Question');
    }


    public function group()
    {
        return $this->belongsTo('App\Group');
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
