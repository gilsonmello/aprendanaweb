<?php

Route::group([
    'middleware' => 'access.routeNeedsPermission',
    'permission' => ['workshopevaluations'],
    'redirect'   => '/',
    'with'       => ['flash_danger', 'You do not have access to do that.']
], function ()
{


    resource('myworkshopevaluations', 'MyWorkshopEvaluationController', ['except' => ['show']]);

    post('myworkshopevaluations/updateTutor/{id}', ['as' => 'admin.myworkshopevaluations.updateTutor', 'uses' => 'MyWorkshopEvaluationController@updateTutor']);

    post('myworkshopevaluations/tutor/select', ['as' => 'admin.myworkshopevaluations.selecttutor', 'uses' => 'MyWorkshopEvaluationController@selectTutor']);
	
	get('myworkshopevaluations/activitiesreport', ['as' => 'admin.myworkshopevaluations.activitiesreport', 'uses' => 'MyWorkshopEvaluationController@activitiesReport']);

	

});