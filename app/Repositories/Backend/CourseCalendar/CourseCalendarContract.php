<?php namespace App\Repositories\Backend\CourseCalendar;

/**
 * Interface UserContract
 * @package App\Repositories\CourseTeacher
 */
interface CourseCalendarContract {

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAlloursesCalendarsPerUser($order_by = 'id', $sort = 'asc') ;

    /**
     *
     * Função para enviar notificações de calendário dos cursos para os alunos
     * 
     **/
    public function getAndSendNotificationsCalendarCourse();

    /**
     * @param $id
     * @return mixed
     */
    public function findOrThrowException($id);



    public function getCoursesCalendarsPaginated($per_page, $course_id, $order_by = 'id', $sort = 'asc');

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAllCoursesCalendars($order_by = 'id', $sort = 'asc');

    public function getAllCoursesCalendarsPerCourse($course, $order_by = 'id', $sort = 'asc') ;
    /**
     * @param $input
     * @return mixed
     */
    public function create( $input );

    /**
     * @param $id
     * @param $input
     * @return mixed
     */
    public function update($id, $input);

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id);

}