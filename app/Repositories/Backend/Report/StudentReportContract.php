<?php namespace App\Repositories\Backend\Report;

/**
 * Interface UserContract
 * @package App\Repositories\Article
 */
interface StudentReportContract {

	/**
	 * Get all report execution the SAAP
	 * @param date $date_begin
	 * @param date $date_end
	 * @param int $exam_id
	 */
    public function getStudentExecutionsSaapReports($date_begin, $date_end, $exam_id);

    /**
	 * Get all report performance
	 * @param date $date_begin
	 * @param date $date_end
	 * @param int $course_id
	 * @param int $partner_id
	 * @param int $studentgroup_id
	 * @param string $student_name
	 * @param int &$count_student
	 * @param string $couponname
	 */
    public function getStudentPerformanceReports(
    	$date_begin, 
    	$date_end, 
    	$course_id, 
    	$partner_id, 
		$studentgroup_id, 
		$student_name, 
		&$count_student, 
		$couponname = ""
	);

    /**
	 * Get demographics report the Students
	 * @param date $date_begin
	 * @param date $date_end
	 * @param int $course_id
	 * @param int $partner_id
	 * @param int $studentgroup_id
	 * @param string $student_name
	 * @param int &$count_student
	 * @param string $couponname
	 */
    public function getStudentDemographicsReports(
    	$date_begin, 
    	$date_end, 
    	$course_id, 
    	$dim1, 
    	$dim2, 
    	$dim3, 
    	&$count_student
    );
}