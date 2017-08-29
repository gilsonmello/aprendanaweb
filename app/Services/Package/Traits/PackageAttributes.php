<?php namespace App\Services\Package\Traits;

/**
 * Class AccessAttributes
 * @package App\Services\Access\Traits
 */
use Carbon\Carbon;

trait PackageAttributes {

    public function getVideoAdUrlAttribute($video_ad_url){
        if(starts_with($video_ad_url,'http://')){
            return 'https://' . substr($video_ad_url,7);
        }
        return $video_ad_url;
    }
    /**
     * @param $activation_date
     * @return mixed
     */
    public function getActivationDateAttribute($activation_date) {
        return Carbon::parse($activation_date)->format('d/m/Y');
    }

    public function getEndSpecialPriceAttribute($end_special_price){
        return Carbon::parse($end_special_price)->format('d/m/Y');
    }

    public function getStartSpecialPriceAttribute($start_special_price){
        return Carbon::parse($start_special_price)->format('d/m/Y');
    }

    /**
     * @return string
     */
    public function getEditButtonAttribute() {
        return '<a href="'.route('admin.packages.edit', $this->id).'" class="btn btn-xs btn-primary"><i class="fa fa-pencil" data-toggle="tooltip" data-placement="top" title="' . trans('crud.edit_button') . '"></i></a>';
    }

    /**
     * @return string
     */
    public function getDeleteButtonAttribute() {
        return '<a href="'.route('admin.packages.destroy', $this->id).'" data-method="delete" class="btn btn-xs btn-danger"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="' . trans('crud.delete_button') . '"></i></a>';
    }

    public function getExamsButtonAttribute(){
        return '<a href="'. route('admin.packageexams.index') . '?f_package_id=' . $this->id . '" class="btn btn-xs btn-primary"><i class="fa fa-list" data-toggle="tooltip" data-placement="top" title="' . trans('crud.exams.exams_button') . '"></i></a>';
    }

    public function getTeachersButtonAttribute(){
        return '<a href="'. route('admin.packageteachers.index') . '?f_package_id=' . $this->id . '" class="btn btn-xs btn-primary"><i class="fa fa-user" data-toggle="tooltip" data-placement="top" title="' . trans('crud.exams.teachers_button') . '"></i></a>';
    }


    /**
     * @return string
     */
    public function getActionButtonsAttribute() {
        return $this->getEditButtonAttribute().' '.
        $this->getDeleteButtonAttribute(). ' ' .
        $this->getExamsButtonAttribute(). ' ' .
        $this->getTeachersButtonAttribute();
    }

}