<?php

Route::group([
    'middleware' => 'access.routeNeedsPermission',
    'permission' => ['news'],
    'redirect'   => '/',
    'with'       => ['flash_danger', 'You do not have access to do that.']
], function ()
{

    resource('news', 'NewsController', ['except' => ['show']]);


});