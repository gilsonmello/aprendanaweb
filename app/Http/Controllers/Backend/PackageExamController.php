<?PHP namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Repositories\Backend\Exam\ExamContract;
use App\Repositories\Backend\PackageExam\PackageExamContract;
use Illuminate\Http\Request;
use App\Repositories\Backend\Source\SourceContract;
use App\Repositories\Backend\Subject\SubjectContract;
use App\Repositories\Backend\Institution\InstitutionContract;
use App\Repositories\Backend\Office\OfficeContract;
use App\User;


/**
 * Class DashboardController
 * @package App\Http\Controllers\Backend
 */
class PackageExamController extends Controller {

    /**
     * @param ExamContract $exams
     */
    public function __construct(PackageExamContract $packageexams, ExamContract $exams ) {
        $this->packageexams = $packageexams;
        $this->exams = $exams;
    }


    /**
     * @return mixed
     */
    public function index(Request $request) {
        $request->session()->put('lastpage', $request->only('page')['page']);

        $f_package_edit = get_parameter_or_session( $request, 'f_package_id', '', '1', '' );

        return view('backend.packages.packageexam-index')
            ->withPackageexams($this->packageexams->getAllPackageExams('id', 'asc', $f_package_edit));
    }

    /**
     * @return mixed
     */
    public function create(Request $request) {
    }

    /**
     * @param CreateExamRequest $request
     * @return mixed
     */
    public function store(Request $request) {
    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit($id) {
    }

    /**
     * @param $id
     * @param UpdateExamRequest $request
     * @return mixed
     */
    public function update($id, Request $request) {
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id) {
        $this->packageexams->destroy($id);
        return redirect()->back()->withFlashSuccess(trans("alerts.exams.deleted"));
    }

    public function addIndex(Request $request) {
        $request->session()->put('lastpage', $request->only('page')['page']);

        $f_submit = $request->input('f_submit', '');

        $f_ExamController_text = get_parameter_or_session( $request, 'f_ExamController_text', '', $f_submit, '' );

        $exams = $this->exams->getExamsPaginated(config('access.users.default_per_page'), 'title', 'asc', $f_ExamController_text);

        return view('backend.packages.exam-add')
            ->withExams($exams)
            ->withExamcontrollertext($f_ExamController_text);
    }

    public function add($exam_id, Request $request){
        $f_package_edit = get_parameter_or_session( $request, 'f_package_id', '', '', '' );

        $this->packageexams->add($exam_id, $f_package_edit);

        return redirect()->route('admin.packageexams.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.packageexams.addsuccess"));
    }



}