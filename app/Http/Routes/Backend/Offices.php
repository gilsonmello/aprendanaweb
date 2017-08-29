<?php

Route::group([
    'middleware' => 'access.routeNeedsPermission',
    'permission' => ['offices'],
    'redirect'   => '/',
    'with'       => ['flash_danger', 'You do not have access to do that.']
], function ()
{


    resource('offices', 'OfficeController', ['except' => ['show']]);

});