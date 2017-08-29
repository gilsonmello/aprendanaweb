<?php

Route::group([
    'middleware' => 'access.routeNeedsPermission',
    'permission' => ['questions'],
    'redirect'   => '/',
    'with'       => ['flash_danger', 'You do not have access to do that.']
], function ()
{


    resource('questions', 'QuestionController', ['except' => ['show']]);
    get('questions/reports', ['as' => 'admin.questions.reports', 'uses' => 'QuestionController@questionsReports']);

});