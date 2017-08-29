<?php

Route::group([
    'middleware' => 'access.routeNeedsPermission',
    'permission' => ['analysiss'],
    'redirect'   => '/',
    'with'       => ['flash_danger', 'You do not have access to do that.']
], function ()
{


    resource('analysiss', 'AnalysisController', ['except' => ['show']]);

});