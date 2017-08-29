<?php

namespace App\Repositories\Frontend\Enrollment;

use App\Enrollment;
use App\Exceptions\GeneralException;
use App\Rating;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use App\Repositories\Frontend\Course\CourseContract;

/**
 * Class EloquentEnrollmentRepository
 * @package App\Repositories\Enrollment
 */
class EloquentEnrollmentRepository implements EnrollmentContract {

    public function __construct(CourseContract $course) {
        $this->course = $course;
    }

    public function find($enrollment_id) {
        return Enrollment::find($enrollment_id);
    }

    public function isStudentEnrolledCourse($student_id, $course_id) {
        return !$this->getStudentEnrollmentCourse($student_id, $course_id)->isEmpty();
    }

    public function isStudentEnrolledLesson($student_id, $lesson_id) {
        return !$this->getStudentEnrollmentLesson($student_id, $lesson_id)->isEmpty();
    }

    public function isStudentEnrolledModule($student_id, $module_id) {
        return !$this->getStudentEnrollmentModule($student_id, $module_id)->isEmpty();
    }

    public function getStudentEnrollmentModule($student_id, $module_id) {
        return Enrollment::where('student_id', $student_id)->where('module_id', $module_id)->get();
    }

    public function getStudentEnrollmentCourse($student_id, $course_id) {
        return Enrollment::where('student_id', $student_id)->where('course_id', $course_id)->get();
    }

    public function getStudentEnrollmentLesson($student_id, $lesson_id) {
        return Enrollment::where('student_id', $student_id)->where('lesson_id', $lesson_id)->get();
    }

    public function getEnrollmentByContentStudent($content_id, $student_id) {
        return Enrollment::where('student_id', $student_id)->where('content_id', $content_id)->where('is_active', 1)->get()->first();
    }

    public function getAllStudentEnrollmentsByStatus($student_id, $ongoing) {
        if ($ongoing == false) {
            return Enrollment::where('student_id', $student_id)
                            ->orderBy('date_end', 'asc')
                            ->where('date_end', '<', Carbon::today())
                            ->where('exam_id', null)
                            ->where('is_active', 1)
                            ->get();
        } else {
            return Enrollment::with('course.modules.lessons.contents')
                            ->where('student_id', $student_id)
                            ->orderBy('date_end', 'asc')
                            ->where('date_end', '>=', Carbon::now())
                            ->where('date_begin', '<=', Carbon::now()->addMinute(+2))
                            ->where('exam_id', null)
                            ->where('is_active', 1)
                            ->get();
        }
    }

    public function getSomeStudentEnrollmentsByStatus($student_id, $fetch_number) {

        return Enrollment::with('course.modules.lessons.contents.views')->where('student_id', $student_id)->
                        orderBy('date_end', 'asc')->where('date_end', '>=', Carbon::now())->
                        where('exam_id', null)->where('is_active', 1)->get()->fetch($fetch_number);
    }

    public function saveRating($enrollment_id, $rating) {
        $enrollment = $this->find($enrollment_id);
        $enrollment->rating = $rating;
        if ($enrollment->save()) {
            return;
        }
    }

    public function saveCriteriaRating($enrollment_id, $rate, $criteria) {

        $rating = new Rating();
        $enrollment = $this->find($enrollment_id);

        $rating->course()->associate($enrollment->course_id);
        $rating->enrollment()->associate($enrollment_id);
        $rating->student()->associate(Auth::user()->id);
        $rating->criterion()->associate($criteria);
        $rating->rate = $rate;

        $rating->save();
    }

    public function getEnrollmentByExamStudent($exam_id, $student_id) {
        return Enrollment::where('student_id', $student_id)->where('exam_id', $exam_id)->where('is_active', 1)->get()->first();
    }

    public function getAllStudentEnrollmentsExamByStatus($student_id, $ongoing) {

        if ($ongoing == false) {
            return Enrollment::where('student_id', $student_id)
                            ->orderBy('date_end', 'asc')
                            ->where('date_end', '<', Carbon::now())
                            ->where('course_id', null)
                            ->get();
        } else {
            return Enrollment::where('student_id', $student_id)
                            ->orderBy('date_end', 'asc')
                            ->where('date_end', '>=', Carbon::now())
                            ->where('date_begin', '<=', Carbon::now()->addMinute(+2))
                            ->where('course_id', null)
                            ->where('is_active', 1)
                            ->get();
        }
    }

    public function getAllStudentEnrollmentsInLastHours($student_id, $hours) {
        //return Enrollment::where('student_id', $student_id)->where('date_begin','>',Carbon::now()->addHours( $hours * -1))->where('date_end','>=',Carbon::now()->addMinute( -2 ))->where('date_begin','<',Carbon::now())->where('is_active',1)->orderBy('date_begin', 'desc')->get();
        return Enrollment::where('student_id', $student_id)->where('date_begin', '>', Carbon::now()->addHours($hours * -1))->where('date_end', '>=', Carbon::now()->addMinute(-2))->where('is_active', 1)->orderBy('date_begin', 'desc')->get();
    }

    public function associatedExams($course_id, $student_id) {
        return Enrollment::where('student_id', $student_id)
                        ->select('enrollments.*')
                        ->where('date_end', '>=', Carbon::now())->where('enrollments.date_begin', '<', Carbon::now())
                        ->where('enrollments.is_active', 1)
                        ->where('enrollments.course_id', null)
                        ->join('courses_aggregated_exams', 'courses_aggregated_exams.exam_id_extra', '=', 'enrollments.exam_id')
                        ->join('exams', 'exams.id', '=', 'enrollments.exam_id')
                        ->where('course_id_bought', '=', $course_id)
                        ->orderBy('exams.title', 'asc')->get();
    }

    /**
     * Cria matricula para usários que compraram cursos com Exams associados
     * @todo
     * 
     * PENDENTE PARA TERMINAR - PARANDO PARA VER DEFEITO NAS NOTICIAS
     */
    public function createEnrollmentForUsersWithExamsAgregatedOfCourse() {
        //Recupera os cursos que possuem exams associados
        $courses = $this->course->getCourseWithExamsAgregated();

        foreach ($courses as $course) {

            //Recupera os exames associados ao curso
            $exams = $this->course->getExamsAgregatedCourse($course->id);

            foreach ($exams as $exam) {

                //Verifica os alunos que possuem matricula no curso
                $students = Enrollment::where('course_id', '=', $course->id)
                        ->groupBy('student_id')
                        ->orderBy('student_id')
                        ->get();

                foreach ($students as $student) {

                    print ($course->id . ',' . $exam->id . ',' . $student->student_id);

                    //Verifica se o aluno possui matricula para todos os exams associados ao Curso
                    $enrrolement = Enrollment::where('student_id', '=', $student->student_id)
                            ->where('exam_id', '=', $exam->id)
                            //->where('course_enrollment_id', '=', $course->id)
                            ->first();

                    //Caso o usuário não possua matricula para o exam 
                    if (count($enrrolement) == 0) {
                        //Cria a matricula
                        print " <font color='red'>criar matricula</font> <br/>";
                    }else{
                        print "<font color='green'>Já existe</font><br/>";
                    }
                }
            }
        }
    }

}
