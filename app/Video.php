<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Services\Video\Traits\VideoAttributes;
use Illuminate\Database\Eloquent\SoftDeletes;

class Video extends Model {

    use VideoAttributes, SoftDeletes;

 //   public $timestamps = false;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'videos';

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

    public function scopeIsActivatedAndPublished($query) {
         return $query->where('status', 1)->where('activation_date', '<=', date('Y-m-d'));
        // return $query->where('status', 1);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users() {
        return $this->belongsToMany('App\User', 'video_user', 'video_id', 'user_id');
    }

}
