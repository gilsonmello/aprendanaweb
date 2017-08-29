<?php namespace App;
/**
 * Created by PhpStorm.
 * User: geofrey19
 * Date: 22/09/15
 * Time: 15:28
 */

use Illuminate\Database\Eloquent\Model;
use App\Services\Coupon\Traits\CouponAttributes;
use Illuminate\Database\Eloquent\SoftDeletes;

class RepresentativeCommission extends Model {

    use RepresentativeCommissionAttributes, SoftDeletes;

    public $timestamp = true;

    protected $table = 'representative_commissions';

    protected $guarded = ['id'];

    protected $dates = ['deleted_at'];


    public function representative()
    {
        return $this->belongsTo('App\User', 'representative_id');
    }

}