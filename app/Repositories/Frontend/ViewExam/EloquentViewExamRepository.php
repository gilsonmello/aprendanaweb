<?php namespace App\Repositories\Frontend\ViewExam;

use App\ViewExam;
use App\Question;
use App\Exceptions\GeneralException;
use App\ViewExamLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * Class EloquentViewExamRepository
 * @package App\Repositories\ViewExam
 */
class EloquentViewExamRepository implements ViewExamContract {


//	public function __construct() {
//	}

	/**
	 * @param $id
	 * @return mixed
	 * @throws GeneralException
	 */
	public function findOrThrowException($id) {
		$viewExam = ViewExam::withTrashed()->find($id);

		if (! is_null($viewExam)) return $viewExam;

		throw new GeneralException('That viewExams does not exist.');
	}



    public function findByEnrollmentAndQuestion($enrollment_id,$question_id){
        return ViewExam::where('enrollment_id',$enrollment_id)->where('question_id',$question_id)->get();
   }

    public function findByExecutionAndQuestion($execution_id,$question_id){
        return ViewExam::where('execution_id',$execution_id)->where('question_id',$question_id)->get();
    }


    public function enrollmentHasViewExam($enrollment_id, $question_id){
        return !$this->findByEnrollmentAndQuestion($enrollment_id,$question_id)->isEmpty();
    }


 
    public function createViewExam($execution,$question,$max_view){
        $viewExam = $this->createViewExamStub($max_view);
        $viewExam->question()->associate($question);
        $viewExam->execution()->associate($execution);

        //$viewExam->enrollment()->associate($enrollment);
        if($viewExam->save()){
            return $viewExam;
        }
    }


    public function createViewExamStub($max_view){
        $viewExam = new ViewExam;
        $viewExam->max_view = $max_view;
        $viewExam->view = 0;

        return $viewExam;

    }



}