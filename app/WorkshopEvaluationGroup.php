<?php namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Services\WorkshopEvaluationGroup\Traits\WorkshopEvaluationGroupAttributes;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property  user_admin_id
 */
class WorkshopEvaluationGroup extends Model {

    use WorkshopEvaluationGroupAttributes, SoftDeletes;

    public $timestamps = true;

    protected $table = 'workshop_evaluation_groups';

    protected $guarded = ['id'];

    protected $dates = ['deleted_at'];

    public function workshop()
    {
        return $this->hasMany('App\Workshop');
    }

}
