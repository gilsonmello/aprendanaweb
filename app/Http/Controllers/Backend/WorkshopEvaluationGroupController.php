<?PHP namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\WorkshopEvaluationGroup\CreateWorkshopEvaluationGroupRequest;
use App\Http\Requests\Backend\WorkshopEvaluationGroup\UpdateWorkshopEvaluationGroupRequest;
use App\Repositories\Backend\WorkshopEvaluationGroup\WorkshopEvaluationGroupContract;
use App\Services\UploadService\UploadService;
use App\User;
use App\WorkshopCriteria;
use Illuminate\Http\Request;

/**
 * Class DashboardController
 * @package App\Http\Controllers\Backend
 */
class WorkshopEvaluationGroupController extends Controller {

    /**
     * @param WorkshopEvaluationGroupContract $workshopevaluationgroups
     */
    public function __construct(WorkshopEvaluationGroupContract $workshopevaluationgroups, UploadService $uploadService) {
        $this->workshopevaluationgroups = $workshopevaluationgroups;
        $this->uploadService = $uploadService;
    }

    /**
     * @return mixed
     */
    public function index(Request $request) {
        $request->session()->put('lastpage', $request->only('page')['page']);

        $f_submit = $request->input('f_submit', '');

        $f_workshop_edit = get_parameter_or_session( $request, 'f_workshop_id', '', '', '' );

        return view('backend.workshopevaluationgroups.index')
            ->withWorkshopevaluationgroups($this->workshopevaluationgroups->getWorkshopEvaluationGroupsPaginated(config('access.users.default_per_page'), 'position', 'asc', $f_workshop_edit))
            ->withWorkshop($f_workshop_edit);
    }

    /**
     * @return mixed
     */
    public function create(Request $request) {
        $tutors = User::teachers()->orderBy('name', 'asc');

        $f_workshop_edit = get_parameter_or_session( $request, 'f_workshop_id', '', '', '' );

        $criterias = WorkshopCriteria::where('workshop_id', '=', $f_workshop_edit)->get();

        return view('backend.workshopevaluationgroups.create');
    }

    /**
     * @param CreateWorkshopEvaluationGroupRequest $request
     * @return mixed
     */
    public function store(CreateWorkshopEvaluationGroupRequest $request) {
        $f_workshop_edit = get_parameter_or_session( $request, 'f_workshop_id', '', '', '' );

        $workshopevaluationgroup = $this->workshopevaluationgroups->create($request, $f_workshop_edit);

        return redirect()->route('admin.workshopevaluationgroups.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.workshopevaluationgroups.created"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit($id) {
        $workshopevaluationgroup = $this->workshopevaluationgroups->findOrThrowException($id, true);

        return view('backend.workshopevaluationgroups.edit')->withWorkshopevaluationgroup($workshopevaluationgroup);
    }

    /**
     * @param $id
     * @param UpdateWorkshopEvaluationGroupRequest $request
     * @return mixed
     */
    public function update($id, UpdateWorkshopEvaluationGroupRequest $request) {

        $workshopevaluationgroup = $this->workshopevaluationgroups->update($id, $request->except(['addimg']));

        return redirect()->route('admin.workshopevaluationgroups.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.workshopevaluationgroups.updated"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id) {
        $this->workshopevaluationgroups->destroy($id);
        return redirect()->back()->withFlashSuccess(trans("alerts.workshopevaluationgroups.deleted"));
    }

}