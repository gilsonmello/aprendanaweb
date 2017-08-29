<?php

Route::group([
    'middleware' => 'access.routeNeedsPermission',
    'permission' => ['orders'],
    'redirect' => '/',
    'with' => ['flash_danger', 'You do not have access to do that.']
        ], function () {

    resource('orders', 'OrderController', ['except' => ['show']]);
    get('orders/{id}', ['as' => 'admin.orders.select', 'uses' => 'OrderController@selectOrder']);
    get('orders/activated/{user_id}', ['as' => 'admin.orders.activated', 'uses' => 'OrderController@activated']);
    get('orders/deactivated/{user_id}', ['as' => 'admin.orders.deactivated', 'uses' => 'OrderController@deactivated']);
    put('orders/cart_recovery/{id}', ['as' => 'admin.orders.cart_recovery', 'uses' => 'OrderController@cartRecovery']);

});
