<?php

namespace App\Console;

use App\Http\Controllers\Backend\TeacherStatementController;
use App\Repositories\Backend\Notification\EloquentNotificationRepository;
use App\Repositories\Backend\PartnerorderPayment\EloquentPartnerorderPaymentRepository;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Repositories\Backend\Configuration\EloquentConfigurationRepository;
use App\Repositories\Backend\User\EloquentUserRepository;
use App\Repositories\Backend\CourseTeacher\EloquentCourseTeacherRepository;
use App\Repositories\Backend\Order\EloquentOrderRepository;
use App\Repositories\Backend\OrderCourse\EloquentOrderCourseRepository;
use App\Repositories\Backend\OrderLesson\EloquentOrderLessonRepository;
use App\Repositories\Backend\OrderModule\EloquentOrderModuleRepository;
use App\Repositories\Backend\TeacherStatement\EloquentTeacherStatementRepository;
use App\Repositories\Backend\tag\EloquentTagRepository;
use DB;
use App\Repositories\Backend\User\EloquentUserStudentRepository;
use App\Repositories\Backend\PackageTeacher\EloquentPackageTeacherRepository;
use App\Repositories\Backend\OrderPackage\EloquentOrderPackageRepository;
use App\Repositories\Backend\WorkshopActivity\EloquentWorkshopActivityRepository;
use App\Repositories\Backend\CourseCalendar\EloquentCourseCalendarRepository;
use App\Repositories\Backend\CourseCalendar\CourseCalendarContract;

class Kernel extends ConsoleKernel {

    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
            //'App\Console\Commands\Inspire',
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule) {
        //$schedule->command('inspire')->hourly();
        //Processamento do pagamento do Professor
        $schedule->call(function() {

                    $teacherStatementController = new TeacherStatementController(
                            new EloquentTeacherStatementRepository(), new EloquentOrderRepository(), new EloquentOrderCourseRepository(), new EloquentOrderModuleRepository(), new EloquentOrderLessonRepository(), new EloquentCourseTeacherRepository(), new EloquentConfigurationRepository(), new EloquentOrderPackageRepository(), new EloquentPackageTeacherRepository(), new EloquentPartnerorderPaymentRepository()
                    );
                    $teacherStatementController->processToday();
                })->dailyAt('00:00')
                ->name('process_teacher_payment')
                ->withoutOverlapping();

        //Processo para limpar notificações da área do aluno
        $schedule->call(function() {
                    $notification = new EloquentNotificationRepository();
                    $notification->remove_by_time(30, '0');
                    $notification->remove_by_time(7, 1);
                })->everyFiveMinutes()
                ->name('process_notification_clean')
                ->withoutOverlapping();

        //Processo para enviar por e-mail as notificações de calendário de curso para os alunos
        $schedule->call(function(EloquentCourseCalendarRepository $courseCalendar){
            //Enviando e-mail para os alunos todo dia ás 00:00:00(meia noite)
            $courseCalendar->getAndSendNotificationsCalendarCourse();
        })->dailyAt('00:00');

        //Processo para deletar os pedidos de usuários feito pelo brasil jurídico
        $schedule->call(function(EloquentOrderRepository $order){
            $order->deleteOrdersBrasilJuridico();
        })->dailyAt('00:00');

        /* $schedule->call(
          function(EloquentUserStudentRepository $user){
          $user->sendEmail($user->birthday());
          })->everyMinute(); */
    }

}
