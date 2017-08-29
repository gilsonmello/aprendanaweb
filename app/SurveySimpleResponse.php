<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Services\Subsection\Traits\SubsectionAttributes;
use Illuminate\Database\Eloquent\SoftDeletes;

class SurveySimpleResponse extends Model {

    use SoftDeletes;

    public $timestamps = true;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'survey_simple_responses';

    public function survey()
    {
        return $this->belongsTo('App\Survey');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
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
