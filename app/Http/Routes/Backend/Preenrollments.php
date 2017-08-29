<?php

Route::group([
    'middleware' => 'access.routeNeedsPermission',
    'permission' => ['preenrollments'],
    'redirect'   => '/',
    'with'       => ['flash_danger', 'You do not have access to do that.']
], function ()
{


    resource('preenrollments', 'PreenrollmentController', ['except' => ['show']]);

    get('preenrollment/addday/{preenrollment_id}', ['as' => 'admin.preenrollments.addday', 'uses' => 'PreenrollmentController@addDayPreenrollment']);
    get('preenrollment/addweek/{preenrollment_id}', ['as' => 'admin.preenrollments.addweek', 'uses' => 'PreenrollmentController@addWeekPreenrollment']);

    get('preenrollment/importselectfile', ['as' => 'admin.preenrollments.importselectfile', 'uses' => 'PreenrollmentController@importSelectFile']);
    post('preenrollment/import', ['as' => 'admin.preenrollments.import', 'uses' => 'PreenrollmentController@import']);

    get('preenrollment/email/{preenrollment_id}', ['as' => 'admin.preenrollments.email', 'uses' => 'PreenrollmentController@email']);

    get('preenrollment/studentgroups', ['as' => 'admin.preenrollments.studentgroups', 'uses' => 'PreenrollmentController@studentGroups']);
    get('preenrollment/sendemaillist/{studentgroup_id}', ['as' => 'admin.preenrollments.sendemaillist', 'uses' => 'PreenrollmentController@sendEmailList']);
    post('preenrollment/sendemail', ['as' => 'admin.preenrollments.sendemail', 'uses' => 'PreenrollmentController@sendEmailStudentGroup']);

});

