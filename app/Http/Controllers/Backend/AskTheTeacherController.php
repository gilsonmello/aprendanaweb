<?PHP namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\AskTheTeacher\CreateAskTheTeacherRequest;
use App\Http\Requests\Backend\AskTheTeacher\UpdateAskTheTeacherRequest;
use App\Repositories\Backend\AskTheTeacher\AskTheTeacherContract;
use App\Repositories\Backend\User\UserContract;
use App\Services\UploadService\UploadService;
use Illuminate\Http\Request;


/**
 * Class DashboardControllerapp/Http/Controllers/Backend/AskTheTeacherController.php:7
 * @package App\Http\Controllers\Backend
 */
class AskTheTeacherController extends Controller {

    /**
     * @param AskTheTeacherContract $asktheteachers
     * @param UserContract $users
     * @param UploadService $uploadService
     */
    public function __construct(AskTheTeacherContract $asktheteachers, UserContract $users, UploadService $uploadService) {
        $this->asktheteachers = $asktheteachers;
        $this->users = $users;
        $this->uploadService = $uploadService;
    }

    /**
     * @return mixed
     */
    public function askTheTutors(Request $request) {
        $request->session()->put('lastpage', $request->only('page')['page']);


        $f_submit = $request->input('f_submit', '');

        $f_AskTheTeacherController_question = get_parameter_or_session( $request, 'f_AskTheTutorController_question', '', $f_submit, '' );

        $f_AskTheTeacherController_is_replied = get_parameter_or_session( $request, 'f_AskTheTutorController_is_replied', '', $f_submit, '0' );

        return view('backend.askthetutors.index')
            ->withAsktheteachers($this->asktheteachers->getAskTheTutorsPaginated(config('access.users.default_per_page'), 'id', 'desc', $f_AskTheTeacherController_question, $f_AskTheTeacherController_is_replied))
            ->withAsktheteachercontrollerquestion($f_AskTheTeacherController_question)
            ->withAsktheteachercontrollerisreplied($f_AskTheTeacherController_is_replied);
    
    }

    /**
     * @return mixed
     */
    public function index(Request $request) {
        $request->session()->put('lastpage', $request->only('page')['page']);

        $f_submit = $request->input('f_submit', '');

        $f_AskTheTeacherController_question = get_parameter_or_session( $request, 'f_AskTheTeacherController_question', '', $f_submit, '' );

        $f_AskTheTeacherController_is_replied = get_parameter_or_session( $request, 'f_AskTheTeacherController_is_replied', '', $f_submit, '0' );

        return view('backend.asktheteachers.index')
            ->withAsktheteachers($this->asktheteachers->getAskTheTeachersPaginated(config('access.users.default_per_page'), 'id', 'desc', $f_AskTheTeacherController_question, $f_AskTheTeacherController_is_replied))
            ->withAsktheteachercontrollerquestion($f_AskTheTeacherController_question)
            ->withAsktheteachercontrollerisreplied($f_AskTheTeacherController_is_replied);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function askTheTutorEdit($id) {
        $asktheteacher = $this->asktheteachers->findOrThrowException($id, true);
        return view('backend.askthetutors.edit')->withAsktheteacher($asktheteacher);
    }

    /**
     * @return mixed
     */
    public function create() {
        return view('backend.asktheteachers.create')->withTeachers($this->users->getOnlyTeachers());
    }

    /**
     * @param CreateAskTheTeacherRequest $request
     * @return mixed
     */
    public function storeAskTheTutor(CreateAskTheTeacherRequest $request) {
        $asktheteacher = $this->asktheteachers->create($request);

        return redirect()->route('admin.askthetutor.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.asktheteachers.created"));
    }

    /**
     * @param CreateAskTheTeacherRequest $request
     * @return mixed
     */
    public function store(CreateAskTheTeacherRequest $request) {
        $asktheteacher = $this->asktheteachers->create($request);

        return redirect()->route('admin.asktheteachers.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.asktheteachers.created"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit($id) {
        $asktheteacher = $this->asktheteachers->findOrThrowException($id, true);
        return view('backend.asktheteachers.edit')->withAsktheteacher($asktheteacher);
    }

    /**
     * @param $id
     * @param UpdateAskTheTeacherRequest $request
     * @return mixed
     */
    public function updateAskTheTutor($id, UpdateAskTheTeacherRequest $request) {
        $asktheteacher = $this->asktheteachers->update($id, $request->all());

        return redirect()->route('admin.askthetutors.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.asktheteachers.updated"));
    }

    /**
     * @param $id
     * @param UpdateAskTheTeacherRequest $request
     * @return mixed
     */
    public function update($id, UpdateAskTheTeacherRequest $request) {
        $asktheteacher = $this->asktheteachers->update($id, $request->all());

        return redirect()->route('admin.asktheteachers.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.asktheteachers.updated"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id) {
        $this->asktheteachers->destroy($id);
        return redirect()->back()->withFlashSuccess(trans("alerts.asktheteachers.deleted"));
    }

}