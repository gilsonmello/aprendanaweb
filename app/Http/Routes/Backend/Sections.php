<?php

Route::group([
    'middleware' => 'access.routeNeedsPermission',
    'permission' => ['sections'],
    'redirect'   => '/',
    'with'       => ['flash_danger', 'You do not have access to do that.']
], function ()
{


    resource('sections', 'SectionController', ['except' => ['show']]);

});