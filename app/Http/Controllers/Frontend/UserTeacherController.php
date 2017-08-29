<?php namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Repositories\Frontend\User\UserTeacherContract;
use Illuminate\Http\Request;
use App\Repositories\Frontend\CourseTeacher\CourseTeacherContract;
use Illuminate\Support\Collection;
/**
 * Class UserTeacherController
 * @package App\Http\Controllers\Frontend
 */
class UserTeacherController extends Controller {

    /**
     * @param UserTeacherContract $teachers
     */
    public function __construct(UserTeacherContract $teachers, CourseTeacherContract $courseteachers) {
        $this->teachers = $teachers;
        $this->courseteachers = $courseteachers;
    }

    /**
     * @return mixed
     */
    public function index(Request $request) {

        $f_submit = $request->input('f_submit', '');
        $f_most_sold = $request->input('f_most_sold', '');
        $f_search = get_parameter_or_session( $request, 'f_search', '', $f_submit, '' );
        $f_social = get_parameter_or_session( $request, 'f_social', '', $f_submit, '' );

        if ($f_most_sold === '1'){
            $teachers = $this->teachers->getUserTeachersPaginated(24, $f_search, $f_social, 'orders_count', 'desc');
        } else {
            $teachers = $this->teachers->getUserTeachersPaginated(24, $f_search, $f_social);
        }

        return view('frontend.teachers.index')
            ->withTeachers( $teachers )
            ->withSearch( $f_search);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id) {

        $teacher = $this->teachers->findBySlug($id);
        if ($teacher == null){
            $teacher = $this->teachers->findOrThrowException($id);
        }

        if ($teacher->list_on_site != 1){
            return '';
        }

        $teacher->video_frag = parse_video($teacher->video);

        $coursesrelated = $this->courseteachers->getAllCourseTeachersPerTeacher($teacher->id );
        $collectionCourse = new Collection($coursesrelated);
        $collectionCourse = $collectionCourse->sortByDesc(function($item)
        {
            return $item->course->orders_count;
        });

        $videosrelated = $teacher->videos()->get();
        $collectionVideos = new Collection($videosrelated);
        $collectionVideos = $collectionVideos->sortByDesc(function($item)
        {
            return $item->activation_date;
        });

        $articlesrelated = $teacher->articles()->get();

        $collectionArticles = new Collection($articlesrelated);
        $collectionArticles = $collectionArticles->sortByDesc(function($item)
        {
            return $item->activation_date;
        });

        $collectionPackages = $teacher->packages()->get()->sortByDesc(function($item){
            return $item->activation_date;
        });

        return view('frontend.teachers.show')
            ->withTeacher($teacher)
            ->withCoursesrelated($collectionCourse->slice(0,4))
            ->withVideosrelated( $collectionVideos->slice(0,8) )
            ->withArticlesrelated( $collectionArticles->slice(0,8) )
            ->withPackagesrelated( $collectionPackages->slice(0,4));
    }

}