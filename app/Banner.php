<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Services\Banner\Traits\BannerAttributes;
use Illuminate\Database\Eloquent\SoftDeletes;

class Banner extends Model {

    use BannerAttributes, SoftDeletes;

    public $timestamps = true;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'banners';

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


    public function course()
    {
        return $this->belongsTo('App\Course');
    }

    public function package()
    {
        return $this->belongsTo('App\Package');
    }
}
