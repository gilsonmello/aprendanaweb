<?php namespace App\Services\Access\Traits;

/**
 * Class AccessAttributes
 * @package App\Services\Access\Traits
 */
trait UserStudentsAttributes {

	/**
	 * @return string
	 */
	public function getStudentEditButtonAttribute() {
		return '<a href="'.route('admin.userstudents.edit', $this->id).'" class="btn btn-xs btn-primary"><i class="fa fa-pencil" data-toggle="tooltip" data-placement="top" title="' . trans('crud.edit_button') . '"></i></a>';
	}

	/**
	 * @return string
	 */
	public function getStudentChangePasswordButtonAttribute() {
		return '<a href="'.route('admin.access.user.change-password', $this->id).'" class="btn btn-xs btn-info"><i class="fa fa-refresh" data-toggle="tooltip" data-placement="top" title="' . trans('crud.change_password_button') . '"></i></a>';
	}

	/**
	 * @return string
	 */
	public function getStudentStatusButtonAttribute() {
		switch($this->status) {
			case 0:
				return '<a href="'.route('admin.access.user.mark', [$this->id, 1]).'" class="btn btn-xs btn-success"><i class="fa fa-play" data-toggle="tooltip" data-placement="top" title="' . trans('crud.activate_user_button') . '"></i></a> ';

			case 1:
				return '<a href="'.route('admin.access.user.mark', [$this->id, 0]).'" class="btn btn-xs btn-warning"><i class="fa fa-pause" data-toggle="tooltip" data-placement="top" title="' . trans('crud.deactivate_user_button') . '"></i></a> ';
				//<a href="'.route('admin.access.user.mark', [$this->id, 2]).'" class="btn btn-xs btn-danger"><i class="fa fa-times" data-toggle="tooltip" data-placement="top" title="' . trans('crud.ban_user_button') . '"></i></a> ';

			case 2:
				return '<a href="'.route('admin.access.user.mark', [$this->id, 1]).'" class="btn btn-xs btn-success"><i class="fa fa-play" data-toggle="tooltip" data-placement="top" title="' . trans('crud.activate_user_button') . '"></i></a> ';

			default:
				return '';
		}
	}

	public function getStudentConfirmedButtonAttribute() {
		if (! $this->confirmed)
			return '<a href="'.route('admin.account.confirm.resend', $this->id).'" class="btn btn-xs btn-success"><i class="fa fa-refresh" data-toggle="tooltip" data-placement="top" title="Resend Confirmation E-mail"></i></a> ';
	}

	/**
	 * @return string
	 */
	public function getStudentDeleteButtonAttribute() {
		return '<a href="'.route('admin.access.users.destroy', $this->id).'" data-method="delete" class="btn btn-xs btn-danger"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="' . trans('crud.delete_button') . '"></i></a>';
	}

	/**
	 * @return string
	 */
	public function getStudentActionButtonsAttribute() {
		return $this->getStudentEditButtonAttribute().' '.
		$this->getStudentChangePasswordButtonAttribute().' '.
		$this->getStudentStatusButtonAttribute().
		$this->getStudentConfirmedButtonAttribute().
		$this->getStudentDeleteButtonAttribute();
	}
}