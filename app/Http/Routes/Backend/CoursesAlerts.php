<?php
/**
 * Created by PhpStorm.
 * User: geofrey
 * Date: 22/09/15
 * Time: 16:30
 */

Route::group([
    'middleware' => 'access.routeNeedsPermission',
    'permission' => ['coursealerts'],
    'redirect'   => '/',
    'with'       => ['flash_danger', 'You do not have access to do that.']
], function ()
{

    resource('coursealerts', 'CourseAlertController', ['except' => ['show']]);

    put('coursealerts/sendemail/{id}', ['as' => 'admin.coursealerts.sendemail', 'uses' => 'CourseAlertController@sendToMail']);



});