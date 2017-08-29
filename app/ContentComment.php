<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Services\ContentsComments\Traits\ContentsCommentsAttributes;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContentComment extends Model {

    use ContentsCommentsAttributes, SoftDeletes;

    public $timestamps = true;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'content_comments';

    public function contents()
    {
        return $this->belongsTo('App\Content','contents_id');
    }

    public function publisher()
    {
        return $this->belongsTo('App\User','publisher_id');
    }

    public function moderator()
    {
        return $this->belongsTo('App\User','moderator_id');
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
