<?PHP namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Group\CreateGroupRequest;
use App\Http\Requests\Backend\Group\UpdateGroupRequest;
use App\Repositories\Backend\Exam\ExamContract;
use App\Repositories\Backend\Group\GroupContract;
use Illuminate\Http\Request;

/**
 * Class DashboardController
 * @package App\Http\Controllers\Backend
 */
class GroupController extends Controller {

    /**
     * @param ExamContract $exams
     */
    public function __construct(GroupContract $groups) {
        $this->groups = $groups;
    }


    /**
     * @return mixed
     */
    public function index(Request $request) {
        $request->session()->put('lastpage', $request->only('page')['page']);

        $f_submit = $request->input('f_submit', '');

        $f_exam_edit = get_parameter_or_session( $request, 'f_exam_id', '', $f_submit, '' );

        return view('backend.exams.group-index')
            ->withGroups($this->groups->getGroupsPaginated(config('access.users.default_per_page'), 'id', 'asc', $f_exam_edit));
    }

    /**
     * @return mixed
     */
    public function create(Request $request) {
        return view('backend.exams.group-create');
    }

    /**
     * @param CreateExamRequest $request
     * @return mixed
     */
    public function store(CreateGroupRequest $request) {
        $f_exam_edit = get_parameter_or_session( $request, 'f_exam_id', '', '', '' );

        $group = $this->groups->create($request, $f_exam_edit );

        return redirect()->route('admin.groups.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.exams.group.created"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit($id) {
        $examGroup = $this->groups->findOrThrowException($id, true);

        return view('backend.exams.group-edit')->withGroup($examGroup);
    }

    /**
     * @param $id
     * @param UpdateExamRequest $request
     * @return mixed
     */
    public function update($id, UpdateGroupRequest $request) {
        $exam = $this->groups->update($id, $request->all());

        return redirect()->route('admin.groups.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.exams.updated"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id) {
        $this->groups->destroy($id);
        return redirect()->back()->withFlashSuccess(trans("alerts.exams.deleted"));
    }


}