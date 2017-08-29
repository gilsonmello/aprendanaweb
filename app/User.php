<?php

namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use App\Services\Access\Traits\UserHasRole;

/**
 * Class User
 * @package App
 */
class User extends Model implements AuthenticatableContract, CanResetPasswordContract {

        use Authenticatable,
            CanResetPassword,
            SoftDeletes,
            UserHasRole;

        /**
         * The database table used by the model.
         *
         * @var string
         */
        protected $table = 'users';

        /**
         * The attributes that are not mass assignable.
         *
         * @var array
         */
        protected $guarded = ['id'];

        /**
         * The attributes excluded from the model's JSON form.
         *
         * @var array
         */
        protected $hidden = ['password', 'remember_token'];

        /**
         * For soft deletes
         *
         * @var array
         */
        protected $dates = ['deleted_at'];

        /**
         * @return \Illuminate\Database\Eloquent\Relations\HasMany
         */
        public function providers() {
                return $this->hasMany('App\UserProvider');
        }

        public function scopeTeachers($query) {
                return $query->whereHas('roles', function ($subquery) {
                                $subquery->where('name', 'Professor');
                        });
        }

        public function scopeTeachersFeatured($query) {
                return $query->where('list_on_site', '=', '1')->where('featured', '=', '1')->whereHas('roles', function ($subquery) {
                                $subquery->where('name', 'Professor');
                        });
        }

        public function is($rolename) {

                foreach ($this->roles()->get() as $role) {
                        if ($role->name == $rolename) {
                                return true;
                        }
                }
                return false;
        }

        public function onlyStudents($singlePermission) {
                if (count($this->roles()->get()) == 1 && $this->roles->get()[0] == "Aluno") {
                        return true;
                }
                return false;
        }

        /**
         * Hash the users password
         *
         * @param $value
         */
        public function setPasswordAttribute($value) {
                if (\Hash::needsRehash($value))
                        $this->attributes['password'] = bcrypt($value);
                else
                        $this->attributes['password'] = $value;
        }

        /**
         * @return mixed
         */
        public function canChangeEmail() {
                return config('access.users.change_email');
        }

        /**
         * @return string
         */
        public function getConfirmedLabelAttribute() {
                if ($this->confirmed == 1)
                        return "<label class='label label-success'>Sim</label>";
                return "<label class='label label-danger'>Não</label>";
        }

        public function scopeStudents($query) {
                return $query->whereHas('roles', function ($subquery) {
                                $subquery->where('name', 'Aluno');
                        });
        }

        public function scopeAdministrators($query) {
                return $query->whereHas('roles', function ($subquery) {
                                $subquery->where('name', 'Administrador');
                        });
        }

        public function notifications() {
                return $this->hasMany('App\NotificationUser');
        }

        public function lessons() {
                $this->belongsToMany('App\Lesson', 'lesson_teachers');
        }

        /**
         * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
         */
        public function videos() {
                return $this->belongsToMany('App\Video', 'video_user', 'user_id', 'video_id');
        }

        /**
         * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
         */
        public function articles() {
                return $this->belongsToMany('App\Article', 'article_user', 'user_id', 'article_id');
        }

        public function enrollments() {
                return $this->hasMany('App\Enrollment', 'student_id');
        }

        public function packages() {
                return $this->belongsToMany('App\Package', 'package_teachers', 'teacher_id', 'package_id');
        }

        public function scopeIdOrSlug() {
                if (($this->slug != null) && ($this->slug != null))
                        return $this->slug;
                else
                        return $this->id;
        }

        public function scopeRepresentatives($query) {
                return $query->whereHas('roles', function ($subquery) {
                        $subquery->where('name', 'Representante');
                });
        }

}
