<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Services\Analysis\Traits\AnalysisAttributes;

class Analysis extends Model {

    use AnalysisAttributes, SoftDeletes;

    public $timestamps = true;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'analysis';

    public function analysisExamGroup()
    {
        return $this->belongsTo('App\AnalysisExamGroup');
    }

    public function subject()
    {
        return $this->belongsTo('App\Subject');
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
