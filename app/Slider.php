<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Services\Slider\Traits\SliderAttributes;
use Illuminate\Database\Eloquent\SoftDeletes;

class Slider extends Model {

    use SliderAttributes, SoftDeletes;

    public $timestamps = false;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'sliders';

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
