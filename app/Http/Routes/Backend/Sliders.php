<?php

Route::group([
    'middleware' => 'access.routeNeedsPermission',
    'permission' => ['sliders'],
    'redirect'   => '/',
    'with'       => ['flash_danger', 'You do not have access to do that.']
], function ()
{

    resource('sliders', 'SliderController', ['except' => ['show']]);


});