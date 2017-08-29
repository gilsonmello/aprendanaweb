<?PHP namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Tag\CreateTagRequest;
use App\Http\Requests\Backend\Tag\UpdateTagRequest;
use App\Repositories\Backend\Tag\TagContract;
use Illuminate\Http\Request;

/**
 * Class DashboardController
 * @package App\Http\Controllers\Backend
 */
class TagController extends Controller {

    /**
     * @param TagContract $tags
     */
    public function __construct(TagContract $tags) {
        $this->tags = $tags;
    }

    /**
     * @return mixed
     */
    public function index(Request $request) {
        $request->session()->put('lastpage', $request->only('page')['page']);

        return view('backend.tags.index')
            ->withTags($this->tags->getTagsPaginated(config('access.users.default_per_page')));
    }

    /**
     * @return string
     */
    public function selectTag() {
        $tags = $this->tags->selectTags( $_POST['term'] );

        $list = [];
        foreach ($tags as $tag) {
            $list[] = ['id' => $tag->name, 'text' => $tag->name];
        }

        return json_encode($list);
    }

    /**
     * @return mixed
     */
    public function create() {
        return view('backend.tags.create');
    }

    /**
     * @param CreateTagRequest $request
     * @return mixed
     */
    public function store(CreateTagRequest $request) {
        $this->tags->create($request);
        return redirect()->route('admin.tags.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.tags.created"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit($id) {
        $tag = $this->tags->findOrThrowException($id, true);
        return view('backend.tags.edit')->withTag($tag);
    }


    /**
     * @param $id
     * @param UpdateTagRequest $request
     * @return mixed
     */
    public function update($id, UpdateTagRequest $request) {
        $this->tags->update($id, $request->all());
        return redirect()->route('admin.tags.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.tags.updated"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id) {
        $this->tags->destroy($id);
        return redirect()->back()->withFlashSuccess(trans("alerts.tags.deleted"));
    }

    public function deactivated($id) {
        $this->tags->deactivated($id);
        return redirect()->back()->withFlashSuccess(trans("alerts.tags.deactivated"));
    }

    public function activated($id) {
        $this->tags->activated($id);
        return redirect()->back()->withFlashSuccess(trans("alerts.tags.activated"));
    }

}