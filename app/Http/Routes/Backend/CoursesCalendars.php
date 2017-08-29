<?php
/**
 * Created by PhpStorm.
 * User: geofrey
 * Date: 22/09/15
 * Time: 16:30
 */

Route::group([
    'middleware' => 'access.routeNeedsPermission',
    'permission' => ['coursecalendars'],
    'redirect'   => '/',
    'with'       => ['flash_danger', 'You do not have access to do that.']
], function ()
{

    resource('coursecalendars', 'CourseCalendarController', ['except' => ['show']]);


});