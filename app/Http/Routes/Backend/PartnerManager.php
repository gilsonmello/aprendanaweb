<?php

Route::group([
    'middleware' => 'access.routeNeedsPermission',
    'permission' => ['partnermanagers', 'accompaniment'],
    'redirect'   => '/',
    'with'       => ['flash_danger', 'You do not have access to do that.']
], function ()
{
    resource('partnermanagers', 'PartnerManagerController', ['except' => ['show']]);
    post('partnermanagers/create', 'PartnerManagerController@create');
    get('partnermanagers/accompaniment', [
    	'as' => 'admin.partnermanagers.accompaniment', 
    	'uses' => 'PartnerManagerController@accompaniment'
    ]);
    get('partnermanagers/executionsaap', [
        'as' => 'admin.partnermanagers.executionsaap', 
        'uses' => 'PartnerManagerController@executionsSaap'
    ]);
    get('partnermanagers/perfomancesaap', [
        'as' => 'admin.partnermanagers.perfomancesaap',
        'uses' => 'PartnerManagerController@performanceInSaap'
    ]);
});

