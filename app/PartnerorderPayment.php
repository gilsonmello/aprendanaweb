<?php namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Services\PartnerorderPayment\Traits\PartnerorderPaymentAttributes;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property  user_admin_id
 */
class PartnerorderPayment extends Model {

    use PartnerorderPaymentAttributes, SoftDeletes;

    public $timestamps = true;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'partnerorder_payments';

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

    public function userCreate()
    {
        return $this->belongsTo('App\User', 'user_id_create');
    }

    public function userPaid()
    {
        return $this->belongsTo('App\User', 'user_id_paid');
    }

    public function partnerOrder()
    {
        return $this->belongsTo('App\Partnerorder', 'partnerorder_id');
    }


}
