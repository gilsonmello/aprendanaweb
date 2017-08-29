<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Services\GroupQuestion\Traits\GroupQuestionAttributes;

/**
 * @property  user_admin_id
 */
class GroupQuestion extends Model {

    use GroupQuestionAttributes;

    public $timestamps = true;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'group_question';

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

    public function group()
    {
        return $this->belongsTo('App\Group');
    }

    public function question()
    {
        return $this->belongsTo('App\Question');
    }

}
