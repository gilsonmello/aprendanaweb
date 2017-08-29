<?php namespace App\Repositories\Frontend\View;

use App\View;
use App\Content;
use App\Exceptions\GeneralException;
use App\ViewLog;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

/**
 * Class EloquentViewRepository
 * @package App\Repositories\View
 */
class EloquentViewRepository implements ViewContract {


//	public function __construct() {
//	}

	/**
	 * @param $id
	 * @return mixed
	 * @throws GeneralException
	 */
	public function findOrThrowException($id) {
		$view = View::withTrashed()->find($id);

		if (! is_null($view)) return $view;

		throw new GeneralException('That views does not exist.');
	}



    public function findByEnrollmentAndContent($enrollment_id,$content_id){
        return View::where('enrollment_id',$enrollment_id)->where('content_id',$content_id)->get();
   }


    public function enrollmentHasView($enrollment_id, $content_id){
        return !$this->findByEnrollmentAndContent($enrollment_id,$content_id)->isEmpty();
    }


    public function saveState($enrollment_id,$content_id,$state,$percent, $count)
    {
        $view = $this->findByEnrollmentAndContent($enrollment_id,$content_id)->first();


        if($view->state == null || strlen($view->state) < (strlen($state)) )
            $view->state = $state;


        if($view->accumulated_percent != null) {
            $view->percent = $percent - $view->accumulated_percent  ;
        }else{
            $view->percent = $percent;
        }

        if($view->percent >= 70 && $view->view == $count){
            $view->view = $view->view + 1;
        }

        if($view->save()){
            return $view;
        }

    }





    public function createView($enrollment,$content,$max_view){
        $view = $this->createViewStub($max_view);
        $view->content()->associate($content);
        $view->enrollment()->associate($enrollment);
        if($view->save()){
            return $view;
        }
    }


    public function createViewStub($max_view){
        $view = new View;
        $view->max_view = $max_view;
        $view->view = 0;
        $view->accumulated_percent = 0;
        $view->like = 0;
        $view->state = '0';

        return $view;

    }


    public function createViewLog($enrollment,$content){
        $view = new ViewLog();
        $view->content()->associate($content);
        $view->enrollment()->associate($enrollment);
        if($view->save()){
            return $view;
        }
    }








    public function updatePercentageForNewView($id, $percent,$accumulated_percent){
        $view = $this->findOrThrowException($id);
        $view->percent = $percent;
        $view->accumulated_percent = $accumulated_percent;
        if($view->save()){
            return true;
        }
    }

    public function saveLike($view_id, $up_down ,$criteria)
    {
        $view = $this->findOrThrowException($view_id);
        if ($criteria == 'content'){
            $view->like_content = $up_down;
        } else if ($criteria == 'teaching'){
            $view->like_teaching = $up_down;
        }
        if($view->save()){
            return true;
        }
    }


    public function lessonViewed($enrollment_id, $lesson,$active = false){
        $views = View::where('enrollment_id',$enrollment_id)
            ->select('contents.*','view.view as count')->join('contents', 'contents.id', '=', 'view.content_id')->where('contents.lesson_id',$lesson->id)->where('is_video', '=', 1);

        $views_total = $views->count();



        $views = $views->where('view', '>', 0);

        $view_count = $views->count();
        // Método deve retornar uma condição verdade caso toda a aula já tenha sido vista. Caso contrário, deve retornar o número de aulas vistas/remanescentes
        if ($view_count < $lesson->contents->whereLoose('is_video', 1)->count() ){
            $views_viewed = array_fill(0, $lesson->contents->whereLoose('is_video',1)->count(),0);

            if($views_total == 0 && $active == false) return false;
            if($view_count > 0){
            foreach($views->get() as $view){
                $views_viewed[$view->sequence - 1] = $view->count;
            }
            }
            return $views_viewed;
        } else {
            return true;
        }
    }

    public function modulePercentageViewed($enrollment_id, $module){
        $views = View::where('enrollment_id',$enrollment_id)
            ->select('contents.*')
            ->join('contents', 'contents.id', '=', 'view.content_id')
            ->join('lessons', 'lessons.id', '=', 'contents.lesson_id')
            ->where('lessons.module_id',$module->id)
            ->where('view', '>', 0)
            ->where('is_video', '=', 1)->count();

        $contents = Content::where('is_video', '=', 1)
            ->select('contents.*')
            ->join('lessons', 'lessons.id', '=', 'contents.lesson_id')
            ->where('lessons.module_id',$module->id)
            ->count();

        if ($contents === 0) return 0;
        else return $views / $contents * 100;

    }

    public function getTimeInEnrollment($user_id){
        $today = Carbon::yesterday();

        $time = ViewLog::select([DB::raw('DATE(`view_log`.`created_at`) as `date_created`'),DB::raw('sum(`watched_time`) as watched_time')])->join('enrollments', 'enrollments.id', '=', 'view_log.enrollment_id')->where('enrollments.student_id',$user_id)->orderBy('date_created','desc')->groupBy('date_created')->get();

        return $time;
        //$time = ViewLog::groupBy(DB::raw('Date(created_at)'))
         //   ->orderBy('created_at', 'DESC')->sum('watched_time');
    }

    public function getTimeInCourse($user_id,$course_id){
        $today = Carbon::yesterday();

        $time = ViewLog::select([DB::raw('DATE(`view_log`.`created_at`) as `date_created`'),DB::raw('sum(`watched_time`) as watched_time')])->join('enrollments', 'enrollments.id', '=', 'view_log.enrollment_id')->where('enrollments.student_id',$user_id)->orderBy('date_created','desc')->groupBy('date_created')->get();

        return $time;
        //$time = ViewLog::groupBy(DB::raw('Date(created_at)'))
        //   ->orderBy('created_at', 'DESC')->sum('watched_time');
    }


    public function getLastViewLog($enrollment_id,$content_id){
        $view_log = ViewLog::where('enrollment_id',$enrollment_id)->where('content_id',$content_id)->orderBy('created_at','desc')->first();

        return $view_log;
    }

}