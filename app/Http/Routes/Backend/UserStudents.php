<?php

Route::group([
    'middleware' => 'access.routeNeedsPermission',
    'permission' => ['userstudents'],
    'redirect'   => '/',
    'with'       => ['flash_danger', 'You do not have access to do that.']
], function ()
{
    resource('userstudents', 'UserStudentController', ['except' => ['show']]);

    post('students/select', ['as' => 'admin.students.select', 'uses' => 'UserStudentController@selectStudent']);

    /* Specific User */
    Route::group(['prefix' => 'user/{id}', 'where' => ['id' => '[0-9]+']], function () {
        get('password/change', ['as' => 'admin.userstudents.change-password', 'uses' => 'UserStudentController@changePassword']);
        post('password/change', ['as' => 'admin.userstudents.change-password', 'uses' => 'UserStudentController@updatePassword']);
    });

    get('userstudents/{enrollment_id}/{lesson_id}/accessOfLesson', ['as' => 'admin.userstudents.lessons-log', 'uses' => 'UserStudentController@logOfLessonAccess']);
    get('userstudents/{student_id}/{course_id}/access', ['as' => 'admin.userstudents.log', 'uses' => 'UserStudentController@logOfAccess']);
    get('userstudents/{id}/enrollments', ['as' => 'admin.userstudents.enrollments', 'uses' => 'UserStudentController@enrollments']);
    get('userstudents/{id}/lessons/{enrollment_id}', ['as' => 'admin.userstudents.lessons', 'uses' => 'UserStudentController@lessons']);
    get('userstudents/{id}/lessons/{enrollment_id}/addview/{view}', ['as' => 'admin.userstudents.addview', 'uses' => 'UserStudentController@addView']);
    get('userstudents/{id}/lessons/{enrollment_id}/subtractview/{view}', ['as' => 'admin.userstudents.subtractview', 'uses' => 'UserStudentController@subtractView']);
    get('userstudents/{id}/lessons/{enrollment_id}/viewed/{view}', ['as' => 'admin.userstudents.viewed', 'uses' => 'UserStudentController@viewed']);
    get('userstudents/{id}/enrollment/activated/{enrollment_id}', ['as' => 'admin.userstudents.enrollment.activated', 'uses' => 'UserStudentController@activateEnrollment']);
    get('userstudents/{id}/enrollment/deactivated/{enrollment_id}', ['as' => 'admin.userstudents.enrollment.deactivated', 'uses' => 'UserStudentController@deactivateEnrollment']);
    get('userstudents/{id}/enrollment/addday/{enrollment_id}', ['as' => 'admin.userstudents.enrollment.addday', 'uses' => 'UserStudentController@addDayEnrollment']);
    get('userstudents/{id}/enrollment/addweek/{enrollment_id}', ['as' => 'admin.userstudents.enrollment.addweek', 'uses' => 'UserStudentController@addWeekEnrollment']);
    get('userstudents/{id}/enrollment/addmonth/{enrollment_id}', ['as' => 'admin.userstudents.enrollment.addmonth', 'uses' => 'UserStudentController@addMonthEnrollment']);

    get('userstudents/{id}/exams', ['as' => 'admin.userstudents.exams', 'uses' => 'UserStudentController@exams']);
    get('userstudents/{id}/enrollment/{enrollment_id}/addexecution/', ['as' => 'admin.userstudents.addexecution', 'uses' => 'UserStudentController@addExecution']);
    get('userstudents/{id}/enrollment/{enrollment_id}/subtractexecution/', ['as' => 'admin.userstudents.subtractexecution', 'uses' => 'UserStudentController@subtractExecution']);

    get('userstudents/{id}/orders', ['as' => 'admin.userstudents.orders', 'uses' => 'UserStudentController@orders']);
    get('userstudents/courseexternalpayment/{course_id}', ['as' => 'admin.userstudents.course_external_payment', 'uses' => 'UserStudentController@courseExternalPayment']);
    post('userstudents/courseexternalpayment/run', ['as' => 'admin.userstudents.course_external_payment_run', 'uses' => 'UserStudentController@courseExternalPaymentRun']);

    get('enrollments/index-test', ['as' => 'admin.enrollments.indextest', 'uses' => 'EnrollmentController@indexTest']);
    get('enrollments/create-test', ['as' => 'admin.enrollments.createtest', 'uses' => 'EnrollmentController@createTest']);
    post('enrollments/store-test', ['as' => 'admin.enrollments.storetest', 'uses' => 'EnrollmentController@storeTest']);

    get('enrollments/index-saapincourse', ['as' => 'admin.enrollments.indexsaapincourse', 'uses' => 'EnrollmentController@indexSaapInCourse']);
    get('enrollments/create-saapincourse', ['as' => 'admin.enrollments.createsaapincourse', 'uses' => 'EnrollmentController@createSaapInCourse']);
    post('enrollments/store-saapincourse', ['as' => 'admin.enrollments.storesaapincourse', 'uses' => 'EnrollmentController@storeSaapInCourse']);

});