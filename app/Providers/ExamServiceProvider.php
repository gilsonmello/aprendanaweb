<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * Class EnrollmentServiceProvider
 * @package App\Providers
 */
class ExamServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerBindings();
    }

    /**
     * Register service provider bindings
     */
    public function registerBindings() {

        $this->app->bind(
            'App\Repositories\Backend\Exam\ExamContract',
            'App\Repositories\Backend\Exam\EloquentExamRepository'
        );

        $this->app->bind(
            'App\Repositories\Backend\Group\GroupContract',
            'App\Repositories\Backend\Group\EloquentGroupRepository'
        );

        $this->app->bind(
            'App\Repositories\Backend\GroupQuestion\GroupQuestionContract',
            'App\Repositories\Backend\GroupQuestion\EloquentGroupQuestionRepository'
        );

        $this->app->bind(
            'App\Repositories\Backend\ExamCourse\ExamCourseContract',
            'App\Repositories\Backend\ExamCourse\EloquentExamCourseRepository'
        );


        $this->app->bind(
            'App\Repositories\Frontend\Exam\ExamContract',
            'App\Repositories\Frontend\Exam\EloquentExamRepository'
        );

        $this->app->bind(
            'App\Repositories\Frontend\Question\QuestionContract',
            'App\Repositories\Frontend\Question\EloquentQuestionRepository'
        );

        $this->app->bind(
            'App\Repositories\Frontend\Execution\ExecutionContract',
            'App\Repositories\Frontend\Execution\EloquentExecutionRepository'
        );

        $this->app->bind(
            'App\Repositories\Frontend\QuestionsExecution\QuestionsExecutionContract',
            'App\Repositories\Frontend\QuestionsExecution\EloquentQuestionsExecutionRepository'
        );

        $this->app->bind(
            'App\Repositories\Frontend\AnswersExecution\AnswersExecutionContract',
            'App\Repositories\Frontend\AnswersExecution\EloquentAnswersExecutionRepository'
        );

        $this->app->bind(
            'App\Repositories\Frontend\Subject\SubjectContract',
            'App\Repositories\Frontend\Subject\EloquentSubjectRepository'
        );
    }
}