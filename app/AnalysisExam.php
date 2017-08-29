<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Services\AnalysisExam\Traits\AnalysisExamAttributes;

class AnalysisExam extends Model {

    use AnalysisExamAttributes, SoftDeletes;

    public $timestamps = true;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'analysis_exams';

    public function source()
    {
        return $this->belongsTo('App\Source');
    }

    public function institution()
    {
        return $this->belongsTo('App\Institution');
    }

    public function office()
    {
        return $this->belongsTo('App\Office');
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
