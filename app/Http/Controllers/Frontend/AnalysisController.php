<?php namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Repositories\Frontend\Course\CourseContract;
use App\Repositories\Frontend\Exam\ExamContract;
use Illuminate\Support\Facades\Auth;


/**
 * Class ProfileController
 * @package App\Http\Controllers\Frontend
 */
class AnalysisController extends Controller {

    public function __construct(ExamContract $exams, CourseContract $courses) {
        $this->exams = $exams;
        $this->courses = $courses;
    }


    public function show($id,$type = "course"){

        $object = null;
        if($type == "course"){
            $object = $this->courses->findOrThrowException($id);
        }else{
            $object = $this->exams->findOrThrowException($id);
        }
        if(!Auth::user()->enrollments->whereLoose('partner_id',1)->where(strtolower(class_basename($object)) .'_id',$id)->isEmpty()){

            return view('frontend.analysis.' . $object->analysis);
        }else{
            return redirect()->back();
        }
    }

}