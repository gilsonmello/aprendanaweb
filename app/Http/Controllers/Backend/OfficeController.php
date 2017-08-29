<?PHP namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Office\CreateOfficeRequest;
use App\Http\Requests\Backend\Office\UpdateOfficeRequest;
use App\Repositories\Backend\Office\OfficeContract;
use App\Services\UploadService\UploadService;
use Illuminate\Http\Request;

/**
 * Class DashboardController
 * @package App\Http\Controllers\Backend
 */
class OfficeController extends Controller {

    /**
     * @param OfficeContract $offices
     */
    public function __construct(OfficeContract $offices, UploadService $uploadService) {
        $this->offices = $offices;
        $this->uploadService = $uploadService;
    }

    /**
     * @return mixed
     */
    public function index(Request $request) {
        $request->session()->put('lastpage', $request->only('page')['page']);

        $f_submit = $request->input('f_submit', '');

        $f_OfficeController_name = get_parameter_or_session( $request, 'f_OfficeController_name', '', $f_submit, '' );

        return view('backend.offices.index')
            ->withOffices($this->offices->getOfficesPaginated(config('access.users.default_per_page'), 'name', 'asc', $f_OfficeController_name))
            ->withOfficecontrollername($f_OfficeController_name);
    }

    /**
     * @return mixed
     */
    public function create() {
        return view('backend.offices.create');
    }

    /**
     * @param CreateOfficeRequest $request
     * @return mixed
     */
    public function store(CreateOfficeRequest $request) {
        $office = $this->offices->create($request);

        if($request->hasFile('addimg')) {
            $upload_result = $this->uploadService->addImg($request->file('addimg'), $office->name, $office->id, 'offices');
            if(!isset($upload_result['error'])) $this->offices->updateImg($office->id, $upload_result['filename']);
        }

        return redirect()->route('admin.offices.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.offices.created"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit($id) {
        $office = $this->offices->findOrThrowException($id, true);

        $photooriginal = imageurl("offices/", $id, $office->addimg);
        $photoresize = imageurl("offices/", $id, $office->addimg, 100);

        return view('backend.offices.edit')->withOffice($office)
            ->withPhotooriginal($photooriginal)
            ->withPhotoresize($photoresize);
    }

    /**
     * @param $id
     * @param UpdateOfficeRequest $request
     * @return mixed
     */
    public function update($id, UpdateOfficeRequest $request) {

        $office = $this->offices->update($id, $request->except(['addimg']));

        if($request->hasFile('addimg')) {
            $upload_result = $this->uploadService->editImg($request->file('addimg'), $office->name, $office->id, 'offices', $office->img_sizes);
            if(!isset($upload_result['error'])) $this->offices->updateImg($office->id, $upload_result['filename']);
        }

        return redirect()->route('admin.offices.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.offices.updated"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id) {
        $this->offices->destroy($id);
        return redirect()->back()->withFlashSuccess(trans("alerts.offices.deleted"));
    }

}