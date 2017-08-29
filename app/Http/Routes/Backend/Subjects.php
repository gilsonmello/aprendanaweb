<?php

Route::group([
    'middleware' => 'access.routeNeedsPermission',
    'permission' => ['subjects'],
    'redirect'   => '/',
    'with'       => ['flash_danger', 'You do not have access to do that.']
], function ()
{


    resource('subjects', 'SubjectController', ['except' => ['show']]);

});


Route::group([
    'middleware' => 'access.routeNeedsPermission',
    'permission' => ['subjects'],
    'redirect'   => '/',
    'with'       => ['flash_danger', 'You do not have access to do that.']
], function ()
{


    resource('subjectcourses', 'SubjectCourseController', ['except' => ['show']]);

    get('subjectcourses/conference', ['as' => 'admin.subjectcourses.conference', 'uses' => 'SubjectCourseController@conference']);
    get('subjectcourses/addindex', ['as' => 'admin.subjectcourses.addindex', 'uses' => 'SubjectCourseController@addIndex']);
    post('subjectcourses/add', ['as' => 'admin.subjectcourses.add', 'uses' => 'SubjectCourseController@add']);

    resource('subjectpackages', 'SubjectPackageController', ['except' => ['show']]);

    get('subjectpackages/addindex', ['as' => 'admin.subjectpackages.addindex', 'uses' => 'SubjectPackageController@addIndex']);
    post('subjectpackages/add', ['as' => 'admin.subjectpackages.add', 'uses' => 'SubjectPackageController@add']);
    post('/subject/select', ['as' => 'admin.subjects.select', 'uses' => 'SubjectController@selectSubject']);
    post('/subject/select', ['as' => 'admin.subjects.select', 'uses' => 'SubjectController@selectSubject']);
    post('/subject-course/select', ['as' => 'admin.subjects.courses.select', 'uses' => 'SubjectController@selectSubject']);


});