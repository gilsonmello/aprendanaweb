<?PHP namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\News\CreateNewsRequest;
use App\Http\Requests\Backend\News\UpdateNewsRequest;
use App\Repositories\Backend\News\NewsContract;
use App\Repositories\Backend\User\UserContract;
use App\Services\UploadService\UploadService;
use App\Domain;
use Illuminate\Http\Request;


/**
 * Class DashboardControllerapp/Http/Controllers/Backend/NewsController.php:7
 * @package App\Http\Controllers\Backend
 */
class NewsController extends Controller {

    /**
     * @param NewsContract $news
     * @param UserContract $users
     * @param UploadService $uploadService
     */
    public function __construct(NewsContract $news, UserContract $users, UploadService $uploadService) {
        $this->news = $news;
        $this->users = $users;
        $this->uploadService = $uploadService;
    }

    /**
     * @return mixed
     */
    public function index(Request $request) {
        $request->session()->put('lastpage', $request->only('page')['page']);

        $f_submit = $request->input('f_submit', '');

        $f_NewsController_title = get_parameter_or_session( $request, 'f_NewsController_title', '', $f_submit, '' );


        return view('backend.news.index')
            ->withNews($this->news->getAllNewsPaginated(config('access.users.default_per_page'), 'id', 'desc', $f_NewsController_title))
            ->withNewscontrollertitle($f_NewsController_title);
    }

    /**
     * @return mixed
     */
    public function create() {

        return view('backend.news.create')->withTeachers($this->users->getOnlyTeachers())->withDomains(Domain::orderBy('name')->get());
    }

    /**
     * @param CreateNewsRequest $request
     * @return mixed
     */
    public function store(CreateNewsRequest $request) {
        $new = $this->news->create($request);

        if($request->hasFile('img')) {
            $upload_result = $this->uploadService->addImg($request->file('img'), $new->title, $new->id, 'news');
            if(!isset($upload_result['error'])) $this->news->updateImg($new->id, $upload_result['filename']);
        }

        return redirect()->route('admin.news.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.news.created"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit($id) {
        $new = $this->news->findOrThrowException($id, true);
        return view('backend.news.edit')->withNew($new)->withDomains(Domain::orderBy('name')->get());
    }

    /**
     * @param $id
     * @param UpdateNewsRequest $request
     * @return mixed
     */
    public function update($id, UpdateNewsRequest $request) {
        $new = $this->news->update($id, $request->except(['img']));

        if($request->hasFile('img')) {
            $upload_result = $this->uploadService->editImg($request->file('img'), $new->title, $new->id, 'news', $new->img_sizes);
            if(!isset($upload_result['error'])) $this->news->updateImg($new->id, $upload_result['filename']);
        }

        return redirect()->route('admin.news.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.news.updated"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id) {
        $this->news->destroy($id);
        return redirect()->back()->withFlashSuccess(trans("alerts.news.deleted"));
    }

}