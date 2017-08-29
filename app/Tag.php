<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Services\Tag\Traits\TagAttributes;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tag extends Model {

    use TagAttributes, SoftDeletes;

    public $timestamps = true;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tags';

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

    public function userModerator()
    {
        return $this->belongsTo('App\User', 'user_moderator_id', 'id');
    }
}
