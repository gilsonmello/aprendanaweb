<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Services\Sector\Traits\SectorAttributes;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sector extends Model {

    use SectorAttributes, SoftDeletes;

    public $timestamps = true;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'sectors';

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
        return $this->belongsToMany('App\User', 'sector_user', 'sector_id', 'user_id');
    }

}
