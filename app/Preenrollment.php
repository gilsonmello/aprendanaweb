<?php namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Services\Preenrollment\Traits\PreenrollmentAttributes;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property  user_admin_id
 */
class Preenrollment extends Model {

    use PreenrollmentAttributes, SoftDeletes;

    public $timestamps = true;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'preenrollments';

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

    public function partner()
    {
        return $this->belongsTo('App\Partner');
    }

    public function course()
    {
        return $this->belongsTo('App\Course');
    }

    public function studentgroup()
    {
        return $this->belongsTo('App\Studentgroup');
    }

    public function partnerorder()
    {
        return $this->belongsTo('App\Partnerorder');
    }

    public function student()
    {
        return $this->belongsTo('App\User', 'student_id');
    }

}
