<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class content extends Model {

    //use ContentsAttributes, SoftDeletes;
    use SoftDeletes;

    public $timestamps = true;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'contents';

    public function comments()
    {
        return $this->hasMany('App\ContentsComments','content_comments_id');
    }

    public function lesson()
    {
        return $this->belongsTo('App\Lesson');
    }


    public function contentNotes(){
        return $this->hasMany('App\ContentNote','content_id');
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
