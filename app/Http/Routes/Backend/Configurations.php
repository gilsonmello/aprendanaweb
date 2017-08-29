<?php

Route::group([
    'middleware' => 'access.routeNeedsPermission',
    'permission' => ['configurations'],
    'redirect'   => '/',
    'with'       => ['flash_danger', 'You do not have access to do that.']
], function ()
{

    resource('configurations', 'ConfigurationController', ['except' => ['show']]);


});