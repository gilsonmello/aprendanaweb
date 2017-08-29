<?php namespace App\Services\AskTheTeacher\Traits;

use Carbon\Carbon;
use Illuminate\Support\Facades\Config;

/**
 * Class AskTheTeacherAttributes
 * @package App\Services\Access\Traits
 */
trait AskTheTeacherAttributes {

    /**
     * @param $date
     * @return string
     */
    public function getDateAttribute($date) {
        return format_datebr($date);
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
    public function getImgSizesAttribute() {
        if(!$this->img) return false;

        $path_upload = 'uploads/'.$this->table.'/'.$this->id;
        return img_sizes($path_upload, $this->img);
    }

    /**
     * @return array
     */
    public function getImgHtmlAttribute() {
        if(!$this->img) return false;

        $path_upload = '/uploads/'.$this->table.'/'.$this->id;
        return img_sizes_html($path_upload, $this->img);
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
        if($this->status != 1)
            return '<a href="'.route('admin.asktheteachers.edit', $this->id).'" class="btn btn-xs btn-primary"><i class="fa fa-pencil" data-toggle="tooltip" data-placement="top" title="' . trans('crud.edit_button') . '"></i></a>';
    }

    /**
     * @return string
     */
    public function getDeleteButtonAttribute() {
        if($this->status != 1)
            return '<a href="'.route('admin.asktheteachers.destroy', $this->id).'" data-method="delete" class="btn btn-xs btn-danger"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="' . trans('crud.delete_button') . '"></i></a>';
    }

    /**
     * @return string
     */
    public function getActionButtonsAttribute() {
        return $this->getEditButtonAttribute();
    }

    /**
     * @return string
     */
    public function getEditAskTheTutorButtonAttribute() {
        if($this->status != 1)
            return '<a href="'.route('admin.askthetutors.edit', $this->id).'" class="btn btn-xs btn-primary"><i class="fa fa-pencil" data-toggle="tooltip" data-placement="top" title="' . trans('crud.edit_button') . '"></i></a>';
    }

    /**
     * @return string
     */
    public function getActionButtonsAskTheTutorAttribute() {
        return $this->getEditAskTheTutorButtonAttribute();
    }

}