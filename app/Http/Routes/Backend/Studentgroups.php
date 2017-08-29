<?php

Route::group([
    'middleware' => 'access.routeNeedsPermission',
    'permission' => ['studentgroups'],
    'redirect'   => '/',
    'with'       => ['flash_danger', 'You do not have access to do that.']
], function ()
{


    resource('studentgroups', 'StudentgroupController', ['except' => ['show']]);

});

