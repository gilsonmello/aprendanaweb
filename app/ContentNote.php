<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Services\ContentsComments\Traits\ContentsCommentsAttributes;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContentNote extends Model {

    use SoftDeletes;

    public $timestamps = true;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'content_notes';

    public function content()
    {
        return $this->belongsTo('App\Content','content_id');
    }

    public function student()
    {
        return $this->belongsTo('App\User','student_id');
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
