<?php

Route::group([
    'middleware' => 'access.routeNeedsPermission',
    'permission' => ['banners'],
    'redirect' => '/',
    'with' => ['flash_danger', 'You do not have access to do that.']
        ], function () {

    resource('webinars', 'WebinarController', ['except' => ['show']]);
    get('webinars', ['as' => 'admin.webinars', 'uses' => 'WebinarController@index']);
    get('webinars/index', ['as' => 'admin.webinars.index', 'uses' => 'WebinarController@index']);
    post('webinars/create', ['as' => 'admin.webinars.create', 'uses' => 'WebinarController@store']);

    get('webinars/users_course', ['as' => 'admin.webinars.users_course', 'uses' => 'WebinarController@usersCourse']);
});
