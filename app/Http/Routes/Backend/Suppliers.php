<?php

Route::group([
    'middleware' => 'access.routeNeedsPermission',
    'permission' => ['suppliers'],
    'redirect' => '/',
    'with' => ['flash_danger', 'You do not have access to do that.']
        ], function() {
    resource('suppliers', 'SupplierController', ['except' => ['show']]);
});
