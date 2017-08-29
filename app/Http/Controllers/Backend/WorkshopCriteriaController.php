<?PHP namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\WorkshopCriteria\CreateWorkshopCriteriaRequest;
use App\Http\Requests\Backend\WorkshopCriteria\UpdateWorkshopCriteriaRequest;
use App\Repositories\Backend\WorkshopCriteria\WorkshopCriteriaContract;
use App\Services\UploadService\UploadService;
use Illuminate\Http\Request;

/**
 * Class DashboardController
 * @package App\Http\Controllers\Backend
 */
class WorkshopCriteriaController extends Controller {

    /**
     * @param WorkshopCriteriaContract $workshopcriterias
     */
    public function __construct(WorkshopCriteriaContract $workshopcriterias, UploadService $uploadService) {
        $this->workshopcriterias = $workshopcriterias;
        $this->uploadService = $uploadService;
    }

    /**
     * @return mixed
     */
    public function index(Request $request) {
        $request->session()->put('lastpage', $request->only('page')['page']);

        $f_submit = $request->input('f_submit', '');

        $f_workshop_edit = get_parameter_or_session( $request, 'f_workshop_id', '', '', '' );

        return view('backend.workshopcriterias.index')
            ->withWorkshopcriterias($this->workshopcriterias->getWorkshopCriteriasPaginated(config('access.users.default_per_page'), 'description', 'asc', $f_workshop_edit))
            ->withWorkshop($f_workshop_edit);
    }

    /**
     * @return mixed
     */
    public function create() {
        return view('backend.workshopcriterias.create');
    }

    /**
     * @param CreateWorkshopCriteriaRequest $request
     * @return mixed
     */
    public function store(CreateWorkshopCriteriaRequest $request) {
        $f_workshop_edit = get_parameter_or_session( $request, 'f_workshop_id', '', '', '' );

        $workshopcriteria = $this->workshopcriterias->create($request, $f_workshop_edit);

        return redirect()->route('admin.workshopcriterias.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.workshopcriterias.created"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit($id) {
        $workshopcriteria = $this->workshopcriterias->findOrThrowException($id, true);

        return view('backend.workshopcriterias.edit')->withWorkshopcriteria($workshopcriteria);
    }

    /**
     * @param $id
     * @param UpdateWorkshopCriteriaRequest $request
     * @return mixed
     */
    public function update($id, UpdateWorkshopCriteriaRequest $request) {

        $workshopcriteria = $this->workshopcriterias->update($id, $request->except(['addimg']));

        return redirect()->route('admin.workshopcriterias.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.workshopcriterias.updated"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id) {
        $this->workshopcriterias->destroy($id);
        return redirect()->back()->withFlashSuccess(trans("alerts.workshopcriterias.deleted"));
    }

}