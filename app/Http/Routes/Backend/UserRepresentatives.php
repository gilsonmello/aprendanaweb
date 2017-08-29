<?php

Route::group([
    'middleware' => 'access.routeNeedsPermission',
    'permission' => ['userrepresentatives'],
    'redirect'   => '/',
    'with'       => ['flash_danger', 'You do not have access to do that.']
], function ()
{
    resource('userrepresentatives', 'UserRepresentativeController', ['except' => ['show']]);

    post('userrepresentatives/select', ['as' => 'admin.representatives.select', 'uses' => 'UserRepresentativeController@selectRepresentative']);

    /* Specific User */
    Route::group(['prefix' => 'user/{id}', 'where' => ['id' => '[0-9]+']], function () {
        get('password/change', ['as' => 'admin.userrepresentatives.change-password', 'uses' => 'UserRepresentativeController@changePassword']);
        post('password/change', ['as' => 'admin.userrepresentatives.change-password', 'uses' => 'UserRepresentativeController@updatePassword']);
    });

    get('userrepresentatives/{id}/coupons', ['as' => 'admin.userrepresentatives.coupons', 'uses' => 'UserRepresentativeController@coupons']);
    get('userrepresentatives/{id}/addcoupon', ['as' => 'admin.userrepresentatives.addcoupons', 'uses' => 'UserRepresentativeController@addCoupon']);
});