<?php

Route::group([
    'middleware' => 'access.routeNeedsPermission',
    'permission' => ['videos'],
    'redirect'   => '/',
    'with'       => ['flash_danger', 'You do not have access to do that.']
], function ()
{

    resource('videos', 'VideoController', ['except' => ['show']]);

});