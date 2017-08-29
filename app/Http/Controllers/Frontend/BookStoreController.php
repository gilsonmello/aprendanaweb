<?PHP

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;
use App\Repositories\Frontend\Section\SectionContract;
use App\Repositories\Frontend\Course\CourseContract;
use App\Http\Controllers\Frontend\Course;
use Carbon\Carbon;

/**
 * Class DashboardControllerapp/Http/Controllers/Backend/ArticleController.php:7
 * @package App\Http\Controllers\Backend
 */
class BookStoreController extends Controller {

    /**
     * @param ArticleContract $articles
     */
    public function __construct(SectionContract $sections, CourseContract $courses) {
        $this->sections = $sections;
        $this->courses = $courses;
    }

    /**
     * @return mixed
     */
    public function index() {
        return view('frontend.bookstore.index')
                        ->withCourses($this->courses->getCoursesPaginated(12))
                        ->withSections($this->sections->getAllSections())
                        ->withTitle('Livraria')
                        ->withSection(null);
    }

    /**
     * @param $slug
     * @return mixed
     */
    public function show($slug) {

        $course = \App\Course::where('slug', '=', $slug)->first();
        $course->video_frag = parse_video($course->video_ad_url);


        $related = \App\Course::where('id', '<>', $course->id)
                ->where('is_active', 1)
                ->where('activation_date', '<=', Carbon::now())
                ->where('subsection_id', $course->subsection_id)
                ->get()
                ->shuffle()
                ->take(4);

//          foreach ($course->modules as $module) {
//          $module['teachers'] = $this->modules->getLessonsPerTeacherPerModule($module);
//          }

        return view('frontend.bookstore.show')
                        ->withCourse($course)
                        ->withTitle('Detalhe do Livro')
                        ->withRelatedcourses($related);
    }

}
