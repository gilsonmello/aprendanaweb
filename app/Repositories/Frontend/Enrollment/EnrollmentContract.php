<?php

namespace App\Repositories\Frontend\Enrollment;

/**
 * Interface UserContract
 * @package App\Repositories\Enrollment
 */
interface EnrollmentContract {

    public function find($enrollment_id);

    public function isStudentEnrolledCourse($student_id, $course_id);

    public function isStudentEnrolledLesson($student_id, $lesson_id);

    public function isStudentEnrolledModule($student_id, $module_id);

    //public function isStudentEnrolledExam($student_id,$exam);
    public function getEnrollmentByContentStudent($content_id, $student_id);

    public function getEnrollmentByExamStudent($exam_id, $student_id);

    public function getStudentEnrollmentModule($student_id, $module_id);

    public function getStudentEnrollmentCourse($student_id, $course_id);

    public function getStudentEnrollmentLesson($student_id, $lesson_id);

    public function getAllStudentEnrollmentsByStatus($student_id, $ongoing);

    public function getAllStudentEnrollmentsExamByStatus($student_id, $ongoing);

    public function saveRating($enrollment_id, $rating);

    public function saveCriteriaRating($enrollment_id, $rating, $criteria);

    public function getAllStudentEnrollmentsInLastHours($student_id, $hours);

    public function associatedExams($course_id, $student_id);

    public function createEnrollmentForUsersWithExamsAgregatedOfCourse();
}
