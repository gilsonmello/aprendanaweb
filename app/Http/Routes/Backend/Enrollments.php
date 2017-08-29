<?php

Route::group([
    'middleware' => 'access.routeNeedsPermission',
    'permission' => ['enrollments'],
    'redirect'   => '/admin',
    'with'       => ['flash_danger', 'You do not have access to do that.']
], function ()
{

    resource('enrollments', 'EnrollmentController', ['except' => ['show']]);

    get('enrollments/enrollmentvscoupon', ['as' => 'admin.enrollment.enrollmentvscoupon', 'uses' => 'EnrollmentController@reportEnrollmentVsCoupon']);
    
    get('enrollments/releaseforcertification', ['as' => 'admin.enrollments.releaseforcertification', 'uses' => 'EnrollmentController@releaseForCertification']);
    
    post('enrollments/updatereleaseforcertification/{id}', ['as' => 'admin.enrollments.updatereleaseforcertification', 'uses' => 'EnrollmentController@updateReleaseForCertification']);

});