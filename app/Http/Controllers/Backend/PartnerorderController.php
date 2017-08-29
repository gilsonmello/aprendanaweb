<?PHP namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Partnerorder\CreatePartnerorderRequest;
use App\Http\Requests\Backend\Partnerorder\UpdatePartnerorderRequest;
use App\Repositories\Backend\Partner\PartnerContract;
use App\Repositories\Backend\Course\CourseContract;
use App\Repositories\Backend\Partnerorder\PartnerorderContract;
use App\Services\UploadService\UploadService;
use Illuminate\Http\Request;

/**
 * Class DashboardController
 * @package App\Http\Controllers\Backend
 */
class PartnerorderController extends Controller {

    /**
     * @param PartnerorderContract $partnerorders
     */
    public function __construct(PartnerorderContract $partnerorders, UploadService $uploadService,
                                PartnerContract $partners, CourseContract $courses) {
        $this->partnerorders = $partnerorders;
        $this->uploadService = $uploadService;
        $this->partners = $partners;
        $this->courses = $courses;
    }

    /**
     * @return mixed
     */
    public function index(Request $request) {
        $request->session()->put('lastpage', $request->only('page')['page']);

        $f_submit = $request->input('f_submit', '');

        $f_PartnerController_partner_id = get_parameter_or_session( $request, 'f_PartnerController_partner_id', '', $f_submit, '' );

        $partners = $this->partners->getAllPartners('name', 'asc');

        $partnerorders = $this->partnerorders->getPartnerordersPaginated(config('access.users.default_per_page'), $f_PartnerController_partner_id, 'id', 'asc');

        return view('backend.partnerorders.index')
            ->withPartnerorders( $partnerorders )
            ->withPartners( $partners )
            ->withPartnerordercontrollerpartnerid($f_PartnerController_partner_id);
    }

    /**
     * @return mixed
     */
    public function create() {
        $partners = $this->partners->getAllPartners('name', 'asc');
        $courses = $this->courses->getAllCourses('title', 'asc');
        return view('backend.partnerorders.create')
            ->withPartners( $partners )
            ->withCourses( $courses );
    }

    /**
     * @param CreatePartnerorderRequest $request
     * @return mixed
     */
    public function store(CreatePartnerorderRequest $request) {
        $partnerorder = $this->partnerorders->create($request);

        if($request->hasFile('addimg')) {
            $upload_result = $this->uploadService->addImg($request->file('addimg'), $partnerorder->name, $partnerorder->id, 'partnerorders');
            if(!isset($upload_result['error'])) $this->partnerorders->updateImg($partnerorder->id, $upload_result['filename']);
        }

        return redirect()->route('admin.partnerorders.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.partnerorders.created"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit($id) {
        $partnerorder = $this->partnerorders->findOrThrowException($id, true);

        return view('backend.partnerorders.edit')->withPartnerorder($partnerorder);
    }

    /**
     * @param $id
     * @param UpdatePartnerorderRequest $request
     * @return mixed
     */
    public function update($id, UpdatePartnerorderRequest $request) {

        $partnerorder = $this->partnerorders->update($id, $request->except(['addimg']));

        if($request->hasFile('addimg')) {
            $upload_result = $this->uploadService->editImg($request->file('addimg'), $partnerorder->name, $partnerorder->id, 'partnerorders', $partnerorder->img_sizes);
            if(!isset($upload_result['error'])) $this->partnerorders->updateImg($partnerorder->id, $upload_result['filename']);
        }

        return redirect()->route('admin.partnerorders.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.partnerorders.updated"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id) {
        $this->partnerorders->destroy($id);
        return redirect()->back()->withFlashSuccess(trans("alerts.partnerorders.deleted"));
    }

}