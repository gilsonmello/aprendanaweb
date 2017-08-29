<?php namespace App\Services\Access\Traits;

/**
 * Class AccessAttributes
 * @package App\Services\Access\Traits
 */
trait UserTeachersAttributes {

	/**
	 * @return string
	 */
	public function getTeacherEditButtonAttribute() {
		return '<a href="'.route('admin.userteachers.edit', $this->id).'" class="btn btn-xs btn-primary"><i class="fa fa-pencil" data-toggle="tooltip" data-placement="top" title="' . trans('crud.edit_button') . '"></i></a>';
	}

	/**
	 * @return string
	 */
	public function getTeacherChangePasswordButtonAttribute() {
		return '<a href="'.route('admin.userteachers.change-password', $this->id).'" class="btn btn-xs btn-info"><i class="fa fa-refresh" data-toggle="tooltip" data-placement="top" title="' . trans('crud.change_password_button') . '"></i></a>';
	}

	/**
	 * @return string
	 */
	public function getTeacherStatusButtonAttribute() {
		switch($this->status) {
			case 0:
				return '<a href="'.route('admin.access.user.mark', [$this->id, 1]).'" class="btn btn-xs btn-success"><i class="fa fa-play" data-toggle="tooltip" data-placement="top" title="' . trans('crud.activate_user_button') . '"></i></a> ';

			case 1:
				return '<a href="'.route('admin.access.user.mark', [$this->id, 0]).'" class="btn btn-xs btn-warning"><i class="fa fa-pause" data-toggle="tooltip" data-placement="top" title="' . trans('crud.deactivate_user_button') . '"></i></a> <a href="'.route('admin.access.user.mark', [$this->id, 2]).'" class="btn btn-xs btn-danger"><i class="fa fa-times" data-toggle="tooltip" data-placement="top" title="' . trans('crud.ban_user_button') . '"></i></a> ';

			case 2:
				return '<a href="'.route('admin.access.user.mark', [$this->id, 1]).'" class="btn btn-xs btn-success"><i class="fa fa-play" data-toggle="tooltip" data-placement="top" title="' . trans('crud.activate_user_button') . '"></i></a> ';

			default:
				return '';
		}
	}

	public function getTeacherConfirmedButtonAttribute() {
		if (! $this->confirmed)
			return '<a href="'.route('admin.account.confirm.resend', $this->id).'" class="btn btn-xs btn-success"><i class="fa fa-refresh" data-toggle="tooltip" data-placement="top" title="Resend Confirmation E-mail"></i></a> ';
	}

	/**
	 * @return string
	 */
	public function getTeacherDeleteButtonAttribute() {
		return '<a href="'.route('admin.access.users.destroy', $this->id).'" data-method="delete" class="btn btn-xs btn-danger"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="' . trans('crud.delete_button') . '"></i></a>';
	}

	/**
	 * @return string
	 */
	public function getTeacherActionButtonsAttribute() {
		return $this->getTeacherEditButtonAttribute().' '.
		$this->getTeacherChangePasswordButtonAttribute().' '.
		$this->getTeacherStatusButtonAttribute().
		$this->getTeacherConfirmedButtonAttribute().
		$this->getTeacherDeleteButtonAttribute();
	}

	/**
	 * @return array
	 */
	public function getTagsArrayAttribute() {
		if(!$this->tags) return [];
		return prepare_tags($this->tags);
	}

}