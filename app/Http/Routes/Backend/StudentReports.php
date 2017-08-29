<?php

Route::group([
    'middleware' => 'access.routeNeedsPermission',
    'permission' => ['studentreports'],
    'redirect'   => '/',
    'with'       => ['flash_danger', 'You do not have access to do that.']
], function ()
{


    get('studentreports/index', ['as' => 'admin.studentreports.index', 'uses' => 'StudentReportController@performance']);
    get('studentreports/demographics', ['as' => 'admin.studentreports.demographics', 'uses' => 'StudentReportController@demographics']);
    get('studentreports/saap', ['as' => 'admin.studentreports.saap', 'uses' => 'StudentReportController@executionsSaap']);

});