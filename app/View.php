<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Services\View\Traits\ViewAttributes;
use Illuminate\Database\Eloquent\SoftDeletes;

class View extends Model {

    use ViewAttributes, SoftDeletes;

 //   public $timestamps = false;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'view';

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

    public function content()
    {
        return $this->belongsTo('App\Content');
    }

    public function enrollment()
    {
        return $this->belongsTo('App\Enrollment');
    }

}
