<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Services\Newsletter\Traits\NewsletterAttributes;
use Illuminate\Database\Eloquent\SoftDeletes;

class Newsletter extends Model {

    use NewsletterAttributes, SoftDeletes;

    public $timestamps = true;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'newsletters';

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

    public function campaign(){
        return $this->belongsTo('App\Campaign');
    }

}
