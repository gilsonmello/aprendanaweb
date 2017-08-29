<?php

Route::group([
    'middleware' => 'access.routeNeedsPermission',
    'permission' => ['workshops'],
    'redirect'   => '/',
    'with'       => ['flash_danger', 'You do not have access to do that.']
], function ()
{


    resource('workshopgrouptutors', 'WorkshopGroupTutorController', ['except' => ['show']]);

});