<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Services\Lesson\Traits\LessonAttributes;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lesson extends Model {

    use LessonAttributes, SoftDeletes;

    public $timestamps = true;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'lessons';


    public function contents()
    {
        return $this->hasMany('App\Content');
    }

    public function module()
    {
        return $this->belongsTo('App\Module');
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

    public function teachers(){
       return $this->belongsToMany('App\User','lesson_teachers','lesson_id','teacher_id')->withPivot('percentage');
    }

    public function exam(){
        return $this->hasOne('App\Exam');
    }

    public function groups(){
        return $this->hasMany('App\Group');
    }

    public function lessons(){
        return $this->$this->belongsToMany('App\WorkshopActivity','workshop_activities_lessons');
    }

    public function getReadableNameAttribute()
    {
        return $this->module->name . " - Aula " . $this->sequence;
    }
}
