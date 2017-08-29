<?php namespace App\Services\Tag\Traits;

/**
 * Class AccessAttributes
 * @package App\Services\Access\Traits
 */
trait TagAttributes {

    /**
     * @return string
     */
    public function getEditButtonAttribute() {
        return '<a href="'.route('admin.tags.edit', $this->id).'" class="btn btn-xs btn-primary"><i class="fa fa-pencil" data-toggle="tooltip" data-placement="top" title="' . trans('crud.edit_button') . '"></i></a>';
    }

    /**
     * @return string
     */
    public function getDeleteButtonAttribute() {
        return '<a href="'.route('admin.tags.destroy', $this->id).'" data-method="delete" class="btn btn-xs btn-danger"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="' . trans('crud.delete_button') . '"></i></a>';
    }

    /**
     * @return string
     */
    public function getActionButtonsAttribute() {
        return $this->getEditButtonAttribute().' '.
        $this->getStatusButtonAttribute().' '.
        $this->getDeleteButtonAttribute();
    }

    /**
     * @return string
     */
    public function getStatusButtonAttribute() {
        if ($this->active_at == null) {
            return '<a href="' . route('admin.tags.activated', [$this->id]) . '" class="btn btn-xs btn-success"><i class="fa fa-play" data-toggle="tooltip" data-placement="top" title="' . trans('crud.activate_tag_button') . '"></i></a> ';
        } else {
            return '<a href="'.route('admin.tags.deactivated', [$this->id]).'" class="btn btn-xs btn-warning"><i class="fa fa-pause" data-toggle="tooltip" data-placement="top" title="' . trans('crud.deactivate_tag_button') . '"></i></a> ';
        }
    }

    public function getUserModeratorNameAttribute() {
        if ($this->userModerator == null){
            return "";
        } else {
            return $this->userModerator->name;
        }
    }
}