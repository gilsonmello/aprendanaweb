<?php

Route::group([
    'middleware' => 'access.routeNeedsPermission',
    'permission' => ['packages'],
    'redirect'   => '/',
    'with'       => ['flash_danger', 'You do not have access to do that.']
], function ()
{


    resource('packages', 'PackageController', ['except' => ['show']]);

});


Route::group([
    'middleware' => 'access.routeNeedsPermission',
    'permission' => ['packages'],
    'redirect'   => '/',
    'with'       => ['flash_danger', 'You do not have access to do that.']
], function ()
{


    resource('packageexams', 'PackageExamController', ['except' => ['show']]);

    get('packageexams/addindex', ['as' => 'admin.packageexams.addindex', 'uses' => 'PackageExamController@addIndex']);
    get('packageexams/add/{exam_id}', ['as' => 'admin.packageexams.add', 'uses' => 'PackageExamController@add']);


});

Route::group([
    'middleware' => 'access.routeNeedsPermission',
    'permission' => ['packages'],
    'redirect'   => '/',
    'with'       => ['flash_danger', 'You do not have access to do that.']
], function ()
{


    resource('packageteachers', 'PackageTeacherController', ['except' => ['show']]);

    get('packageteachers/addindex', ['as' => 'admin.packageteachers.addindex', 'uses' => 'PackageTeacherController@addIndex']);
    post('packageteachers/add', ['as' => 'admin.packageteachers.add', 'uses' => 'PackageTeacherController@add']);


});