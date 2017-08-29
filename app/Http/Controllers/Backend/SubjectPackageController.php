<?PHP namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Repositories\Backend\Subject\SubjectContract;
use App\Repositories\Backend\SubjectPackage\SubjectPackageContract;
use Illuminate\Http\Request;
use App\Repositories\Backend\Package\PackageContract;
use App\Repositories\Backend\Exam\ExamContract;
use App\User;


/**
 * Class DashboardController
 * @package App\Http\Controllers\Backend
 */
class SubjectPackageController extends Controller {

    /**
     * @param SubjectContract $subjects
     */
    public function __construct(SubjectPackageContract $subjectpackages, PackageContract $packages, ExamContract $exams ) {
        $this->subjectpackages = $subjectpackages;
        $this->packages = $packages;
        $this->exams = $exams;
    }


    /**
     * @return mixed
     */
    public function index(Request $request) {
        $request->session()->put('lastpage', $request->only('page')['page']);

        $f_submit = $request->input('f_submit', '');

        $f_subject_edit = get_parameter_or_session( $request, 'f_subject_id', '', $f_submit, '' );

        return view('backend.subjects.subjectpackage-index')
            ->withSubjectpackages($this->subjectpackages->getAllSubjectPackages('id', 'asc', $f_subject_edit));
    }

    /**
     * @return mixed
     */
    public function create(Request $request) {
        $f_subject_edit = get_parameter_or_session( $request, 'f_subject_id', '', '', '' );

        return view('backend.courses.create')
            ->withPackages($this->packages->getAllPackages())
            ->withSubject( $f_subject_edit );
    }

    /**
     * @param CreateSubjectRequest $request
     * @return mixed
     */
    public function store(Request $request) {
        $f_subject_edit = get_parameter_or_session( $request, 'f_subject_id', '', '', '' );

        $subjectcourse = $this->subjectpackages->create($request, $f_subject_edit );

        return redirect()->route('admin.subjectcourses.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.subjectcourses.created"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit($id) {
        $subjectSubjectCourse = $this->subjectpackages->findOrThrowException($id, true);

        return view('backend.subjects.subjectcourse-edit')->withSubjectCourse($subjectSubjectCourse);
    }

    /**
     * @param $id
     * @param UpdateSubjectRequest $request
     * @return mixed
     */
    public function update($id, Request $request) {
        $subject = $this->subjectpackages->update($id, $request->all());

        return redirect()->route('admin.subjectpackages.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.subjectpackages.updated"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id) {
        $subCourseRelation = $this->subjectpackages->findOrThrowException($id);
        $subject = $subCourseRelation->subject;
        $subject->packages()->detach($subCourseRelation->package->id);
        return redirect()->back()->withFlashSuccess(trans("alerts.subjectcourses.deleted"));
    }


    public function addIndex(Request $request) {
        $request->session()->put('lastpage', $request->only('page')['page']);

        $packages = $this->packages->getAllPackages();

        $exams = $this->exams->getAllExams();

        return view('backend.subjects.package-add')
            ->withPackages($packages)
            ->withExams($exams);
    }

    public function add(Request $request){
        $f_subject_edit = get_parameter_or_session( $request, 'f_subject_id', '', '', '' );

        $this->subjectpackages->add($request['packages'][0], $request['exams'][0], $f_subject_edit);

        return redirect()->route('admin.subjectpackages.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.subjectcourses.addsuccess"));
    }



}