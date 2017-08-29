<?PHP namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\TeacherStatement\CreateTeacherStatementRequest;
use App\Http\Requests\Backend\TeacherStatement\UpdateTeacherStatementRequest;
use App\Repositories\Backend\TeacherStatement\TeacherStatementContract;
use App\Repositories\Backend\Order\OrderContract;
use App\Repositories\Backend\Video\VideoContract;
use App\Repositories\Backend\Article\ArticleContract;
use App\Repositories\Backend\OrderCourse\OrderCourseContract;
use App\Repositories\Backend\OrderLesson\OrderLessonContract;
use App\Repositories\Backend\OrderModule\OrderModuleContract;
use App\Repositories\Backend\CourseTeacher\CourseTeacherContract;
use App\Repositories\Backend\Configuration\ConfigurationContract;
use App\Repositories\Backend\Course\CourseContract;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\User;
use App\TeacherStatement;
use App\CourseTeacher;


/**
 * Class DashboardController
 * @package App\Http\Controllers\Backend
 */
class StatsController extends Controller {


    /**
     * @param ArticleContract $articles
     */
    public function __construct(VideoContract $videos, ArticleContract $articles, CourseContract $courses) {
        $this->videos = $videos;
        $this->articles = $articles;
        $this->courses = $courses;
    }

    /**
     * @return mixed
     */
    public function videos(Request $request){
        return view('backend.stats.videos')->withVideos($this->videos->getAllVideos('hits', 'desc'));

    }

    /**
     * @return mixed
     */
    public function coursesrank(Request $request){
        return view('backend.stats.coursesrank')->withCourses($this->courses->getAllCourses('average_grade', 'desc'));

    }

    /**
     * @return mixed
     */
    public function coursessales(Request $request){
        return view('backend.stats.coursessales')->withCourses($this->courses->getAllCourses('orders_count', 'desc'));

    }




    /**
     * @return mixed
     */
    public function articles(Request $request){
        return view('backend.stats.articles')->withArticles($this->articles->getAllArticles('hits', 'desc'));

    }


    /**
     * @return mixed
     */
    public function index(Request $request){
    }

    /**
     * @return mixed
     */
    public function create() {
    }

    /**
     * @param CreateArticleRequest $request
     * @return mixed
     */
    public function store(CreateTeacherStatementRequest $request) {
    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit($id) {
    }

    /**
     * @param $id
     * @param UpdateArticleRequest $request
     * @return mixed
     */
    public function update($id, UpdateTeacherStatementRequest $request) {
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id) {
    }


}