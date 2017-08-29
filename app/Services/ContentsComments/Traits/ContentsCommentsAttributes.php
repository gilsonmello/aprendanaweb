<?php namespace App\Services\ContentsComments\Traits;

/**
 * Class AccessAttributes
 * @package App\Services\Access\Traits
 */
trait ContentsCommentsAttributes {

    /**
     * @return string
     */
    public function getEditButtonAttribute() {
        return '<a href="'.route('admin.contentcomments.edit', $this->id).'" class="btn btn-xs btn-primary"><i class="fa fa-pencil" data-toggle="tooltip" data-placement="top" title="' . trans('crud.edit_button') . '"></i></a>';
    }

    public function getContentsCommentsStatusButtonAttribute() {
        if ($this->is_active == 0) {
            return '<a href="' . route('admin.contentcomments.activated', [$this->id]) . '" class="btn btn-xs btn-success"><i class="fa fa-play" data-toggle="tooltip" data-placement="top" title="' . trans('crud.activate_contents_comments_button') . '"></i></a> ';
        } else {
            return '<a href="'.route('admin.contentcomments.deactivated', [$this->id]).'" class="btn btn-xs btn-warning"><i class="fa fa-pause" data-toggle="tooltip" data-placement="top" title="' . trans('crud.deactivate_contents_comments_button') . '"></i></a> ';
        }

    }

    /**
     * @return string
     */
    public function getDeleteButtonAttribute() {
        return '<a href="'.route('admin.contentcomments.destroy', $this->id).'" data-method="delete" class="btn btn-xs btn-danger"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="' . trans('crud.delete_button') . '"></i></a>';
    }

    /**
     * @return string
     */
    public function getActionButtonsAttribute() {
        return $this->getContentsCommentsStatusButtonAttribute().' '.
        $this->getDeleteButtonAttribute();
    }
}