<?php namespace App\Services\Exam\Traits;

/**
 * Class AccessAttributes
 * @package App\Services\Access\Traits
 */
trait ExamAttributes {


    public function getVideoAdUrlAttribute($video_ad_url){
        if(starts_with($video_ad_url,'http://')){
            return 'https://' . substr($video_ad_url,7);
        }
        return $video_ad_url;
    }
    /**
     * @return string
     */
    public function getEditButtonAttribute() {
        return '<a href="'.route('admin.exams.edit', $this->id).'" class="btn btn-xs btn-primary"><i class="fa fa-pencil" data-toggle="tooltip" data-placement="top" title="' . trans('crud.edit_button') . '"></i></a>';
    }

    /**
     * @return string
     */
    public function getDeleteButtonAttribute() {
        return '<a href="'.route('admin.exams.destroy', $this->id).'" data-method="delete" class="btn btn-xs btn-danger"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="' . trans('crud.delete_button') . '"></i></a>';
    }

    public function getGroupsButtonAttribute(){
        return '<a href="'. route('admin.groups.index') . '?f_exam_id=' . $this->id . '" class="btn btn-xs btn-primary"><i class="fa fa-list" data-toggle="tooltip" data-placement="top" title="' . trans('crud.exams.groups_button') . '"></i></a>';
    }

    public function getCoursesButtonAttribute(){
        return '<a href="'. route('admin.examcourses.index') . '?f_exam_id=' . $this->id . '" class="btn btn-xs btn-primary"><i class="fa fa-tv" data-toggle="tooltip" data-placement="top" title="' . trans('crud.exams.courses_button') . '"></i></a>';
    }


    public function getAddButtonAttribute() {
        return '<a href="'.route('admin.packageexams.add', $this->id).'" class="btn btn-xs btn-primary"><i class="fa fa-plus" data-toggle="tooltip" data-placement="top" title="' . trans('crud.add_button') . '"></i></a>';
    }

    /**
     * @return string
     */
    public function getActionButtonsAttribute() {
        return $this->getEditButtonAttribute().' '.
        $this->getDeleteButtonAttribute().' '.
        $this->getGroupsButtonAttribute().' '.
        $this->getCoursesButtonAttribute();
    }

    /**
     * @return array
     */
    public function getTagsArrayAttribute() {
        if(!$this->tags) return [];
        return prepare_tags($this->tags);
    }

}