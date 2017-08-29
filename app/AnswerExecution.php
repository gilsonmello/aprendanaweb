<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AnswerExecution extends Model {

    //use ContentsAttributes, SoftDeletes;
    use SoftDeletes;

    public $timestamps = true;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'answers_executions';

    public function questionExecution()
    {
        return $this->belongsTo('App\QuestionsExecution');
    }

    public function answer(){
        return $this->belongsTo('App\Answer');
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
