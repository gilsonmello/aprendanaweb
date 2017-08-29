<?php namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Repositories\Frontend\AskTheTeacher\AskTheTeacherContract;
use App\Repositories\Frontend\Course\CourseContract;
use App\Repositories\Frontend\Exam\ExamContract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


/**
 * Class ProfileController
 * @package App\Http\Controllers\Frontend
 */
class KnowledgeController extends Controller {

    public function __construct(ExamContract $exams, CourseContract $courses, AskTheTeacherContract $asktheteacher) {
        $this->exams = $exams;
        $this->courses = $courses;
        $this->asktheteacher = $asktheteacher;
    }


    public function show($id = 0, $type="course"){

        /*
        $partners = Auth::user()->enrollments->reject(function($item){ return $item->partner_id == null;})
            ->unique('partner_id')->pluck('partner_id');


        $questions = Collect();

        foreach($partners as $partner) {
          $questions = $questions->merge($this->asktheteacher->getAskTheTeacherPerPartner($partner));
        }
        */



        return view('frontend.studentarea.knowledge-base.index')->withQuestions(null);

    }


    public function search(Request $request){

        $term = $request->input('s');
        $partners = Auth::user()->enrollments->reject(function($item){ return $item->partner_id == null;})
            ->unique('partner_id')->pluck('partner_id');

        $questions = $this->asktheteacher->getBySearch($term,$partners);


        return view('frontend.studentarea.knowledge-base.index')->withQuestions($questions);
    }

}