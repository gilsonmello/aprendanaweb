<?php

Route::group([
    'middleware' => 'access.routeNeedsPermission',
    'permission' => ['cities'],
    'redirect'   => '/',
    'with'       => ['flash_danger', 'You do not have access to do that.']
], function ()
{

    resource('cities', 'CityController', ['except' => ['show']]);
    get('cities/select', ['as' => 'admin.cities.select', 'uses' => 'CityController@selectCity']);


});