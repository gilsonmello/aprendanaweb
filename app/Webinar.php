<?php namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Services\Webinar\Traits\WebinarAttributes;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property  user_admin_id
 */
class Webinar extends Model {

    use WebinarAttributes, SoftDeletes;

    public $timestamps = true;

    protected $table = 'webinars';

    protected $guarded = ['id'];

    protected $dates = ['deleted_at'];

    public function course()
    {
        return $this->belongsTo('App\Course', 'courses_id');
    }
}
