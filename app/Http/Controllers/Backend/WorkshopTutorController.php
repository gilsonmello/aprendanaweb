<?PHP namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\WorkshopTutor\CreateWorkshopTutorRequest;
use App\Http\Requests\Backend\WorkshopTutor\UpdateWorkshopTutorRequest;
use App\Repositories\Backend\WorkshopTutor\WorkshopTutorContract;
use App\Services\UploadService\UploadService;
use App\User;
use App\WorkshopCriteria;
use Illuminate\Http\Request;

/**
 * Class DashboardController
 * @package App\Http\Controllers\Backend
 */
class WorkshopTutorController extends Controller {

    /**
     * @param WorkshopTutorContract $workshoptutors
     */
    public function __construct(WorkshopTutorContract $workshoptutors, UploadService $uploadService) {
        $this->workshoptutors = $workshoptutors;
        $this->uploadService = $uploadService;
    }

    /**
     * @return mixed
     */
    public function index(Request $request) {
        $request->session()->put('lastpage', $request->only('page')['page']);

        $f_submit = $request->input('f_submit', '');

        $f_workshop_edit = get_parameter_or_session( $request, 'f_workshop_id', '', '', '' );

        return view('backend.workshoptutors.index')
            ->withWorkshoptutors($this->workshoptutors->getWorkshopTutorsPaginated(config('access.users.default_per_page'), 'position', 'asc', $f_workshop_edit))
            ->withWorkshop($f_workshop_edit);
    }

    /**
     * @return mixed
     */
    public function create(Request $request) {
        $tutors = User::teachers()->orderBy('name', 'asc');

        $f_workshop_edit = get_parameter_or_session( $request, 'f_workshop_id', '', '', '' );

        $criterias = WorkshopCriteria::where('workshop_id', '=', $f_workshop_edit)->get();

        return view('backend.workshoptutors.create')
            ->withTutors($tutors)
            ->withCriterias($criterias);
    }

    /**
     * @param CreateWorkshopTutorRequest $request
     * @return mixed
     */
    public function store(CreateWorkshopTutorRequest $request) {
        $f_workshop_edit = get_parameter_or_session( $request, 'f_workshop_id', '', '', '' );

        $workshoptutor = $this->workshoptutors->create($request, $f_workshop_edit);

        return redirect()->route('admin.workshoptutors.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.workshoptutors.created"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit($id) {
        $workshoptutor = $this->workshoptutors->findOrThrowException($id, true);

        return view('backend.workshoptutors.edit')->withWorkshopTutor($workshoptutor);
    }

    /**
     * @param $id
     * @param UpdateWorkshopTutorRequest $request
     * @return mixed
     */
    public function update($id, UpdateWorkshopTutorRequest $request) {

        $workshoptutor = $this->workshoptutors->update($id, $request->except(['addimg']));

        return redirect()->route('admin.workshoptutors.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.workshoptutors.updated"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id) {
        $this->workshoptutors->destroy($id);
        return redirect()->back()->withFlashSuccess(trans("alerts.workshoptutors.deleted"));
    }

}