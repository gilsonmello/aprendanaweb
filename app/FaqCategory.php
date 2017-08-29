<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Services\FaqCategory\Traits\FaqCategoryAttributes;
use Illuminate\Database\Eloquent\SoftDeletes;

class faqCategory extends Model {

    use FaqCategoryAttributes, SoftDeletes;

    public $timestamps = true;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'faqcategory';


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

    public function faqs()
    {
        return $this->hasMany('App\Faq', 'category_faq_id');
    }
}
