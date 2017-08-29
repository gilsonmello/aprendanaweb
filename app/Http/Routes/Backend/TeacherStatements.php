<?php

Route::group([
    'middleware' => 'access.routeNeedsPermission',
    'permission' => ['teacherstatements'],
    'redirect'   => '/',
    'with'       => ['flash_danger', 'You do not have access to do that.']
], function ()
{

    resource('teacherstatements', 'TeacherStatementController', ['except' => ['show']]);

    get('teacherstatements/activated/{user_id}', ['as' => 'admin.teacherstatements.activated', 'uses' => 'TeacherStatementController@activated']);
    get('teacherstatements/deactivated/{user_id}', ['as' => 'admin.teacherstatements.deactivated', 'uses' => 'TeacherStatementController@deactivated']);
    get('teacherstatements/process/{date}', ['as' => 'admin.teacherstatements.process', 'uses' => 'TeacherStatementController@process']);
    get('teacherstatements/processtoday', ['as' => 'admin.teacherstatements.processtoday', 'uses' => 'TeacherStatementController@processToday']);
    get('teacherstatements/processall', ['as' => 'admin.teacherstatements.processall', 'uses' => 'TeacherStatementController@processAll']);


});