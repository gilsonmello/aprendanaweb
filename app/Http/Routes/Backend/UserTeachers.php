<?php

Route::group([
    'middleware' => 'access.routeNeedsPermission',
    'permission' => ['userteachers'],
    'redirect'   => '/',
    'with'       => ['flash_danger', 'You do not have access to do that.']
], function ()
{

    resource('userteachers', 'UserTeacherController', ['except' => ['show']]);

    post('teachers/select', ['as' => 'admin.teachers.select', 'uses' => 'UserTeacherController@selectTeachers']);

    /* Specific User */
    Route::group(['prefix' => 'user/{id}', 'where' => ['id' => '[0-9]+']], function () {
        get('password/change', ['as' => 'admin.userteachers.change-password', 'uses' => 'UserTeacherController@changePassword']);
        post('password/change', ['as' => 'admin.userteachers.change-password', 'uses' => 'UserTeacherController@updatePassword']);
    });

});