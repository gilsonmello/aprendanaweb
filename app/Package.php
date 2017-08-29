<?php namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Services\Package\Traits\PackageAttributes;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property  user_admin_id
 */
class Package extends Model {

    use PackageAttributes, SoftDeletes;

    public $timestamps = true;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'packages';

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

    public function subsection()
    {
        return $this->belongsTo('App\Subsection');
    }

    public function exams()
    {
        return $this->hasMany('App\ExamPackage');
    }

    public function teachers()
    {
        return $this->hasMany('App\PackageTeacher');
    }


    public function getFinalPriceAttribute()
    {
        if (($this->special_price !== null) && ($this->special_price != 0.00)) {
            $startsAt = parsebr($this->start_special_price);
            $endsAt = parsebr($this->end_special_price);
            if (($startsAt != '') && ($endsAt != '')) {
                $startsAt = Carbon::parse($startsAt);
                $endsAt = Carbon::parse($endsAt);
                $inRange = Carbon::today()->between($startsAt, $endsAt, true);
                if ($inRange) return $this->special_price;
            }
        }

        return $this->discount_price;
    }

    /**
     * @return array
     */
    public function getTagsArrayAttribute() {
        if(!$this->tags) return [];
        return prepare_tags($this->tags);
    }
}