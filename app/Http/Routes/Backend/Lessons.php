<?php

Route::group([
    'middleware' => 'access.routeNeedsPermission',
    'permission' => ['lessons'],
    'redirect'   => '/',
    'with'       => ['flash_danger', 'You do not have access to do that.']
], function ()
{

    resource('lessons', 'LessonController', ['except' => ['show']]);
    post('lessons/select', ['as' => 'admin.users.select', 'uses' => 'LessonController@selectLesson']);

});