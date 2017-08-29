<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Services\Module\Traits\ModuleAttributes;
use Illuminate\Database\Eloquent\SoftDeletes;

class Module extends Model {

    use ModuleAttributes, SoftDeletes;

    public $timestamps = true;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'modules';

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

    public function course()
    {
        return $this->belongsTo('App\Course');
    }

    public function lessons()
    {
        return $this->hasMany('App\Lesson');
    }

}
