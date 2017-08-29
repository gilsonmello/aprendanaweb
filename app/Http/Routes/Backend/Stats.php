<?php

Route::group([
    'middleware' => 'access.routeNeedsPermission',
    'permission' => ['stats'],
    'redirect'   => '/',
    'with'       => ['flash_danger', 'You do not have access to do that.']
], function ()
{

    resource('stats', 'StatsController', ['except' => ['show']]);

    get('stats/videos', ['as' => 'admin.stats.videos', 'uses' => 'StatsController@videos']);
    get('stats/articles', ['as' => 'admin.stats.articles', 'uses' => 'StatsController@articles']);
    get('stats/coursesrank', ['as' => 'admin.stats.coursesrank', 'uses' => 'StatsController@coursesrank']);
    get('stats/coursessales', ['as' => 'admin.stats.coursessales', 'uses' => 'StatsController@coursessales']);


});