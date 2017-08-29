<?php namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use App\Services\Subsection\Traits\SubsectionAttributes;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subsection extends Model {

    use SubsectionAttributes, SoftDeletes;

    public $timestamps = true;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'subsections';

    public function section()
    {
        return $this->belongsTo('App\Section');
    }


    public function scopeCourses($query, $limit)
    {
        $section_id = $this->id;
        if($limit > 0){
            return Course::where('is_active', 1)->where('activation_date', '<=', Carbon::now())->where('subsection_id',$section_id)->orderBy("featured", "desc")->orderBy("activation_date", "desc")->paginate($limit);
        }else{
            return Course::where('is_active', 1)->where('activation_date', '<=', Carbon::now())->where('subsection_id',$section_id)->orderBy("featured", "desc")->orderBy("activation_date", "desc");
        }
    }

    public function scopePackages($query, $limit)
    {
        $section_id = $this->id;
        if($limit > 0){
            return Package::where('is_active', 1)->where('activation_date', '<=', Carbon::now())->where('subsection_id',$section_id)->orderBy("activation_date", "desc")->paginate($limit);
        }else{
            return Package::where('is_active', 1)->where('activation_date', '<=', Carbon::now())->where('subsection_id',$section_id)->orderBy("activation_date", "desc");
        }
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
