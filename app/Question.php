<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Services\Question\Traits\QuestionAttributes;

class Question extends Model {

    //use ContentsAttributes, SoftDeletes;
    use QuestionAttributes, SoftDeletes;

    public $timestamps = true;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'questions';

    public function groups()
    {
        //$intermediary = $this->belongsTo('App\GroupQuestion');
        //return $intermediary->getResults()->belongsTo('App\Group');
        return $this->belongsToMany('App\Group')->withPivot('sequence');
    }

    public function answers()
    {
        return $this->hasMany('App\Answer');
    }

    public function subject()
    {
        return $this->belongsTo('App\Subject');
    }

    public function source()
    {
        return $this->belongsTo('App\Source');
    }

    public function institution()
    {
        return $this->belongsTo('App\Institution');
    }

    public function office()
    {
        return $this->belongsTo('App\Office');
    }

    public function teacher()
    {
        return $this->belongsTo('App\User', 'teacher_id');
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

    public function percentageRight(){
        if (($this->count_right + $this->count_wrong + $this->count_partial) === 0  ){
            return 0;
        }
        return $this->count_right / ($this->count_right + $this->count_wrong + $this->count_partial) * 100;
    }

}
