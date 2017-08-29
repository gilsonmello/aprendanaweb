<?php namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Services\WorkshopCriteria\Traits\WorkshopCriteriaAttributes;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property  user_admin_id
 */
class WorkshopCriteria extends Model {

    use WorkshopCriteriaAttributes, SoftDeletes;

    public $timestamps = true;

    protected $table = 'workshop_criterias';

    protected $guarded = ['id'];

    protected $dates = ['deleted_at'];

    public function workshop()
    {
        return $this->belongsTo('App\Workshop');
    }

}
