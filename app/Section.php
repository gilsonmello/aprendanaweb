<?php namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Services\Section\Traits\SectionAttributes;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Section extends Model {

    use SectionAttributes, SoftDeletes;

    public $timestamps = true;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'sections';


    public function subsections()
    {
        return $this->hasMany('App\Subsection');
    }

    public function scopeCourses($query, $limit, $order = NULL)
    {
        $section_id = $this->id;

        if(!is_null($order)){
            $order = $order;
        }else{
            $order = 'desc';
        }

        if($limit > 0){
        return Course::where('is_active', 1)->where('activation_date', '<=', Carbon::now())->whereHas('subsection', function($query) use ($section_id){
            $query->where('section_id', $section_id);
        })->orderBy("featured", $order)->orderBy("activation_date", $order)->paginate($limit);
        }else{
            
            return Course::where('is_active', 1)->where('activation_date', '<=', Carbon::now())->whereHas('subsection', function($query) use ($section_id){
                $query->where('section_id', $section_id);
            })->orderBy("featured", $order)->orderBy("activation_date", $order);
        }
    }

    public function scopePackages($query, $limit)
    {
        $section_id = $this->id;
        if($limit > 0){
        return Package::where('is_active', 1)->where('activation_date', '<=', Carbon::now())->whereHas('subsection', function($query) use ($section_id){
            $query->where('section_id', $section_id);
        })->orderBy("activation_date", "desc")->paginate($limit);
        }else{
            return Package::where('is_active', 1)->where('activation_date', '<=', Carbon::now())->whereHas('subsection', function($query) use ($section_id){
                $query->where('section_id', $section_id);
            })->orderBy("activation_date", "desc");
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

    /**
     * @return string
     */
    public function getIsActiveLabelAttribute() {
        if ($this->active == 1)
            return "<label class='label label-success'>Sim</label>";
        return "<label class='label label-danger'>Não</label>";
    }

}
