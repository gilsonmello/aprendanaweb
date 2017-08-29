<?php namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Services\Partner\Traits\PartnerAttributes;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property  user_admin_id
 */
class Partner extends Model {

    use PartnerAttributes, SoftDeletes;

    public $timestamps = true;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'partners';

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