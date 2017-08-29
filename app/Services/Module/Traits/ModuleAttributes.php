<?php namespace App\Services\Module\Traits;
use Carbon\Carbon;

/**
 * Class AccessAttributes
 * @package App\Services\Access\Traits
 */
trait ModuleAttributes {


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

    /**
     * @return array
     */
    public function getFeaturedImgSizesAttribute() {
        if(!$this->featured_img) return false;

        $path_upload = 'uploads/'.$this->table.'/'.$this->id;
        return img_sizes($path_upload, $this->featured_img);
    }

    /**
     * @return array
     */
    public function getFeaturedImgHtmlAttribute() {
        if(!$this->featured_img) return false;

        $path_upload = '/uploads/'.$this->table.'/'.$this->id;
        return img_sizes_html($path_upload, $this->featured_img);
    }

    /**
     * @return array
     */
    public function getTagsArrayAttribute() {
        if(!$this->tags) return [];
        return prepare_tags($this->tags);
    }

    /**
     * @return string
     */
    public function getEditButtonAttribute() {
        return '<a href="'.route('admin.modules.edit', $this->id).'" class="btn btn-xs btn-primary"><i class="fa fa-pencil" data-toggle="tooltip" data-placement="top" title="' . trans('crud.edit_button') . '"></i></a>';
    }



    /**
     * @return string
     */
    public function getDeleteButtonAttribute() {
        return '<a href="'.route('admin.modules.destroy', $this->id).'" data-method="delete" class="btn btn-xs btn-danger"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="' . trans('crud.delete_button') . '"></i></a>';
    }

    /**
     * @return string
     */
    public function getActionButtonsAttribute() {
        return $this->getEditButtonAttribute().' '.
        $this->getDeleteButtonAttribute();
    }
}