<?php

Route::group([
    'middleware' => 'access.routeNeedsPermission',
    'permission' => ['processteacherstatements'],
    'redirect'   => '/',
    'with'       => ['flash_danger', 'You do not have access to do that.']
], function ()
{

    get('processteacherstatements/', ['as' => 'admin.processteacherstatements.index', 'uses' => 'ProcessTeacherStatementController@index']);
    get('processteacherstatements/process/', ['as' => 'admin.processteacherstatements.process', 'uses' => 'ProcessTeacherStatementController@process']);


});