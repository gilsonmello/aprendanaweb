<?php namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Services\Course\Traits\CourseAttributes;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property  user_admin_id
 */
class BookStore extends Model {

    use CourseAttributes, SoftDeletes;

    public $timestamps = true;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'courses';

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

    public function modules()
    {
        return $this->hasMany('App\Module');
    }


    public function teachers()
    {
        return $this->hasMany('App\CourseTeacher');
    }

    public function workshops()
    {
        return $this->hasMany('App\Workshop');
    }


    public function exam(){
        return $this->hasOne('App\Exam');
    }

    public function executions(){
        return $this->hasMany('App\Execution');

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


    public function groups(){
        return $this->hasMany('App\Group');
    }

}
