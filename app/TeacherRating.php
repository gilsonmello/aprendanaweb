<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TeacherRating extends Model {

    use  SoftDeletes;

    public $timestamps = true;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'teacher_ratings';

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


    public function execution()
    {
        return $this->belongsTo('App\Execution');
    }

    public function exam()
    {
        return $this->belongsTo('App\Exam');
    }

    public function teacher()
    {
        return $this->belongsTo('App\User','teacher_id');
    }


}
