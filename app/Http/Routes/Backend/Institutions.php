<?php

Route::group([
    'middleware' => 'access.routeNeedsPermission',
    'permission' => ['institutions'],
    'redirect'   => '/',
    'with'       => ['flash_danger', 'You do not have access to do that.']
], function ()
{


    resource('institutions', 'InstitutionController', ['except' => ['show']]);

});