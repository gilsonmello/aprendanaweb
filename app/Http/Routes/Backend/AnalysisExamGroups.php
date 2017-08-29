<?php

Route::group([
    'middleware' => 'access.routeNeedsPermission',
    'permission' => ['analysisexamgroups'],
    'redirect'   => '/',
    'with'       => ['flash_danger', 'You do not have access to do that.']
], function ()
{


    resource('analysisexamgroups', 'AnalysisExamGroupController', ['except' => ['show']]);

});