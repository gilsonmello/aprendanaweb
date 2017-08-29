<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Services\Order\Traits\OrderAttributes;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model {

    use OrderAttributes, SoftDeletes;

    public $timestamps = true;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'orders';

    public function coupon()
    {
        return $this->belongsTo('App\Coupon');
    }

    public function student()
    {
        return $this->belongsTo('App\User', 'student_id');
    }

    public function status()
    {
        return $this->belongsTo('App\OrderStatus');
    }

    public function courses()
    {
        return $this->hasMany('App\OrderCourse');
    }

    public function packages()
    {
        return $this->hasMany('App\OrderPackage');
    }

    public function modules()
    {
        return $this->hasMany('App\OrderModule');
    }

    public function lessons()
    {
        return $this->hasMany('App\OrderModule');
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
