<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Services\Subject\Traits\SubjectAttributes;

class Subject extends Model {

    //use ContentsAttributes, SoftDeletes;
    use SubjectAttributes, SoftDeletes;

    public $timestamps = true;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'subjects';


    public function questions()
    {
        return $this->hasMany('App\Question');
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */

    public function parent()
    {
        return $this->belongsTo('App\Subject','subject_id');
    }

    public function children()
    {
        return $this->hasMany('App\Subject','subject_id');
    }



    public function courses() {
        return $this->belongsToMany('App\Course', 'subjects_courses', 'subject_id', 'course_id')->withPivot('exam_id');
    }


    public function packages() {
        return $this->belongsToMany('App\Package', 'subjects_packages', 'subject_id', 'package_id')->withPivot('exam_id');
    }

    public function groups()
    {

        return $this->belongsToMany('App\Group')->withPivot('questions_count');
    }

    public function getParentAndNameAttribute(){

        return ($this->parent != null ? $this->parent->name . ' - ' : "") . $this->name;
    }


}
