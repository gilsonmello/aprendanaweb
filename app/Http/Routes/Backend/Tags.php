<?php

Route::group([
    'middleware' => 'access.routeNeedsPermission',
    'permission' => ['tags'],
    'redirect'   => '/',
    'with'       => ['flash_danger', 'You do not have access to do that.']
], function ()
{

    resource('tags', 'TagController', ['except' => ['show']]);
    post('tags/select', ['as' => 'admin.tags.select', 'uses' => 'TagController@selectTag']);

    get('tags/activated/{user_id}', ['as' => 'admin.tags.activated', 'uses' => 'TagController@activated']);
    get('tags/deactivated/{user_id}', ['as' => 'admin.tags.deactivated', 'uses' => 'TagController@deactivated']);


});