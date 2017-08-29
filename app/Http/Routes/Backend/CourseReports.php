<?php

Route::group([
    'middleware' => 'access.routeNeedsPermission',
    'permission' => ['coursereports'],
    'redirect'   => '/',
    'with'       => ['flash_danger', 'You do not have access to do that.']
], function ()
{

    get('coursereports/sales', ['as' => 'admin.coursereports.sales', 'uses' => 'CourseReportController@sales']);
    get('coursereports/stats', ['as' => 'admin.coursereports.stats', 'uses' => 'CourseReportController@stats']);

});