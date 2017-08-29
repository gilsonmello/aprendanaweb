<?php

Route::group([
    'middleware' => 'access.routeNeedsPermission',
    'permission' => ['exams'],
    'redirect'   => '/',
    'with'       => ['flash_danger', 'You do not have access to do that.']
], function ()
{


    resource('exams', 'ExamController', ['except' => ['show']]);

});

Route::group([
    'middleware' => 'access.routeNeedsPermission',
    'permission' => ['exams'],
    'redirect'   => '/',
    'with'       => ['flash_danger', 'You do not have access to do that.']
], function ()
{


    resource('groups', 'GroupController', ['except' => ['show']]);

});

Route::group([
    'middleware' => 'access.routeNeedsPermission',
    'permission' => ['exams'],
    'redirect'   => '/',
    'with'       => ['flash_danger', 'You do not have access to do that.']
], function ()
{


    resource('groupquestions', 'GroupQuestionController', ['except' => ['show']]);
    get('groupquestions/conf/{id}', ['as' => 'admin.groupquestions.conf', 'uses' => 'GroupQuestionController@conf']);
    get('groupquestions/themes/{id}', ['as' => 'admin.groupquestions.themes', 'uses' => 'GroupQuestionController@themes']);
    get('groupquestions/subthemes/{id}', ['as' => 'admin.groupquestions.subthemes', 'uses' => 'GroupQuestionController@subthemes']);
    get('groupquestions/originals/{id}', ['as' => 'admin.groupquestions.originals', 'uses' => 'GroupQuestionController@originals']);
    post('groupquestions/changesequence', ['as' => 'admin.groupquestions.changesequence', 'uses' => 'GroupQuestionController@changeSequence']);
    get('groupquestions/addindex', ['as' => 'admin.groupquestions.addindex', 'uses' => 'GroupQuestionController@addIndex']);
    get('groupquestions/add/{question_id}', ['as' => 'admin.groupquestions.add', 'uses' => 'GroupQuestionController@add']);
    get('associationsaap/{id_saap}', ['as' => 'admin.associationsaap', 'uses' => 'ExamController@associationSaap']);

});

Route::group([
    'middleware' => 'access.routeNeedsPermission',
    'permission' => ['exams'],
    'redirect'   => '/',
    'with'       => ['flash_danger', 'You do not have access to do that.']
], function ()
{


    resource('examcourses', 'ExamCourseController', ['except' => ['show']]);
    get('examcourses/addindex', ['as' => 'admin.examcourses.addindex', 'uses' => 'ExamCourseController@addIndex']);
    post('examcourses/add', ['as' => 'admin.examcourses.add', 'uses' => 'ExamCourseController@add']);

});