<?PHP namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Subject\CreateSubjectRequest;
use App\Http\Requests\Backend\Subject\UpdateSubjectRequest;
use App\Repositories\Backend\Subject\SubjectContract;
use App\Services\UploadService\UploadService;
use Illuminate\Http\Request;

/**
 * Class DashboardController
 * @package App\Http\Controllers\Backend
 */
class SubjectController extends Controller {

    /**
     * @param SubjectContract $subjects
     */
    public function __construct(SubjectContract $subjects, UploadService $uploadService) {
        $this->subjects = $subjects;
        $this->uploadService = $uploadService;
    }

    /**
     * @return mixed
     */
    public function index(Request $request) {

        $request->session()->put('lastpage', $request->only('page')['page']);

        $f_submit = $request->input('f_submit', '');

        $f_SubjectController_name = get_parameter_or_session( $request, 'f_SubjectController_name', '', $f_submit, '' );

        $f_SubjectController_subject_id = get_parameter_or_session( $request, 'f_SubjectController_subject_id', '', $f_submit, '' );

        return view('backend.subjects.index')
            ->withSubjects(
                $this->subjects->getSubjectsPaginated(
                    config('access.users.default_per_page'),
                    'name',
                    'asc',
                    $f_SubjectController_name,
                    $f_SubjectController_subject_id
                )
            )
            ->withSubject1and2($this->subjects->getSubjectsLevel1and2())
            ->withSubjectcontrollername($f_SubjectController_name)
            ->withSubjectcontrollersubjectid($f_SubjectController_subject_id);
    }

    /**
     * @return mixed
     */
    public function create() {
        return view('backend.subjects.create')->withSubjects($this->subjects->getSubjectsLevel1and2());
    }

    /**
     * @param CreateSubjectRequest $request
     * @return mixed
     */
    public function store(CreateSubjectRequest $request) {
        $subject = $this->subjects->create($request);

        return redirect()->route('admin.subjects.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.subjects.created"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit($id) {
        $subject = $this->subjects->findOrThrowException($id, true);

        return view('backend.subjects.edit')->withSubject($subject)->withSubjects($this->subjects->getAllSubjects());
    }

    /**
     * @param $id
     * @param UpdateSubjectRequest $request
     * @return mixed
     */
    public function update($id, UpdateSubjectRequest $request) {

        $subject = $this->subjects->update($id, $request->except(['addimg']));

        return redirect()->route('admin.subjects.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.subjects.updated"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id) {
        $this->subjects->destroy($id);
        return redirect()->back()->withFlashSuccess(trans("alerts.subjects.deleted"));
    }



    public function selectSubject() {


        $subject_list = $this->subjects->getSubjectByLevel(2,'name','name',$_POST['term']);

        $subject_list = $subject_list->reject(function($item){
            return $item->children->pluck('questions')->isEmpty();
        });
        $list = [];


        foreach ($subject_list as $subject) {
            if($subject->parent != null) {
                $list[] = ['id' => $subject->id, 'text' => "[" . $subject->parent->name . "] " . $subject->name];
            }
        }

        return json_encode($list);
    }

}