<?PHP namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Studentgroup\CreateStudentgroupRequest;
use App\Http\Requests\Backend\Studentgroup\UpdateStudentgroupRequest;
use App\Repositories\Backend\Partner\PartnerContract;
use App\Repositories\Backend\Course\CourseContract;
use App\Repositories\Backend\Studentgroup\StudentgroupContract;
use App\Services\UploadService\UploadService;
use Illuminate\Http\Request;

/**
 * Class DashboardController
 * @package App\Http\Controllers\Backend
 */
class StudentgroupController extends Controller {

    /**
     * @param StudentgroupContract $studentgroups
     */
    public function __construct(StudentgroupContract $studentgroups, UploadService $uploadService,
                                PartnerContract $partners) {
        $this->studentgroups = $studentgroups;
        $this->uploadService = $uploadService;
        $this->partners = $partners;
    }

    /**
     * @return mixed
     */
    public function index(Request $request) {
        $request->session()->put('lastpage', $request->only('page')['page']);

        $f_submit = $request->input('f_submit', '');

        $f_PartnerController_partner_id = get_parameter_or_session( $request, 'f_PartnerController_partner_id', '', $f_submit, '' );

        $partners = $this->partners->getAllPartners('name', 'asc');

        $studentgroups = $this->studentgroups->getStudentgroupsPaginated(config('access.users.default_per_page'), $f_PartnerController_partner_id, 'id', 'asc');

        return view('backend.studentgroups.index')
            ->withStudentgroups( $studentgroups )
            ->withPartners( $partners )
            ->withStudentgroupcontrollerpartnerid($f_PartnerController_partner_id);
    }

    /**
     * @return mixed
     */
    public function create() {
        $partners = $this->partners->getAllPartners('name', 'asc');
        return view('backend.studentgroups.create')
            ->withPartners( $partners );
    }

    /**
     * @param CreateStudentgroupRequest $request
     * @return mixed
     */
    public function store(CreateStudentgroupRequest $request) {
        $studentgroup = $this->studentgroups->create($request);

        return redirect()->route('admin.studentgroups.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.studentgroups.created"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit($id) {
        $studentgroup = $this->studentgroups->findOrThrowException($id, true);

        return view('backend.studentgroups.edit')->withStudentgroup($studentgroup);
    }

    /**
     * @param $id
     * @param UpdateStudentgroupRequest $request
     * @return mixed
     */
    public function update($id, UpdateStudentgroupRequest $request) {

        $studentgroup = $this->studentgroups->update($id, $request->except(['addimg']));

        return redirect()->route('admin.studentgroups.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.studentgroups.updated"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id) {
        $this->studentgroups->destroy($id);
        return redirect()->back()->withFlashSuccess(trans("alerts.studentgroups.deleted"));
    }

}