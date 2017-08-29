<?php

Route::group([
    'middleware' => 'access.routeNeedsPermission',
    'permission' => ['analysisexams'],
    'redirect'   => '/',
    'with'       => ['flash_danger', 'You do not have access to do that.']
], function ()
{


    resource('analysisexams', 'AnalysisExamController', ['except' => ['show']]);

});

Route::group([
    'middleware' => 'access.routeNeedsPermission',
    'permission' => ['analysisexams'],
    'redirect'   => '/',
    'with'       => ['flash_danger', 'You do not have access to do that.']
], function ()
{
    resource('analysisexamsubjects', 'AnalysisExamSubjectController', ['except' => ['show']]);

    get('analysisexamsubjects/addindex', ['as' => 'admin.analysisexamsubjects.addindex', 'uses' => 'AnalysisExamSubjectController@addIndex']);
    post('analysisexamsubjects/add', ['as' => 'admin.analysisexamsubjects.add', 'uses' => 'AnalysisExamSubjectController@add']);

});