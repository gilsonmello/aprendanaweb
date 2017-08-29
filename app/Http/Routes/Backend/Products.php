<?php

Route::group([
    'middleware' => 'access.routeNeedsPermission',
    'permission' => ['products'],
    'redirect' => '/',
    'with' => ['flash_danger', 'You do not have access to do that.']
        ], function() {
        resource('products', 'ProductController', ['except' => ['show']]);
});
