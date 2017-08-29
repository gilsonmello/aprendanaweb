<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Services\Configuration\Traits\ConfigurationAttributes;
use Illuminate\Database\Eloquent\SoftDeletes;

class Configuration extends Model {

    use ConfigurationAttributes, SoftDeletes;

    public $timestamps = true;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'configs';

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

    /**
     * Hash the users password
     *
     * @param $value
     */
    public function setSmtpPasswordAttribute($value)
    {
        if (\Hash::needsRehash($value))
            $this->attributes['smtp_password'] = bcrypt($value);
        else
            $this->attributes['smtp_password'] = $value;
    }
}
