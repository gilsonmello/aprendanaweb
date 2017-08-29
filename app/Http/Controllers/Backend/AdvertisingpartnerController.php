<?PHP namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Advertisingpartner\CreateAdvertisingpartnerRequest;
use App\Http\Requests\Backend\Advertisingpartner\UpdateAdvertisingpartnerRequest;
use App\Repositories\Backend\Advertisingpartner\AdvertisingpartnerContract;
use App\Services\UploadService\UploadService;
use Illuminate\Http\Request;

/**
 * Class DashboardController
 * @package App\Http\Controllers\Backend
 */
class AdvertisingpartnerController extends Controller {

    /**
     * @param AdvertisingpartnerContract $advertisingpartners
     */
    public function __construct(AdvertisingpartnerContract $advertisingpartners, UploadService $uploadService) {
        $this->advertisingpartners = $advertisingpartners;
        $this->uploadService = $uploadService;
    }

    /**
     * @return mixed
     */
    public function index(Request $request) {
        $request->session()->put('lastpage', $request->only('page')['page']);

        $f_submit = $request->input('f_submit', '');

        $f_AdvertisingpartnerController_name = get_parameter_or_session( $request, 'f_AdvertisingpartnerController_name', '', $f_submit, '' );

        return view('backend.advertisingpartners.index')
            ->withAdvertisingpartners($this->advertisingpartners->getAdvertisingpartnersPaginated(config('access.users.default_per_page'), 'name', 'asc', $f_AdvertisingpartnerController_name))
            ->withAdvertisingpartnercontrollername($f_AdvertisingpartnerController_name);
    }

    /**
     * @return mixed
     */
    public function create() {
        return view('backend.advertisingpartners.create');
    }

    /**
     * @param CreateAdvertisingpartnerRequest $request
     * @return mixed
     */
    public function store(CreateAdvertisingpartnerRequest $request) {
        $advertisingpartner = $this->advertisingpartners->create($request);

        if($request->hasFile('addimg')) {
            $upload_result = $this->uploadService->addImg($request->file('addimg'), $advertisingpartner->name, $advertisingpartner->id, 'advertisingpartners');
            if(!isset($upload_result['error'])) $this->advertisingpartners->updateImg($advertisingpartner->id, $upload_result['filename']);
        }

        return redirect()->route('admin.advertisingpartners.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.advertisingpartners.created"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit($id) {
        $advertisingpartner = $this->advertisingpartners->findOrThrowException($id, true);

        $photooriginal = imageurl("advertisingpartners/", $id, $advertisingpartner->addimg);
        $photoresize = imageurl("advertisingpartners/", $id, $advertisingpartner->addimg, 100);

        return view('backend.advertisingpartners.edit')->withAdvertisingpartner($advertisingpartner)
            ->withPhotooriginal($photooriginal)
            ->withPhotoresize($photoresize);
    }

    /**
     * @param $id
     * @param UpdateAdvertisingpartnerRequest $request
     * @return mixed
     */
    public function update($id, UpdateAdvertisingpartnerRequest $request) {

        $advertisingpartner = $this->advertisingpartners->update($id, $request->except(['addimg']));

        if($request->hasFile('addimg')) {
            $upload_result = $this->uploadService->editImg($request->file('addimg'), $advertisingpartner->name, $advertisingpartner->id, 'advertisingpartners', $advertisingpartner->img_sizes);
            if(!isset($upload_result['error'])) $this->advertisingpartners->updateImg($advertisingpartner->id, $upload_result['filename']);
        }

        return redirect()->route('admin.advertisingpartners.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.advertisingpartners.updated"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id) {
        $this->advertisingpartners->destroy($id);
        return redirect()->back()->withFlashSuccess(trans("alerts.advertisingpartners.deleted"));
    }

}