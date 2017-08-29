<?php

Route::group([
    'middleware' => 'access.routeNeedsPermission',
    'permission' => ['advertisingpartners'],
    'redirect'   => '/',
    'with'       => ['flash_danger', 'You do not have access to do that.']
], function ()
{


    resource('advertisingpartners', 'AdvertisingpartnerController', ['except' => ['show']]);

});