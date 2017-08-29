<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Services\PackageTeacher\Traits\PackageTeacherAttributes;

/**
 * @property  user_admin_id
 */
class PackageTeacher extends Model {

    use PackageTeacherAttributes, SoftDeletes;

    public $timestamps = true;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'package_teachers';

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

    public function package()
    {
        return $this->belongsTo('App\Package');
    }

    public function teacher()
    {
        return $this->belongsTo('App\User');
    }

}
