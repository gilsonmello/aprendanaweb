<?php

Route::group([
    'middleware' => 'access.routeNeedsPermission',
    'permission' => ['articles'],
    'redirect'   => '/',
    'with'       => ['flash_danger', 'You do not have access to do that.']
], function ()
{

    resource('articles', 'ArticleController', ['except' => ['show']]);


});