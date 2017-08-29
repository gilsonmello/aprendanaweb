<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Services\Section\Traits\SectionAttributes;
use Illuminate\Database\Eloquent\SoftDeletes;

class Session extends Model {

    public $timestamps = false;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'sessions';

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
}
