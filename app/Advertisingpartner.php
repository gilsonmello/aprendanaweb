<?php namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Services\Advertisingpartner\Traits\AdvertisingpartnerAttributes;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property  user_admin_id
 */
class Advertisingpartner extends Model {

    use AdvertisingpartnerAttributes, SoftDeletes;

    public $timestamps = true;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'advertising_partners';

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
