<?PHP namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Repositories\Frontend\Article\ArticleContract;
use App\Repositories\Frontend\CourseTeacher\CourseTeacherContract;
use App\Repositories\Frontend\News\NewsContract;
use Illuminate\Support\Collection;
use App\Course;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * Class DashboardControllerapp/Http/Controllers/Backend/ArticleController.php:7
 * @package App\Http\Controllers\Backend
 */
class ArticleController extends Controller {

    /**
     * @param ArticleContract $articles
     */
    public function __construct(ArticleContract $articles, CourseTeacherContract $courseteachers) {
        $this->articles = $articles;
        $this->courseteachers = $courseteachers;
    }

    /**
     * @return mixed
     */
    public function index() {
        return view('frontend.articles.index')
            ->withArticles($this->articles->getArticlesPaginated(10, 'activation_date', 'desc'));
    }

    /**
     * @param $slug
     * @return mixed
     */
    public function show($slug) {
        $article = $this->articles->findOrThrowException($slug, true);
        $article->hits = $article->hits + 1;
        $article->save();
        $article->video_frag = parse_video($article->video);

        /*Código removido, foi trocado pela lógica de utilizar tags*/
        /*$coursesrelated = null;
        if (count($article->users) > 0) {
            $coursesrelated = $this->courseteachers->getAllCourseTeachersPerTeacher($article->users[0]->id );
        }*/

        $arrTags = explode(";", $article->tags);

        $query = 'AND (';
        $i = 0;
        foreach ($arrTags as $value => $tag) {
            if ($i == 0) {
                $query .= "courses.tags like '%" . $tag . "%' ";
            } else {
                $query .= "OR courses.tags like '%" . $tag . "%' ";
            }
            $i++;
        }
        $query .= ')';

        $related = DB::select(
            DB::raw("
                SELECT courses.*,
                    subsections.name as subsection_name,
                    sections.name as section_name,
                    sections.slug section_slug
                FROM courses
                iNNER JOIN subsections ON subsections.id = courses.subsection_id
                INNER JOIN sections ON sections.id = subsections.section_id
                WHERE courses.is_active = 1 $query
                ORDER BY RAND()
                LIMIT 4
            ")
        );

        /*Código removido, foi trocado pela lógica de utilizar tags*/
        /*$collection = new Collection($coursesrelated);

        // Sort descending by stars.
        $collection = $collection->sortByDesc(function($item)
        {
            return $item->course->orders_count;
        });
        */

        $more_articles = $article->users->first()->articles->reject(function($item)use($article){ return ($item->id == $article->id) || ($item->status == 0); });

        return view('frontend.articles.show')
            ->withArticle($article)
            ->withMoreCourses($related)
            ->withMoreArticles($more_articles->slice(0,3));
    }

}