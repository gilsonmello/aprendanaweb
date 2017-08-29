<?PHP namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Institution\CreateInstitutionRequest;
use App\Http\Requests\Backend\Institution\UpdateInstitutionRequest;
use App\Repositories\Backend\Institution\InstitutionContract;
use App\Services\UploadService\UploadService;
use Illuminate\Http\Request;

/**
 * Class DashboardController
 * @package App\Http\Controllers\Backend
 */
class InstitutionController extends Controller {

    /**
     * @param InstitutionContract $institutions
     */
    public function __construct(InstitutionContract $institutions, UploadService $uploadService) {
        $this->institutions = $institutions;
        $this->uploadService = $uploadService;
    }

    /**
     * @return mixed
     */
    public function index(Request $request) {
        $request->session()->put('lastpage', $request->only('page')['page']);

        $f_submit = $request->input('f_submit', '');

        $f_InstitutionController_name = get_parameter_or_session( $request, 'f_InstitutionController_name', '', $f_submit, '' );

        return view('backend.institutions.index')
            ->withInstitutions($this->institutions->getInstitutionsPaginated(config('access.users.default_per_page'), 'name', 'asc', $f_InstitutionController_name))
            ->withInstitutioncontrollername($f_InstitutionController_name);
    }

    /**
     * @return mixed
     */
    public function create() {
        return view('backend.institutions.create');
    }

    /**
     * @param CreateInstitutionRequest $request
     * @return mixed
     */
    public function store(CreateInstitutionRequest $request) {
        $institution = $this->institutions->create($request);

        if($request->hasFile('addimg')) {
            $upload_result = $this->uploadService->addImg($request->file('addimg'), $institution->name, $institution->id, 'institutions');
            if(!isset($upload_result['error'])) $this->institutions->updateImg($institution->id, $upload_result['filename']);
        }

        return redirect()->route('admin.institutions.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.institutions.created"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit($id) {
        $institution = $this->institutions->findOrThrowException($id, true);

        $photooriginal = imageurl("institutions/", $id, $institution->addimg);
        $photoresize = imageurl("institutions/", $id, $institution->addimg, 100);

        return view('backend.institutions.edit')->withInstitution($institution)
            ->withPhotooriginal($photooriginal)
            ->withPhotoresize($photoresize);
    }

    /**
     * @param $id
     * @param UpdateInstitutionRequest $request
     * @return mixed
     */
    public function update($id, UpdateInstitutionRequest $request) {

        $institution = $this->institutions->update($id, $request->except(['addimg']));

        if($request->hasFile('addimg')) {
            $upload_result = $this->uploadService->editImg($request->file('addimg'), $institution->name, $institution->id, 'institutions', $institution->img_sizes);
            if(!isset($upload_result['error'])) $this->institutions->updateImg($institution->id, $upload_result['filename']);
        }

        return redirect()->route('admin.institutions.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.institutions.updated"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id) {
        $this->institutions->destroy($id);
        return redirect()->back()->withFlashSuccess(trans("alerts.institutions.deleted"));
    }

}