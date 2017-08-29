<?php

Route::group([
    'middleware' => 'access.routeNeedsPermission',
    'permission' => ['banners'],
    'redirect'   => '/',
    'with'       => ['flash_danger', 'You do not have access to do that.']
], function ()
{

    resource('banners', 'BannerController', ['except' => ['show']]);

    get('banners/index', ['as' => 'admin.banners', 'uses' => 'BannerController@index']);


});