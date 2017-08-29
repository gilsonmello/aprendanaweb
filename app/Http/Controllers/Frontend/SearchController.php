<?PHP

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Repositories\Frontend\Package\PackageContract;
use Illuminate\Http\Request;
use App\Repositories\Frontend\Article\ArticleContract;
use App\Repositories\Frontend\Course\CourseContract;
use App\Repositories\Frontend\Video\VideoContract;
use Log;
use App\Repositories\Frontend\News\NewsContract;
use App\Repositories\Frontend\User\UserTeacherContract;
use Carbon\Carbon;

/**
 * Class DashboardControllerapp
 * @package App\Http\Controllers\Backend
 */
class SearchController extends Controller {

    /**
     * @param CourseContract $courses
     * @param VideoContract $videos
     * @param ArticleContract $articles
     * @param NewsContract $news
     * @param UserTeacherContract $teachers
     * @param PackageContract $packages
     */
    public function __construct(CourseContract $courses, VideoContract $videos, ArticleContract $articles, NewsContract $news, UserTeacherContract $teachers, PackageContract $packages) {
        $this->courses = $courses;
        $this->videos = $videos;
        $this->articles = $articles;
        $this->news = $news;
        $this->teachers = $teachers;
        $this->packages = $packages;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request) {
        $term = $request->input('s');

        $courses = $this->courses->getBySearch($term);


        $videos = $this->videos->getBySearch($term);
        $articles = $this->articles->getBySearch($term);
        $news = $this->news->getBySearch($term);
        $teachers = $this->teachers->getUserTeachers($term, null);
        $packages = $this->packages->getBySearch($term);
        $arrSubsections = $this->getSubSectionsInArray();
        $arrSections = $this->getSectionsInArray();

        return view('frontend.search.index')
                        ->withCourses($courses)
                        ->withVideos($videos)
                        ->withArticles($articles)
                        ->withTerm($term)
                        ->withNews($news)
                        ->withTeachers($teachers)
                        ->withPackages($packages)
                        ->withArrSubsection($arrSubsections)
                        ->withArrSection($arrSections);
    }

    /**
     * Recupera o nome da Subsessao de um determinado curso
     * @param type $course_id
     * @return array
     */
    public function getSubSectionsInArray() {
        $subsections = \App\Subsection::where('id', '<>', 0)->get();

        foreach ($subsections as $subsection) {
            $arrSubsection[$subsection->id] = $subsection;
        }

        return $arrSubsection;
    }

    /**
     * Recupera o nome da sessao de um determinado curso
     * @param type $course_id
     * @return array
     */
    public function getSectionsInArray() {
        $sections = \App\Section::where('id', '<>', 0)->get();

        foreach ($sections as $section) {
            $arrSection[$section->id] = $section;
        }

        return $arrSection;
    }

    public function getJsonTagsAndCourses() {
        $courses = \App\Course::where('is_active', 1)
                ->where('activation_date', '<=', Carbon::now())
                ->get();

        $courses = $courses->each(function($course) {
            $course->title = 'CURSOS :: ' . $course->title;
            $course->link = route('course-section', ['cursinhos', "", $course->slug]);
            unset($course->slug);
        });

        $tags = \App\Tag::get(['id', 'name']);
        $tags = $tags->each(function($tag) {
            $tag->title = $tag->name;
            $tag->link = route('search', ['s' => '"' . $tag->name . '"']);
            unset($tag->name);
        });

        $final = $courses->merge($tags);

        return \Response::json($final);
    }

}
