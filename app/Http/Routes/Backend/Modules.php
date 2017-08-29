<?php

Route::group([
    'middleware' => 'access.routeNeedsPermission',
    'permission' => ['modules'],
    'redirect'   => '/',
    'with'       => ['flash_danger', 'You do not have access to do that.']
], function ()
{

    resource('modules', 'ModuleController', ['except' => ['show']]);

    post('modules/select', ['as' => 'admin.modules.select', 'uses' => 'ModuleController@selectModule']);

});