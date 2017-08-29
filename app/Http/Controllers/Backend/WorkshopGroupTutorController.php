<?PHP namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\WorkshopGroupTutor\CreateWorkshopGroupTutorRequest;
use App\Http\Requests\Backend\WorkshopGroupTutor\UpdateWorkshopGroupTutorRequest;
use App\Repositories\Backend\WorkshopGroupTutor\WorkshopGroupTutorContract;
use App\Services\UploadService\UploadService;
use App\User;
use App\WorkshopActivity;
use App\WorkshopCriteria;
use Illuminate\Http\Request;

/**
 * Class DashboardController
 * @package App\Http\Controllers\Backend
 */
class WorkshopGroupTutorController extends Controller {

    /**
     * @param WorkshopGroupTutorContract $workshopgrouptutors
     */
    public function __construct(WorkshopGroupTutorContract $workshopgrouptutors, UploadService $uploadService) {
        $this->workshopgrouptutors = $workshopgrouptutors;
        $this->uploadService = $uploadService;
    }

    /**
     * @return mixed
     */
    public function index(Request $request) {
        $request->session()->put('lastpage', $request->only('page')['page']);

        $f_submit = $request->input('f_submit', '');

        $f_evaluationgroup_edit = get_parameter_or_session( $request, 'f_evaluationgroup_id', '', '', '' );

        return view('backend.workshopgrouptutors.index')
            ->withWorkshopgrouptutors($this->workshopgrouptutors->getWorkshopGroupTutorsPaginated(config('access.users.default_per_page'), 'id', 'asc', $f_evaluationgroup_edit))
            ->withEvaluationgroup($f_evaluationgroup_edit);
    }

    /**
     * @return mixed
     */
    public function create(Request $request) {
        $tutors = User::teachers()->orderBy('name', 'asc');

        $f_workshop_edit = get_parameter_or_session( $request, 'f_workshop_id', '', '', '' );

        $activities = WorkshopActivity::where('workshop_id', '=', $f_workshop_edit)->get();

        return view('backend.workshopgrouptutors.create')
            ->withTutors($tutors)
            ->withActivities($activities );
    }

    /**
     * @param CreateWorkshopGroupTutorRequest $request
     * @return mixed
     */
    public function store(CreateWorkshopGroupTutorRequest $request) {
        $f_evaluationgroup_edit = get_parameter_or_session( $request, 'f_evaluationgroup_id', '', '', '' );

        $workshopgrouptutor = $this->workshopgrouptutors->create($request, $f_evaluationgroup_edit);

        return redirect()->route('admin.workshopgrouptutors.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.workshopgrouptutors.created"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit($id) {
        $workshopgrouptutor = $this->workshopgrouptutors->findOrThrowException($id, true);

        return view('backend.workshopgrouptutors.edit')->withWorkshopgrouptutor($workshopgrouptutor);
    }

    /**
     * @param $id
     * @param UpdateWorkshopGroupTutorRequest $request
     * @return mixed
     */
    public function update($id, UpdateWorkshopGroupTutorRequest $request) {

        $workshopgrouptutor = $this->workshopgrouptutors->update($id, $request->except(['addimg']));

        return redirect()->route('admin.workshopgrouptutors.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.workshopgrouptutors.updated"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id) {
        $this->workshopgrouptutors->destroy($id);
        return redirect()->back()->withFlashSuccess(trans("alerts.workshopgrouptutors.deleted"));
    }

}