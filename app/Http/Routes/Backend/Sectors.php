<?php

Route::group([
    'middleware' => 'access.routeNeedsPermission',
    'permission' => ['sectors'],
    'redirect'   => '/',
    'with'       => ['flash_danger', 'You do not have access to do that.']
], function ()
{

    resource('sectors', 'SectorController', ['except' => ['show']]);


});