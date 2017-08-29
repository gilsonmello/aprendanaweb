<?PHP namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Source\CreateSourceRequest;
use App\Http\Requests\Backend\Source\UpdateSourceRequest;
use App\Repositories\Backend\Source\SourceContract;
use App\Services\UploadService\UploadService;
use Illuminate\Http\Request;

/**
 * Class DashboardController
 * @package App\Http\Controllers\Backend
 */
class SourceController extends Controller {

    /**
     * @param SourceContract $sources
     */
    public function __construct(SourceContract $sources, UploadService $uploadService) {
        $this->sources = $sources;
        $this->uploadService = $uploadService;
    }

    /**
     * @return mixed
     */
    public function index(Request $request) {
        $request->session()->put('lastpage', $request->only('page')['page']);

        $f_submit = $request->input('f_submit', '');

        $f_SourceController_name = get_parameter_or_session( $request, 'f_SourceController_name', '', $f_submit, '' );

        return view('backend.sources.index')
            ->withSources($this->sources->getSourcesPaginated(config('access.users.default_per_page'), 'name', 'asc', $f_SourceController_name))
            ->withSourcecontrollername($f_SourceController_name);
    }

    /**
     * @return mixed
     */
    public function create() {
        return view('backend.sources.create');
    }

    /**
     * @param CreateSourceRequest $request
     * @return mixed
     */
    public function store(CreateSourceRequest $request) {
        $source = $this->sources->create($request);

        if($request->hasFile('addimg')) {
            $upload_result = $this->uploadService->addImg($request->file('addimg'), $source->name, $source->id, 'sources');
            if(!isset($upload_result['error'])) $this->sources->updateImg($source->id, $upload_result['filename']);
        }

        return redirect()->route('admin.sources.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.sources.created"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit($id) {
        $source = $this->sources->findOrThrowException($id, true);

        $photooriginal = imageurl("sources/", $id, $source->addimg);
        $photoresize = imageurl("sources/", $id, $source->addimg, 100);

        return view('backend.sources.edit')->withSource($source)
            ->withPhotooriginal($photooriginal)
            ->withPhotoresize($photoresize);
    }

    /**
     * @param $id
     * @param UpdateSourceRequest $request
     * @return mixed
     */
    public function update($id, UpdateSourceRequest $request) {

        $source = $this->sources->update($id, $request->except(['addimg']));

        if($request->hasFile('addimg')) {
            $upload_result = $this->uploadService->editImg($request->file('addimg'), $source->name, $source->id, 'sources', $source->img_sizes);
            if(!isset($upload_result['error'])) $this->sources->updateImg($source->id, $upload_result['filename']);
        }

        return redirect()->route('admin.sources.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.sources.updated"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id) {
        $this->sources->destroy($id);
        return redirect()->back()->withFlashSuccess(trans("alerts.sources.deleted"));
    }

}