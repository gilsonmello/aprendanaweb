<?php

Route::group([
    'middleware' => 'access.routeNeedsPermission',
    'permission' => ['asktheteachers', 'tutorsthestudents'],
    'redirect'   => '/',
    'with'       => ['flash_danger', 'You do not have access to do that.']
], function ()
{

    resource('asktheteachers', 'AskTheTeacherController', ['except' => ['show']]);

    get('askthetutors/index', ['as' => 'admin.askthetutors.index', 'uses' => 'AskTheTeacherController@askTheTutors']);

    get('askthetutors/{id}/edit', ['as' => 'admin.askthetutors.edit', 'uses' => 'AskTheTeacherController@askTheTutorEdit']);

    post('askthetutors/updateAskTheTutor/{id}', ['as' => 'admin.askthetutors.updateAskTheTutor', 'uses' => 'AskTheTeacherController@updateAskTheTutor']);


});