<?php

Route::group([
    'middleware' => 'access.routeNeedsPermission',
    'permission' => ['occupations'],
    'redirect'   => '/',
    'with'       => ['flash_danger', 'You do not have access to do that.']
], function ()
{


    resource('occupations', 'OccupationController', ['except' => ['show']]);

});