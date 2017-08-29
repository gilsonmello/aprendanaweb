<?PHP namespace App\Http\Controllers\Backend;

use App\Repositories\Backend\User\UserContract;
use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Workshop\CreateWorkshopRequest;
use App\Http\Requests\Backend\Workshop\UpdateWorkshopRequest;
use App\Repositories\Backend\Course\CourseContract;
use App\Repositories\Backend\Workshop\WorkshopContract;
use App\Services\UploadService\UploadService;
use App\WorkshopTutor;
use App\WorkshopEvaluationGroup;
use Illuminate\Http\Request;

/**
 * Class DashboardController
 * @package App\Http\Controllers\Backend
 */
class WorkshopController extends Controller {

    /**
     * @param WorkshopContract $workshops
     */
    public function __construct(WorkshopContract $workshops, UploadService $uploadService, CourseContract $courses, UserContract $teachers) {
        $this->workshops = $workshops;
        $this->uploadService = $uploadService;
        $this->courses = $courses;
        $this->teachers = $teachers;
    }

    /**
     * @return mixed
     */
    public function index(Request $request) {
        $request->session()->put('lastpage', $request->only('page')['page']);

        $f_submit = $request->input('f_submit', '');

        $f_WorkshopController_description = get_parameter_or_session( $request, 'f_WorkshopController_description', '', $f_submit, '' );

        return view('backend.workshops.index')
            ->withWorkshops($this->workshops->getWorkshopsPaginated(config('access.users.default_per_page'), 'description', 'asc', $f_WorkshopController_description))
            ->withWorkshopcontrollerdescription($f_WorkshopController_description);
    }

    /**
     * @return mixed
     */
    public function create() {
        $courses = $this->courses->getAllCourses();

        return view('backend.workshops.create')
            ->withCourses($courses)
            ->withTeachers($this->teachers->getOnlyTeachers());
    }

    /**
     * @param CreateWorkshopRequest $request
     * @return mixed
     */
    public function store(CreateWorkshopRequest $request) {
        $workshop = $this->workshops->create($request);

        return redirect()->route('admin.workshops.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.workshops.created"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit($id) {
        $workshop = $this->workshops->findOrThrowException($id, true);
        $tutors = WorkshopTutor::where('workshop_id', '=', $id)->get();
        $evaluationgroups = WorkshopEvaluationGroup::where('workshop_id', '=', $id)->get();
        return view('backend.workshops.edit')
            ->withWorkshop($workshop)
            ->withTutors($tutors)
            ->withEvaluationgroups($evaluationgroups)
            ->withTeachers($this->teachers->getOnlyTeachers());
    }

    /**
     * @param $id
     * @param UpdateWorkshopRequest $request
     * @return mixed
     */
    public function update($id, UpdateWorkshopRequest $request) {
        $teachers = $request->only('teachers');
        $workshop = $this->workshops->update($id, $request->except(['addimg', 'teachers']), $teachers);

        return redirect()->route('admin.workshops.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.workshops.updated"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id) {
        $this->workshops->destroy($id);
        return redirect()->back()->withFlashSuccess(trans("alerts.workshops.deleted"));
    }

}