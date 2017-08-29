<?php namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Services\MyWorkshopEvaluation\Traits\MyWorkshopEvaluationAttributes;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property  user_admin_id
 */
class MyWorkshopEvaluation extends Model {

    use MyWorkshopEvaluationAttributes, SoftDeletes;

    public $timestamps = true;

    protected $table = 'my_workshop_evaluations';

    protected $guarded = ['id'];

    protected $dates = ['deleted_at'];

    public function myActivity()
    {
        return $this->belongsTo('App\MyWorkshopActivity');
    }

    public function tutor()
    {
        return $this->belongsTo('App\User');
    }

    public function criteria()
    {
        return $this->belongsTo('App\WorkshopCriteria');
    }

}
