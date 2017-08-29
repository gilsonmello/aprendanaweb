<?PHP namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Partner\CreatePartnerRequest;
use App\Http\Requests\Backend\Partner\UpdatePartnerRequest;
use App\Repositories\Backend\Partner\PartnerContract;
use App\Services\UploadService\UploadService;
use Illuminate\Http\Request;

/**
 * Class DashboardController
 * @package App\Http\Controllers\Backend
 */
class PartnerController extends Controller {

    /**
     * @param PartnerContract $partners
     */
    public function __construct(PartnerContract $partners, UploadService $uploadService) {
        $this->partners = $partners;
        $this->uploadService = $uploadService;
    }

    /**
     * @return mixed
     */
    public function index(Request $request) {
        $request->session()->put('lastpage', $request->only('page')['page']);

        $f_submit = $request->input('f_submit', '');

        $f_PartnerController_name = get_parameter_or_session( $request, 'f_PartnerController_name', '', $f_submit, '' );

        return view('backend.partners.index')
            ->withPartners($this->partners->getPartnersPaginated(config('access.users.default_per_page'), 'name', 'asc', $f_PartnerController_name))
            ->withPartnercontrollername($f_PartnerController_name);
    }

    /**
     * @return mixed
     */
    public function create() {
        return view('backend.partners.create');
    }

    /**
     * @param CreatePartnerRequest $request
     * @return mixed
     */
    public function store(CreatePartnerRequest $request) {
        $partner = $this->partners->create($request);

        if($request->hasFile('logo')) {
            $upload_result = $this->uploadService->editImg($request->file('logo'), $partner->name, $partner->id, 'partners', $partner->img_sizes);
            if(!isset($upload_result['error'])) $this->partners->updateLogo($partner->id, $upload_result['filename']);
        }

        return redirect()->route('admin.partners.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.partners.created"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit($id) {
        $partner = $this->partners->findOrThrowException($id, true);

        $photooriginal = imageurl("partners/", $id, $partner->addimg);
        $photoresize = imageurl("partners/", $id, $partner->addimg, 100);

        return view('backend.partners.edit')->withPartner($partner)
            ->withPhotooriginal($photooriginal)
            ->withPhotoresize($photoresize);
    }

    /**
     * @param $id
     * @param UpdatePartnerRequest $request
     * @return mixed
     */
    public function update($id, UpdatePartnerRequest $request) {

        $partner = $this->partners->update($id, $request->except(['addimg']));


        if($request->hasFile('logo')) {
            $upload_result = $this->uploadService->editImg($request->file('logo'), $partner->name, $partner->id, 'partners', $partner->img_sizes);
            if(!isset($upload_result['error'])) $this->partners->updateLogo($partner->id, $upload_result['filename']);
        }

        return redirect()->route('admin.partners.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.partners.updated"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id) {
        $this->partners->destroy($id);
        return redirect()->back()->withFlashSuccess(trans("alerts.partners.deleted"));
    }

}