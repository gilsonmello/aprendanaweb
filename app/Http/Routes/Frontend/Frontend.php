<?php

/**
 * Frontend Controllers
 */
get('/', ['as' => 'home', 'uses' => 'FrontendController@index']);


//rota criada para teste de metodos localhost (ROTAS PARA TESTES)
////@todo ***************************************************************
get('courses/course_with_exams_agregated__','ClassroomController@test');
//************************************************************************



//get('/pagini', ['as' => 'home', 'uses' => 'FrontendController@index']);

get('livraria', 'BookStoreController@index');
get('book/{slug}', 'BookStoreController@show');


get('macros', 'FrontendController@macros');

get('crud', 'RunServicesController@crud');
get('trans', 'RunServicesController@trans');

//get('saaps', ['as' => 'packages.index', 'uses' => 'PackageController@index']);
get('simulados', ['as' => 'packages.index', 'uses' => 'PackageController@index']);
get('saaps/sobre', ['as' => 'packages.about', 'uses' => 'PackageController@about']);
//get('saaps/{slug}', ['as' => 'packages.show_old', 'uses' => 'PackageController@show']);
get('simulados/{slug}', ['as' => 'packages.show', 'uses' => 'PackageController@show']);

Route::get('metodologia-oab', ['as' => 'frontend.methodology-oab', 'uses' => function() {
    return Response::view('frontend/methodology/index-oab');
}]);

Route::get('metodologia-concursos', ['as' => 'frontend.methodology-concursos', 'uses' => function() {
    return Response::view('frontend/methodology/index-concursoss');
}]);

Route::get('etica-oab', ['as' => 'frontend.etica-oab', 'uses' => function() {
    return Response::view('frontend/landingpages/etica_e_oab');
}]);

Route::get('etica-oab-aula', ['as' => 'frontend.etica-oab-aula', 'uses' => function() {
    return Response::view('frontend/landingpages/etica_e_oab');
}]);

post('subscribe-ebook-oab-e-etica', ['as' => 'landingpage.oab-e-etica', 'uses' => 'NewsletterController@subscribeCampaignEbookOabEtica']);
get('etica-oab/enviado', [
    'as' => 'landingpage.success-subscribed-ebook-oab-e-etica',
    'uses' => 'NewsletterController@successSubscribedEbookOabEtica'
]);

/*
  //Produtos Descontinuados
  get('passaporte-oab',['as' => 'passaporteoab', 'uses' => 'FrontendController@passaporteOab']);
  get('oab-sem-parar', ['as' => 'packages.oab-sem-parar', 'uses' => 'PackageController@oabSemParar']);
  get('exame-oab', ['as' => 'exameoab', 'uses' => 'FrontendController@exameOab']);
 */


get('analise360/sobre', ['as' => 'analysis.about', 'uses' => 'FrontendController@analysis']);

get('busca/', ['as' => 'search', 'uses' => 'SearchController@index']);
get('busca/json-tags-cursos', ['as' => 'json-tags-courses', 'uses' => 'SearchController@getJsonTagsAndCourses']);

get('cursos', ['as' => 'courses', 'uses' => 'CourseController@index']);
get('cursos/lancamentos', ['as' => 'courses-releases', 'uses' => 'CourseController@getReleases']);
get('cursos/promocoes', ['as' => 'courses-special-offers', 'uses' => 'CourseController@getSpecialOffers']);
get('cursos/recomendados', ['as' => 'courses-recommended', 'uses' => 'CourseController@getRecommended']);
get('cursos/mais-vendidos', ['as' => 'courses-best-selling', 'uses' => 'CourseController@getBestSelling']);

get('preenrollment/{subscribe_key}', ['as' => 'preenrollment', 'uses' => 'CourseController@preenrollment']);
post('preenrollment/subscribe', ['as' => 'preenrollment.subscribe', 'uses' => 'CourseController@subscribe']);

get('artigos', ['as' => 'articles', 'uses' => 'ArticleController@index']);
get('artigos/{slug}', ['as' => 'articles.show', 'uses' => 'ArticleController@show']);

get('noticias', ['as' => 'news', 'uses' => 'NewsController@index']);
get('noticias/{slug}', ['as' => 'news.show', 'uses' => 'NewsController@show']);


get('professores', ['as' => 'teachers', 'uses' => 'UserTeacherController@index']);
get('professores/{id}', ['as' => 'teachers.show', 'uses' => 'UserTeacherController@show']);

//get('videos', ['as' => 'videos', 'uses' => 'VideoController@index']);
get('tv-videos', ['as' => 'tv-videos', 'uses' => 'VideoController@index']);
get('tv-videos/{slug}', ['as' => 'videos.show', 'uses' => 'VideoController@show']);

post('newsletters/subscribe', ['as' => 'newsletters.subscribe', 'uses' => 'NewsletterController@subscribe']);
post('newsletters/unsubscribe/', ['as' => 'newsletters.unsubscribe', 'uses' => 'NewsletterController@unsubscribe']);
Route::get('newsletters/unsubscribe', ['as' => 'unsubscribe', 'uses' => function() {
        return Response::view('frontend/newsletter/unsubscribe');
    }]);
//get('newsletters/unsubscribe/{slug}', ['as' => 'newsletters.unsubscribe', 'uses' => 'NewsletterController@show']);

get('coupon/request', ['as' => 'coupon.request', 'uses' => 'CouponController@request10percent']);

get('aulas/{id}', ['as' => 'lessons.show', 'uses' => 'LessonController@show']);

post('faleconosco/send', ['as' => 'contactus.show', 'uses' => 'ContactUsController@send']);
get('faleconosco', ['as' => 'contactus.index', 'uses' => 'ContactUsController@index']);


get('disciplinas/{id}', ['as' => 'modules.show', 'uses' => 'ModuleController@show']);

post('opentellafriend', ['as' => 'frontend.openTellAFriend', 'uses' => 'FrontendController@openTellAFriend']);

post('tellafriend', ['as' => 'frontend.tell-a-friend', 'uses' => 'FrontendController@sendToAFriend']);
//Route::group([
//    'redirect'   => '/',
//    'with'       => ['flash_danger', 'You do not have access to do that.']
//], function ()
//{
//    resource('tickets', 'TicketStudentController', ['except' => ['show']]);
//});

/**
 * These frontend controllers require the user to be logged in
 */
Route::group(['namespace' => 'Auth'], function () {
    get('endsession', ['as' => 'frontend.endSession', 'uses' => 'AuthController@endSession']);
    get('swap-session', ['as' => 'frontend.swapSession', 'uses' => 'AuthController@swapUserSession']);
});

Route::group(['middleware' => 'auth'], function () {
    get('dashboard', ['as' => 'frontend.dashboard', 'uses' => 'DashboardController@index']);
    post('planodeestudo', ['as' => 'frontend.initialize_study_plan', 'uses' => 'DashboardController@initializeStudyPlan']);
    get('meuscursos', ['as' => 'frontend.courses', 'uses' => 'DashboardController@courses']);
    get('meussaaps', ['as' => 'frontend.exams', 'uses' => 'DashboardController@exams']);
    get('performance-geral', ['as' => 'frontend.examGeneralPerformance', 'uses' => 'DashboardController@examGeneralPerformance']);
    post('performance-geral/disciplina', ['as' => 'frontend.disciplineGeneralPerformance', 'uses' => 'DashboardController@disciplineGeneralPerformance']);

    resource('student/ticketstudents', 'TicketStudentController', ['except' => ['show']]);

    get('student/asktheteacher', ['as' => 'student.asktheteacher', 'uses' => 'AskTheTeacherController@index']);

    post('student/ticketstudents/message/store', ['as' => 'student.ticketstudents.message.store', 'uses' => 'TicketStudentController@messageStore']);

    get('student/orders', ['as' => 'student.orders', 'uses' => 'OrderStudentController@index']);

    resource('profile', 'ProfileController', ['only' => ['edit', 'update']]);
    post('profile/occupation', ['as' => 'frontend.profile.occupation', 'uses' => 'ProfileController@updateOccupation']);
    post('profile/dont_answer_survey', ['as' => 'frontend.profile.dont_answer_survey', 'uses' => 'ProfileController@dontAnswerSurvey']);
    post('profile/answer_survey', ['as' => 'frontend.profile.answer_survey', 'uses' => 'ProfileController@answerSurvey']);

    post('notification/read-notification', ['as' => 'frontend.readNotification', 'uses' => 'NotificationController@readNotification']);

    post('dashboard/progress', ['as' => 'frontend.accessHistory', 'uses' => 'DashboardController@accessHistory']);

    post('classroom/get-video-block', ['as' => 'frontend.getVideoBlock', 'uses' => 'ClassroomController@getVideoBlock']);
    post('classroom/save-notes', ['as' => 'frontend.saveNotes', 'uses' => 'ClassroomController@saveNotes']);
    post('/classroom/save-watched-time', ['as' => 'frontend.saveViewTime', 'uses' => 'ClassroomController@saveViewTime']);
    post('classroom/remove-notes', ['as' => 'frontend.deleteNotes', 'uses' => 'ClassroomController@deleteNotes']);

    post('classroom/get-video-notes', ['as' => 'frontend.getNotes', 'uses' => 'ClassroomController@getNotes']);
    post('classroom/get-video-comments', ['as' => 'frontend.getComments', 'uses' => 'ClassroomController@getComments']);
    get('classroomx/post-video-comment', ['as' => 'frontend.postComment', 'uses' => 'ClassroomController@postComment']);

    post('classroom/save-state', ['as' => 'frontend.saveState', 'uses' => 'ClassroomController@saveState']);
    post('classroom/save-like', ['as' => 'frontend.saveLike', 'uses' => 'ClassroomController@saveLike']);
    post('classroom/get-view', ['as' => 'frontend.getView', 'uses' => 'ClassroomController@getView']);
    post('classroom/save-rating', ['as' => 'frontend.saveRating', 'uses' => 'ClassroomController@saveEnrollmentRating']);
    post('classroom/needs-rating', ['as' => 'frontend.needsRating', 'uses' => 'ClassroomController@needsRating']);
    post('classroom/course-content', ['as' => 'frontend.courseContent', 'uses' => 'ClassroomController@courseContent']);
    post('classroom/course-alerts', ['as' => 'frontend.courseAlerts', 'uses' => 'ClassroomController@courseAlerts']);
    post('classroom/course-calendar', ['as' => 'frontend.courseCalendar', 'uses' => 'ClassroomController@courseCalendar']);
    post('classroom/course-modules', ['as' => 'frontend.courseModules', 'uses' => 'ClassroomController@courseModules']);
    post('classroom/save-ask-the-teacher', ['as' => 'frontend.saveAskTheTeacher', 'uses' => 'ClassroomController@saveAskTheTeacher']);
    post('classroom/open-ticket', ['as' => 'frontend.openTicket', 'uses' => 'ClassroomController@openTicket']);


    post('classroom/course-terms', ['as' => 'frontend.courseTerms', 'uses' => 'ClassroomController@courseTerms']);
    get('classroom/certificate/{enrollment}', ['as' => 'frontend.classroom.certificate', 'uses' => 'ClassroomController@certificate']);
    get('classroom/export-notes/{enrollment}', ['as' => 'frontend.classroom.export-notes', 'uses' => 'ClassroomController@exportNotes']);
    get('classroom/export-protocol/{workshop_activity}', ['as' => 'frontend.classroom.export-workshop-protocol', 'uses' => 'ClassroomController@exportWorkshopDeliveryProtocol']);
    get('classroom/analysis/{enrollment}', ['as' => 'frontend.classroom.analysis', 'uses' => 'ClassroomController@analysis']);
    post('classroom/classroom-exam', ['as' => 'frontend.getLessonExam', 'uses' => 'ClassroomController@getLessonExam']);

    get('classroom/course/{enrollment_id}/{default_pill?}', ['as' => 'frontend.classroom.course', 'uses' => 'ClassroomController@course']);
    get('classroom/workshops/{enrollment_id}/{workshop_id}', ['as' => 'frontend.classroom.workshops', 'uses' => 'ClassroomController@workshops']);

    get('classroom/workshops/{enrollment_id}/{workshop_id}/{activity_id}', ['as' => 'frontend.classroom.activity', 'uses' => 'ClassroomController@activity']);

    post('classroom/workshops/upload-activity/', ['as' => 'frontend.classroom.upload-activity', 'uses' => 'ClassroomController@uploadActivity']);
    post('classroom/workshops/save-or-update-time', ['as' => 'frontend.classroom.save-time-workshop', 'uses' => 'ClassroomController@saveOrCreateWorkshopActivityTime']);
    get('classroom/{modules}/{lesson}', ['as' => 'frontend.classroom', 'uses' => 'ClassroomController@indexModule']);
    get('classroom/{courses}/{modules}/{lesson}/{content?}/{enrollment?}', ['as' => 'frontend.classroom', 'uses' => 'ClassroomController@indexCourse']);

    post('classroom/workshop/save-ask-the-tutor', ['as' => 'frontend.saveAskTheTutor', 'uses' => 'ClassroomController@saveAskTheTutor']);

    post('exam/end-time', ['as' => 'frontend.exam.endTime', 'uses' => 'ExamController@endTime']);
    post('result/rating-comment', ['as' => 'frontend.exam.saveCommentRating', 'uses' => 'ExamController@saveComment']);

    post('exam/save-question-time', ['as' => 'frontend.exam.save-question-time', 'uses' => 'ExamController@saveQuestionTime']);
    post('exam/save-current-time', ['as' => 'frontend.exam.save-current-time', 'uses' => 'ExamController@saveCurrentTime']);
    post('exam/performance', ['as' => 'frontend.exam.performance', 'uses' => 'ExamController@performance']);
    post('exam/subject-recommendation', ['as' => 'frontend.exam.subjectRecommendation', 'uses' => 'ExamController@subjectRecommendation']);
    post('exam/question-explanation', ['as' => 'frontend.exam.questionExplanation', 'uses' => 'ExamController@questionExplanation']);
    get('exam/statistics', ['as' => 'frontend.exam.statistics', 'uses' => 'ExamController@statistics']);

    get('exam/intro/{id}', ['as' => 'frontend.examIntro', 'uses' => 'ExamController@intro']);
    get('exam/result/{id}', ['as' => 'frontend.completeResults', 'uses' => 'ExamController@completeResults']);

    post('exam/get-right-answers', ['as' => 'frontend.exam.getRightAnswers', 'uses' => 'ExamController@getRightAnswers']);
    post('exam/get-explanation-url', ['as' => 'frontend.exam.getExplanationUrl', 'uses' => 'ExamController@getExplanationURL']);
    post('exam/get-next-question', ['as' => 'frontend.exam.nextQuestion', 'uses' => 'ExamController@nextQuestion']);
    post('exam/get-prev-question', ['as' => 'frontend.exam.prevQuestion', 'uses' => 'ExamController@prevQuestion']);
    post('exam/get-next-question-with-answered', ['as' => 'frontend.exam.nextQuestionWithAnswered', 'uses' => 'ExamController@nextQuestionWithAlreadyAnswered']);
    post('exam/increment-explanation-view', ['as' => 'frontend.exam.incrementExplanationView', 'uses' => 'ExamController@incrementExplanationView']);
    post('exam/get-question', ['as' => 'frontend.exam.question', 'uses' => 'ExamController@specificQuestion']);
    post('exam/save-user-answer', ['as' => 'frontend.exam.saveAnswer', 'uses' => 'ExamController@saveAnswer']);
    post('exam/save-user-note', ['as' => 'frontend.exam.saveNote', 'uses' => 'ExamController@saveNote']);
    post('exam/question-note', ['as' => 'frontend.questionNote', 'uses' => 'ExamController@questionNote']);
    post('exam/save-ask-the-teacher', ['as' => 'frontend.exam.saveAskTheTeacher', 'uses' => 'ExamController@saveAskTheTeacher']);
    post('exam/questions-not-answered', ['as' => 'frontend.questionsNotAnswered', 'uses' => 'ExamController@questionsList']);
    get('exam/export-notes/{enrollment}', ['as' => 'frontend.exam.export-notes', 'uses' => 'ExamController@exportNotes']);
    get('exam/final/{enrollment}', ['as' => 'frontend.final.exam', 'uses' => 'ExamController@finalExam']);
    get('exam/{id}/{simulation?}', ['as' => 'frontend.exam', 'uses' => 'ExamController@index']);
    post('exam/exam-note', ['as' => 'frontend.examNote', 'uses' => 'ExamController@examNote']);
    post('exam/add-item', ['as' => 'frontend.addItem', 'uses' => 'CartController@add_only']);
    post('exam/save-rating', ['as' => 'frontend.saveRating', 'uses' => 'ExamController@saveRating']);
    post('exam/save-teacher-rating', ['as' => 'frontend.teacherRating', 'uses' => 'ExamController@createTeacherRating']);
    post('exam/finish-exam', ['as' => 'frontend.finish-exam', 'uses' => 'ExamController@endTime']);
    post('exam/get-course-suggestion', ['as' => 'frontend.getCourseSuggestion', 'uses' => 'ExamController@getCourseSuggestion']);

    get('360/{id}/{type?}', ['as' => 'frontend.analysis', 'uses' => 'AnalysisController@show']);
    get('base/search/', ['as' => 'frontend.knowledge-search', 'uses' => 'KnowledgeController@search']);
    get('base/{id?}/{type?}', ['as' => 'frontend.knowledge', 'uses' => 'KnowledgeController@show']);

    get('classroom/tutorial/', ['as' => 'frontend.classroom.tutorial', 'uses' => 'ClassroomController@tutorial']);
    get('classroom/manual/', ['as' => 'frontend.classroom.manual', 'uses' => 'ClassroomController@manual']);
});

get('faqs', ['as' => 'faqs', 'uses' => 'FaqController@index']);

get('cursos/{section}/{id?}', ['as' => 'course', 'uses' => 'FrontendController@course']);
get('cursinhos/{section_id?}/{id?}', ['as' => 'course-section-ga', 'uses' => 'FrontendController@course']);

//get('concursos/', ['as' => '', 'uses' => 'FrontendController@index']);
//get('concursos/', ['as' => '', 'uses' => 'FrontendController@index']);
//get('concursos/', ['as' => '', 'uses' => 'FrontendController@index']);

Route::get('brasil-juridico', ['as' => 'brasil-juridico', 'uses' => function() {
        return Response::view('frontend/institutional/index');
    }]);

Route::get('termos-de-uso', ['as' => 'termos-de-uso', 'uses' => function() {
        return Response::view('frontend/institutional/terms');
    }]);
