<?php

Route::group([
    'middleware' => 'access.routeNeedsPermission',
    'permission' => ['myworkshoptutors', 'workshops'],
    'redirect'   => '/',
    'with'       => ['flash_danger', 'You do not have access to do that.']
], function ()
{


    resource('myworkshoptutors', 'MyWorkshopTutorController', ['except' => ['show']]);

    get('myworkshoptutors/tutorsthestudents', ['as' => 'admin.myworkshoptutors.tutorsthestudents', 'uses' => 'MyWorkshopTutorController@tutorsTheStudents']);

    post('myworkshoptutors/store', ['as' => 'admin.myworkshoptutors.store', 'uses' => 'MyWorkshopTutorController@store']);

    post('tutor/select', ['as' => 'admin.myworkshoptutors.select', 'uses' => 'MyWorkshopTutorController@selectTutor']);
    post('criteria/select', ['as' => 'admin.myworkshoptutors.criteria', 'uses' => 'MyWorkshopTutorController@selectCriteria']);
    post('activity/select', ['as' => 'admin.myworkshoptutors.activity', 'uses' => 'MyWorkshopTutorController@selectActivity']);

});