<?PHP namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Article\CreateArticleRequest;
use App\Http\Requests\Backend\Article\UpdateArticleRequest;
use App\Repositories\Backend\Article\ArticleContract;
use App\Repositories\Backend\User\UserContract;
use App\Services\UploadService\UploadService;
use Illuminate\Http\Request;


/**
 * Class DashboardControllerapp/Http/Controllers/Backend/ArticleController.php:7
 * @package App\Http\Controllers\Backend
 */
class ArticleController extends Controller {

    /**
     * @param ArticleContract $articles
     * @param UserContract $users
     * @param UploadService $uploadService
     */
    public function __construct(ArticleContract $articles, UserContract $users, UploadService $uploadService) {
        $this->articles = $articles;
        $this->users = $users;
        $this->uploadService = $uploadService;
    }

    /**
     * @return mixed
     */
    public function index(Request $request) {
        $request->session()->put('lastpage', $request->only('page')['page']);

        $f_submit = $request->input('f_submit', '');

        $f_ArticleController_title = get_parameter_or_session( $request, 'f_ArticleController_title', '', $f_submit, '' );


        return view('backend.articles.index')
            ->withArticles($this->articles->getArticlesPaginated(config('access.users.default_per_page'), 'id', 'desc', $f_ArticleController_title))
            ->withArticlecontrollertitle($f_ArticleController_title);
    }

    /**
     * @return mixed
     */
    public function create() {
        return view('backend.articles.create')->withTeachers($this->users->getOnlyTeachers());
    }

    /**
     * @param CreateArticleRequest $request
     * @return mixed
     */
    public function store(CreateArticleRequest $request) {
        $article = $this->articles->create($request);

        if($request->hasFile('img')) {
            $upload_result = $this->uploadService->addImg($request->file('img'), $article->title, $article->id, 'articles');
            if(!isset($upload_result['error'])) $this->articles->updateImg($article->id, $upload_result['filename']);
        }

        return redirect()->route('admin.articles.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.articles.created"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit($id) {
        $article = $this->articles->findOrThrowException($id, true);
        return view('backend.articles.edit')->withArticle($article)->withTeachers($this->users->getOnlyTeachers());
    }

    /**
     * @param $id
     * @param UpdateArticleRequest $request
     * @return mixed
     */
    public function update($id, UpdateArticleRequest $request) {
        $article = $this->articles->update($id, $request->except(['teachers', 'img']), $request->only('teachers'));

        if($request->hasFile('img')) {
            $upload_result = $this->uploadService->editImg($request->file('img'), $article->title, $article->id, 'articles', $article->img_sizes);
            if(!isset($upload_result['error'])) $this->articles->updateImg($article->id, $upload_result['filename']);
        }

        return redirect()->route('admin.articles.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.articles.updated"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id) {
        $this->articles->destroy($id);
        return redirect()->back()->withFlashSuccess(trans("alerts.articles.deleted"));
    }

}