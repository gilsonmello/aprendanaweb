<?php

Route::get('/_debugbar/assets/stylesheets', [
    'as' => 'debugbar-css',
    'uses' => '\Barryvdh\Debugbar\Controllers\AssetController@css'
]);

Route::get('/_debugbar/assets/javascript', [
    'as' => 'debugbar-js',
    'uses' => '\Barryvdh\Debugbar\Controllers\AssetController@js'
]);

Route::get('/_debugbar/open', [
    'as' => 'debugbar-open',
    'uses' => '\Barryvdh\Debugbar\Controllers\OpenController@handler'
]);
/**
 * Backend Routes
 * Namespaces indicate folder structure
 */
Route::group(['namespace' => 'Backend'], function () {

    Route::group(['prefix' => 'admin'], function() {
        require(__DIR__ . "/Routes/Backend/AdminAuth.php");
    });







    Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function () {
        get('survey1', ['as' => 'admin.survey1', 'uses' => 'SurveyController@survey1']);

        /**
         * These routes need the Administrador Role
         * or the view-backend permission (good if you want to allow more than one group in the backend, then limit the backend features by different roles or permissions)
         *
         * If you wanted to do this in the controller it would be:
         * $this->middleware('access.routeNeedsRoleOrPermission:{role:Administrador,permission:view_backend,redirect:/,with:flash_danger|You do not have access to do that.}');
         *
         * You could also do the above in the Route::group below and remove the other parameters, but I think this is easier to read here.
         * Note: If you have both, the controller will take precedence.
         */
        Route::group([
            'middleware' => 'access.routeNeedsRoleOrPermission',
            'role' => ['Administrador'],
            'permission' => ['view_backend'],
            'redirect' => '/admin/auth/login',
            'with' => ['flash_danger', 'You do not have access to do that.']
                ], function () {
            get('/{adminpath?}', ['as' => 'backend.dashboard', 'uses' => 'DashboardController@index'])->where('adminpath', '(dashboard)?');
            require(__DIR__ . "/Routes/Backend/Access.php");
        });


        /**
         * Articles Routes
         */
        require(__DIR__ . "/Routes/Backend/Articles.php");

        /**
         * Faq_category Routes
         */
        require(__DIR__ . "/Routes/Backend/Faqcategory.php");

        /**
         * Coupons Routes
         */
        require(__DIR__ . "/Routes/Backend/Coupons.php");

        /**
         * Courses Routes
         */
        require(__DIR__ . "/Routes/Backend/Courses.php");


        /**
         * Modules Routes
         */
        require(__DIR__ . "/Routes/Backend/Modules.php");

        /**
         * Lessons Routes
         */
        require(__DIR__ . "/Routes/Backend/Lessons.php");

        /**
         * Videos Routes
         */
        require(__DIR__ . "/Routes/Backend/Videos.php");
        /**
         * Faqs Routes
         */
        require(__DIR__ . "/Routes/Backend/Faqs.php");
        require(__DIR__ . "/Routes/Backend/Sections.php");

        /**
         * Subsections Routes
         */
        require(__DIR__ . "/Routes/Backend/Subsections.php");


        /**
         * Newsletters Routes
         */
        require(__DIR__ . "/Routes/Backend/Newsletters.php");
        /**
         * Cities Routes
         */
        require(__DIR__ . "/Routes/Backend/Cities.php");



        /**
         * Tags Routes
         */
        require(__DIR__ . "/Routes/Backend/Tags.php");

        /**
         * UserStudent Routes
         */
        require(__DIR__ . "/Routes/Backend/UserStudents.php");
        /**
         * UserRepresentative Routes
         */
        require(__DIR__ . "/Routes/Backend/UserRepresentatives.php");
        /**
         * UserTeacher Routes
         */
        require(__DIR__ . "/Routes/Backend/UserTeachers.php");

        /**
         * Content_Comments Routes
         */
        require(__DIR__ . "/Routes/Backend/ContentComments.php");

        /**
         * UserTeacher Routes
         */
        require(__DIR__ . "/Routes/Backend/Configurations.php");

        /**
         * TeacherStatement Routes
         */
        require(__DIR__ . "/Routes/Backend/TeacherStatements.php");

        /**
         * Sectors Routes
         */
        require(__DIR__ . "/Routes/Backend/Sectors.php");
        /**
         * Ticket Routes
         */
        require(__DIR__ . "/Routes/Backend/Tickets.php");

        /**
         * Order Routes
         */
        require(__DIR__ . "/Routes/Backend/Orders.php");

        /**
         * Order ProcessTeacherStatements
         */
        require(__DIR__ . "/Routes/Backend/ProcessTeacherStatements.php");

        /**
         * Order Stats
         */
        require(__DIR__ . "/Routes/Backend/Stats.php");

        /**
         * Course Reports
         */
        require(__DIR__ . "/Routes/Backend/CourseReports.php");

        /**
         * TeacherPayment Reports
         */
        require(__DIR__ . "/Routes/Backend/TeacherPaymentReports.php");

        /**
         * Sliders
         */
        require(__DIR__ . "/Routes/Backend/Sliders.php");

        /**
         * Student Reports
         */
        require(__DIR__ . "/Routes/Backend/StudentReports.php");

        /**
         * News
         */
        require(__DIR__ . "/Routes/Backend/News.php");

        /**
         * General Discount
         */
        require(__DIR__ . "/Routes/Backend/GeneralDiscount.php");

        /**
         * Courses Alerts
         */
        require(__DIR__ . "/Routes/Backend/CoursesAlerts.php");

        /**
         * Courses Calendars
         */
        require(__DIR__ . "/Routes/Backend/CoursesCalendars.php");

        /**
         * Ask The teacher
         */
        require(__DIR__ . "/Routes/Backend/AskTheTeachers.php");

        /**
         * Source
         */
        require(__DIR__ . "/Routes/Backend/Sources.php");

        /**
         * Institution
         */
        require(__DIR__ . "/Routes/Backend/Institutions.php");

        /**
         * Offices
         */
        require(__DIR__ . "/Routes/Backend/Offices.php");

        /**
         * Subjects
         */
        require(__DIR__ . "/Routes/Backend/Subjects.php");

        /**
         * Questions
         */
        require(__DIR__ . "/Routes/Backend/Questions.php");

        /**
         * Exams
         */
        require(__DIR__ . "/Routes/Backend/Exams.php");

        /**
         * Packages
         */
        require(__DIR__ . "/Routes/Backend/Packages.php");

        /**
         * Banners
         */
        require(__DIR__ . "/Routes/Backend/Banners.php");

        /**
         * Webinars
         */
        require(__DIR__ . "/Routes/Backend/Webinars.php");

        /**
         * Partners
         */
        require(__DIR__ . "/Routes/Backend/Partners.php");

        /**
         * Partnerorders
         */
        require(__DIR__ . "/Routes/Backend/Partnerorders.php");

        /**
         * Partnerorders
         */
        require(__DIR__ . "/Routes/Backend/Studentgroups.php");

        /**
         * Preenrollments
         */
        require(__DIR__ . "/Routes/Backend/Preenrollments.php");

        /**
         * Enrollments
         */
        require(__DIR__ . "/Routes/Backend/Enrollments.php");

        /**
         * Partners
         */
        require(__DIR__ . "/Routes/Backend/Advertisingpartners.php");

        /**
         * Occupations
         */
        require(__DIR__ . "/Routes/Backend/Occupations.php");


        /**
         * Workshops
         */
        require(__DIR__ . "/Routes/Backend/Workshops.php");

        /**
         * WorkshopActivitys
         */
        require(__DIR__ . "/Routes/Backend/WorkshopActivitys.php");

        /**
         * WorkshopCriterias
         */
        require(__DIR__ . "/Routes/Backend/WorkshopCriterias.php");

        /**
         * WorkshopTutors
         */
        require(__DIR__ . "/Routes/Backend/WorkshopTutors.php");

        /**
         * WorkshopEvaluationGroups
         */
        require(__DIR__ . "/Routes/Backend/WorkshopEvaluationGroups.php");

        /**
         * WorkshopGroupTutors
         */
        require(__DIR__ . "/Routes/Backend/WorkshopGroupTutors.php");


        /**
         * MyWorkshopActivitys
         */
        require(__DIR__ . "/Routes/Backend/MyWorkshopActivitys.php");

        /**
         * MyWorkshopEvaluations
         */
        require(__DIR__ . "/Routes/Backend/MyWorkshopEvaluations.php");

        /**
         * MyWorkshopTutors
         */
        require(__DIR__ . "/Routes/Backend/MyWorkshopTutors.php");

        /**
         * AnalysisExamGroups
         */
        require(__DIR__ . "/Routes/Backend/AnalysisExamGroups.php");

        /**
         * Analysiss
         */
        require(__DIR__ . "/Routes/Backend/Analysiss.php");

        /**
         * PartnerManager
         */
        require(__DIR__ . "/Routes/Backend/PartnerManager.php");
        /**
         * AnalysisExams
         */
        require(__DIR__ . "/Routes/Backend/AnalysisExams.php");

        /**
         * WorkshopCoordinator
         */
        require(__DIR__ . "/Routes/Backend/WorkshopCoordinators.php");

        /**
         * Suppliers
         */
        require(__DIR__ . "/Routes/Backend/Suppliers.php");

        /**
         * Products
         */
        require(__DIR__ . "/Routes/Backend/Products.php");

        /**
         * RepresentativeCommission
         */
        require(__DIR__ . "/Routes/Backend/RepresentativeCommissions.php");

    });
});



/**
 * Frontend Routes
 * Namespaces indicate folder structure
 */
Route::group(['namespace' => 'Frontend', 'middleware' => ['origin_external', 'track_cart', 'mailing_register']], function () {
    require(__DIR__ . "/Routes/Frontend/PublicSector.php");
    require(__DIR__ . "/Routes/Frontend/Compliance.php");
    require(__DIR__ . "/Routes/Frontend/Frontend.php");
    require(__DIR__ . "/Routes/Frontend/Access.php");
    require(__DIR__ . "/Routes/Frontend/Cart.php");

    /**
     * NOVO SITE 2017
     */
    Route::group(['prefix' => '2017', 'middleware' => 'auth'], function() {
        require(__DIR__ . "/Routes/Frontend/Frontend_2017.php");
    });



    // Catch all names in root and check if is a course
    Route::get('{section?}/{slug}/{tag?}', [
        'as' => 'course-section',
        'uses' => 'FrontendController@getCourseOrSection'
    ])->where('slug', '([A-Za-z0-9\-\(\)\.\–]+)');

    /* COMENTADO PORQUE ESTAVA GERANDO DEFEITOS EM ÁREAS INTERNAS DO SISTEMA POR JEFERSON 31/01/2017 */
//        // Catch all names in root and check if is a course
//    Route::get('{section?}', [
//        'as' => 'course-section_only',
//        'uses' => 'FrontendController@getCourseOrSection'
//    ])->where('slug', '([A-Za-z0-9\-\(\)\.\–]+)');
});
