<?php namespace App\Repositories\Frontend\Exam;

use App\Exam;
use App\Lesson;
use App\Exceptions\GeneralException;
use App\Repositories\Backend\Tag\TagContract;
use Illuminate\Support\Facades\Log;

/**
 * Class EloquentCourseRepository
 * @package App\Repositories\Course
 */
class EloquentExamRepository implements ExamContract {


	public function __construct(TagContract $tags) {
        $this->tags = $tags;
	}

	/**
	 * @param $id
	 * @return mixed
	 * @throws GeneralException
	 */
	public function findOrThrowException($id) {
		$exam = Exam::withTrashed()->find($id);

		if (! is_null($exam)) return $exam;

		throw new GeneralException('That exam does not exist.');
	}

	public function updateAverageGrade($exam,$grade){
		$exam->times_executed = $exam->times_executed + 1;
		if($exam->average_grade !== null){
		$exam->average_grade = (($exam->average_grade * ($exam->times_executed - 1)) + $grade) / $exam->times_executed;
		}else{
			$exam->average_exam_grade = (($exam->average_exam_grade * ($exam->times_executed - 1)) + $grade) / $exam->times_executed;

		}
		$exam->save();

	}


	public function updateRatingNaive($exam, $rating)
	{
		if($exam->rating === null){
			$exam->rating = $rating;
			$exam->num_votes = 1;
		}else{
			$exam->rating = (($exam->rating * $exam->num_votes) + $rating);
			$exam->num_votes = $exam->num_votes + 1;
			$exam->rating = $exam->rating / $exam->num_votes;
		}

		$exam->save();


		return $exam->rating;
	}

	public function getExamsByCourse($course)
	{
		$exams = Exam::join('lessons','lessons.exam_id','=', 'exams.id')->join('modules','modules.id','=','lessons.module_id')->where('modules.course_id',$course->id)->select('exams.*','lessons.id as lesson_id','lessons.sequence as lesson_sequence','modules.id as module_id','modules.name as module_name')->orderBy('lessons.sequence','asc')->groupBy('lessons.id')->get();

		$exams = $exams->groupBy('module_id');

		return $exams;
	}


	public function findLessonSuggestion($subject_id,$exam_id){
		Log::info('Log.Subject');
		Log::info($subject_id);
		Log::info($exam_id);
		return  Lesson::join('modules','modules.id','=','lessons.module_id')->join('courses','modules.course_id','=','courses.id')->
		join('courses_aggregated_exams','courses_aggregated_exams.course_id_bought','=','courses.id')->join('groups','groups.lesson_id','=','lessons.id')->
		join('group_subject','group_subject.group_id','=','groups.id')->join('subjects as s1','s1.id','=','group_subject.subject_id')->
		join('subjects as s2','s2.id','=','s1.subject_id')->where('courses_aggregated_exams.exam_id_extra',$exam_id)->where('s1.id',$subject_id)->
		select('lessons.*')->first();



	}

}