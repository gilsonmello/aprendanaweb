<?php

Route::group([
    'middleware' => 'access.routeNeedsPermission',
    'permission' => ['content_comments'],
    'redirect'   => '/',
    'with'       => ['flash_danger', 'You do not have access to do that.']
], function ()
{

    resource('contentcomments', 'ContentCommentsController', ['except' => ['show']]);

    get('contentcomments/activated/{user_id}', ['as' => 'admin.contentcomments.activated', 'uses' => 'ContentCommentsController@activated']);
    get('contentcomments/deactivated/{user_id}', ['as' => 'admin.contentcomments.deactivated', 'uses' => 'ContentCommentsController@deactivated']);


});