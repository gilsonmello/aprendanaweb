<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Services\Faq\Traits\FaqAttributes;
use Illuminate\Database\Eloquent\SoftDeletes;

class Faq extends Model {

    use FaqAttributes, SoftDeletes;

    public $timestamps = true;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'faqs';

    public function faqcategory()
    {
        return $this->belongsTo('App\FaqCategory', 'category_faq_id');
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
