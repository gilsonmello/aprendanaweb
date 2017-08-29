<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Services\AnalysisExamSubject\Traits\AnalysisExamSubjectAttributes;

/**
 * @property  user_admin_id
 */
class AnalysisExamSubject extends Model {

    use AnalysisExamSubjectAttributes, SoftDeletes;

    public $timestamps = true;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'analysis_exam_subjects';

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

    public function analisysExam()
    {
        return $this->belongsTo('App\AnalisysExam');
    }

    public function subject()
    {
        return $this->belongsTo('App\Subject');
    }

}
