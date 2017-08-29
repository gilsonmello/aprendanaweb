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

class Coupon extends Model {

    use CouponAttributes, SoftDeletes;

    public $timestamp = true;

    protected $table = 'coupons';

    protected $guarded = ['id'];

    protected $dates = ['deleted_at'];


    public function users() {
        return $this->belongsToMany('App\User','coupon_user');
    }

    public function courses(){
        return $this->belongsToMany('App\Course','coupon_course');
    }

    public function modules(){
        return $this->belongsToMany('App\Module','coupon_module');
    }

    public function createdBy()
    {
        return $this->belongsTo('App\User', 'user_id_created_by');
    }

    public function representative()
    {
        return $this->belongsTo('App\User', 'user_id_representative');
    }

}