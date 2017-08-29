<?php

Route::group([
    'middleware' => 'access.routeNeedsPermission',
    'permission' => ['myworkshopactivitys'],
    'redirect'   => '/',
    'with'       => ['flash_danger', 'You do not have access to do that.']
], function ()
{


    resource('myworkshopactivitys', 'MyWorkshopActivityController', ['except' => ['show']]);

});