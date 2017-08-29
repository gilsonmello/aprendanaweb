<?PHP namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\WorkshopCoordinator\CreateWorkshopCoordinatorRequest;
use App\Http\Requests\Backend\WorkshopCoordinator\UpdateWorkshopCoordinatorRequest;
use App\Repositories\Backend\WorkshopCoordinator\WorkshopCoordinatorContract;
use App\Repositories\Backend\Workshop\WorkshopContract;
use App\Services\UploadService\UploadService;
use App\User;
use App\WorkshopCoordinator;
use Illuminate\Http\Request;

/**
 * Class DashboardController
 * @package App\Http\Controllers\Backend
 */
class WorkshopCoordinatorController extends Controller {

    /**
     * @param WorkshopTutorContract $workshoptutors
     */
    public function __construct(WorkshopContract $workshop, UploadService $uploadService) {
        $this->workshop = $workshop;
        $this->uploadService = $uploadService;
    }

    /**
     * @return mixed
     */
    public function index(Request $request) {

        
    }

    /**
     * @return mixed
     */
    public function create(Request $request) {
        $request->session()->put('lastpage', $request->only('page')['page']);

        $f_submit = $request->input('f_submit', '');

        $f_workshop_id = get_parameter_or_session( $request, 'f_workshop_id', '', '', '' );
        //dd();

        return view('backend.workshopcoordinators.create')
        ->withWorkshop($this->workshop->findOrThrowException($f_workshop_id));
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