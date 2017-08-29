<?php namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Services\Article\Traits\ArticleAttributes;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model {

    use ArticleAttributes, SoftDeletes;

    public $timestamps = true;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'articles';

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
        return $query->where('status', 1)->where('activation_date', '<=', Carbon::now());
    }

    public function scopeAllIfOwner($query) {
        if(access()->hasRoles(['Administrador'])) return $query;
        return $query->whereHas('users', function ($subquery){
            $subquery->where('user_id', auth()->id() );
        });
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users() {
        return $this->belongsToMany('App\User', 'article_user', 'article_id', 'user_id');
    }

}
