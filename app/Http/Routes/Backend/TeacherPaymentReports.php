<?php

Route::group([
    'middleware' => 'access.routeNeedsPermission',
    'permission' => ['teacherpaymentreports'],
    'redirect'   => '/',
    'with'       => ['flash_danger', 'You do not have access to do that.']
], function ()
{


    get('teacherpaymentreports/index', ['as' => 'admin.teacherpaymentreports.index', 'uses' => 'TeacherPaymentReportController@index']);

});