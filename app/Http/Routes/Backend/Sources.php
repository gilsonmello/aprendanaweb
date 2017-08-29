<?php

Route::group([
    'middleware' => 'access.routeNeedsPermission',
    'permission' => ['sources'],
    'redirect'   => '/',
    'with'       => ['flash_danger', 'You do not have access to do that.']
], function ()
{


    resource('sources', 'SourceController', ['except' => ['show']]);

});