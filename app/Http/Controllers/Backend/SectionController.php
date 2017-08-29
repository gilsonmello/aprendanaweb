<?PHP namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Section\CreateSectionRequest;
use App\Http\Requests\Backend\Section\UpdateSectionRequest;
use App\Repositories\Backend\Section\SectionContract;
use App\Services\UploadService\UploadService;
use Illuminate\Http\Request;

/**
 * Class DashboardController
 * @package App\Http\Controllers\Backend
 */
class SectionController extends Controller {

    /**
     * @param SectionContract $sections
     */
    public function __construct(SectionContract $sections, UploadService $uploadService) {
        $this->sections = $sections;
        $this->uploadService = $uploadService;
    }

    /**
     * @return mixed
     */
    public function index(Request $request) {
        $request->session()->put('lastpage', $request->only('page')['page']);

        return view('backend.sections.index')
            ->withSections($this->sections->getSectionsPaginated(config('access.users.default_per_page')));
    }

    /**
     * @return mixed
     */
    public function create() {
        return view('backend.sections.create');
    }

    /**
     * @param CreateSectionRequest $request
     * @return mixed
     */
    public function store(CreateSectionRequest $request) {
        $section = $this->sections->create($request);

        if($request->hasFile('addimg')) {
            $upload_result = $this->uploadService->addImg($request->file('addimg'), $section->name, $section->id, 'sections');
            if(!isset($upload_result['error'])) $this->sections->updateImg($section->id, $upload_result['filename']);
        }

        return redirect()->route('admin.sections.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.sections.created"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit($id) {
        $section = $this->sections->findOrThrowException($id, true);

        $photooriginal = imageurl("sections/", $id, $section->addimg);
        $photoresize = imageurl("sections/", $id, $section->addimg, 100);

        return view('backend.sections.edit')->withSection($section)
            ->withPhotooriginal($photooriginal)
            ->withPhotoresize($photoresize);
    }

    /**
     * @param $id
     * @param UpdateSectionRequest $request
     * @return mixed
     */
    public function update($id, UpdateSectionRequest $request) {

        $section = $this->sections->update($id, $request->except(['addimg']));

        if($request->hasFile('addimg')) {
            $upload_result = $this->uploadService->editImg($request->file('addimg'), $section->name, $section->id, 'sections', $section->img_sizes);
            if(!isset($upload_result['error'])) $this->sections->updateImg($section->id, $upload_result['filename']);
        }

        return redirect()->route('admin.sections.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.sections.updated"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id) {
        $this->sections->destroy($id);
        return redirect()->back()->withFlashSuccess(trans("alerts.sections.deleted"));
    }

}