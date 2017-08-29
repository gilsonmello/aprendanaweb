<?php

Route::group([
    'middleware' => 'access.routeNeedsPermission',
    'permission' => ['courses'],
    'redirect' => '/',
    'with' => ['flash_danger', 'You do not have access to do that.']
        ], function () {

    resource('courses', 'CourseController', ['except' => ['show']]);


    post('courses/create-group', ['as' => 'admin.courses.createGroup', 'uses' => 'CourseController@createLessonGroup']);
    post('courses/save-lesson-group', ['as' => 'admin.courses.saveGroup', 'uses' => 'CourseController@saveLessonGroup']);
    post('courses/create-course-group', ['as' => 'admin.courses.createCourseGroup', 'uses' => 'CourseController@createCourseGroup']);
    post('courses/save-course-group', ['as' => 'admin.courses.saveCourseGroup', 'uses' => 'CourseController@saveCourseGroup']);

    post('courses/totalSales', ['as' => 'admin.courses.totalSalesReport', 'uses' => 'GeneralReportController@totalSales']);
    get('courses/{id}/tabs', ['as' => 'admin.courses.tabs', 'uses' => 'CourseController@tabs']);
    post('courses/report', ['as' => 'admin.courses.report', 'uses' => 'GeneralReportController@sales']);
    post('courses/material', ['as' => 'admin.courses.material', 'uses' => 'CourseController@editlessonmaterial']);
    post('courses/savematerial', ['as' => 'admin.courses.savematerial', 'uses' => 'CourseController@savematerial']);
    post('courses/savecoursematerial', ['as' => 'admin.courses.savecoursematerial', 'uses' => 'CourseController@savecoursematerial']);
    post('courses/modules', ['as' => 'admin.courses.modules', 'uses' => 'CourseController@modules']);
    post('courses/{id}/lessons', ['as' => 'admin.courses.lessons', 'uses' => 'CourseController@lessons']);
    post('courses/{id}/datatables', ['as' => 'admin.courses.datatables', 'uses' => 'CourseController@datatables']);
    post('courses/addlessons', ['as' => 'admin.courses.addlessons', 'uses' => 'CourseController@addlessons']);
    post('courses/editlessons', ['as' => 'admin.courses.editlessons', 'uses' => 'CourseController@editlessons']);
    post('courses/editvideos', ['as' => 'admin.courses.editvideos', 'uses' => 'CourseController@editlessoncontent']);
    post('courses/updatevideos', ['as' => 'admin.courses.updatevideos', 'uses' => 'CourseController@updatelessoncontent']);
    post('courses/editteachers', ['as' => 'admin.courses.editteachers', 'uses' => 'CourseController@editteachers']);
    post('courses/editmodule', ['as' => 'admin.courses.editmodule', 'uses' => 'CourseController@editmodule']);
    post('courses/updateteachers', ['as' => 'admin.courses.updateteachers', 'uses' => 'CourseController@updateteachers']);
    post('courses/updatecourseteachers', ['as' => 'admin.courses.updatecourseteachers', 'uses' => 'CourseController@updatecourseteachers']);
    post('courses/maxsequence', ['as' => 'admin.courses.maxsequence', 'uses' => 'CourseController@maxsequence']);
    post('courses/updatemodule', ['as' => 'admin.courses.updatemodule', 'uses' => 'CourseController@updatemodule']);
    post('courses/updatelesson', ['as' => 'admin.courses.updatelesson', 'uses' => 'CourseController@updatelesson']);
    post('courses/remove-material', ['as' => 'admin.courses.removeMaterial', 'uses' => 'CourseController@removeMaterial']);
    post('courses/remove-course-material', ['as' => 'admin.courses.removeCourseMaterial', 'uses' => 'CourseController@removeCourseMaterial']);

    post('courses/totalizeTeachers', ['as' => 'admin.courses.totalizeTeachers', 'uses' => 'CourseController@totalizeTeachers']);
    
    post('courses/remove-lesson-teacher', ['as' => 'admin.courses.removeLessonTeacher', 'uses' => 'CourseController@removeLessonTeacher']);
    post('courses/remove-course-teacher', ['as' => 'admin.courses.removeCourseTeacher', 'uses' => 'CourseController@removeCourseTeacher']);

    post('courses/remove-module', ['as' => 'admin.courses.removeModule', 'uses' => 'CourseController@removeModule']);
    post('courses/remove-lesson', ['as' => 'admin.courses.removeLesson', 'uses' => 'CourseController@removeLesson']);


    post('courses/updatelessons', ['as' => 'admin.courses.updatelessons', 'uses' => 'CourseController@updatelessons']);
    post('courses/unblock', ['as' => 'admin.courses.unblock', 'uses' => 'CourseController@unblock']);
    post('courses/totalpercentage', ['as' => 'admin.courses.totalpercentage', 'uses' => 'CourseController@totalPercentageByCourse']);


    post('courses/select', ['as' => 'admin.courses.select', 'uses' => 'CourseController@selectCourse']);

    post('/courses/aggregate-course', ['as' => 'admin.courses.aggregate.store', 'uses' => 'CourseController@aggregateSaapToCourse']);
    get('/courses/aggregate-course/{id}', ['as' => 'admin.courses.aggregate.get', 'uses' => 'CourseController@getAggregateSaapToCourse']);
    delete('/courses/aggregate-course/{id}', ['as' => 'admin.courses.aggregate.delete', 'uses' => 'CourseController@deleteAggregateSaapToCourse']);

    get('/courses/clone/{id}', ['as' => 'admin.courses.clone', 'uses' => 'CourseController@cloneCourse']);

});
