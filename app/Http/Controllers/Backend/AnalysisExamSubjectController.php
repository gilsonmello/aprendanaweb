<?PHP namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Repositories\Backend\Subject\SubjectContract;
use App\Repositories\Backend\AnalysisExamSubject\AnalysisExamSubjectContract;
use Illuminate\Http\Request;
use App\Repositories\Backend\Course\CourseContract;
use App\Repositories\Backend\Exam\ExamContract;
use App\User;


/**
 * Class DashboardController
 * @package App\Http\Controllers\Backend
 */
class AnalysisExamSubjectController extends Controller {

    /**
     * @param SubjectContract $subjects
     */
    public function __construct(AnalysisExamSubjectContract $analysisexamsubjects, SubjectContract $subjects ) {
        $this->analysisexamsubjects = $analysisexamsubjects;
        $this->subjects = $subjects;
    }


    /**
     * @return mixed
     */
    public function index(Request $request) {
        $request->session()->put('lastpage', $request->only('page')['page']);

        $f_submit = $request->input('f_submit', '');

        $f_analysisexam_edit = get_parameter_or_session( $request, 'f_analysisexam_id', '', $f_submit, '' );

        return view('backend.analysisexams.analysisexamsubject-index')
            ->withAnalysisexamsubjects($this->analysisexamsubjects->getAllAnalysisExamSubjects('id', 'asc', $f_analysisexam_edit));
    }

    /**
     * @return mixed
     */
    public function create(Request $request) {
        $f_analysisexam_edit = get_parameter_or_session( $request, 'f_subject_id', '', '', '' );

        return view('backend.courses.create')
            ->withCourses($this->courses->getAllCourses())
            ->withSubject( $f_analysisexam_edit );
    }

    /**
     * @param CreateSubjectRequest $request
     * @return mixed
     */
    public function store(Request $request) {
        $f_analysisexam_edit = get_parameter_or_session( $request, 'f_analysisexam_edit', '', '', '' );

        $analysisexamsubject = $this->analysisexamsubjects->create($request, $f_analysisexam_edit );

        return redirect()->route('admin.analysisexamsubjects.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.analysisexamsubjects.created"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit($id) {
        $subjectAnalysisExamSubject = $this->analysisexamsubjects->findOrThrowException($id, true);

        return view('backend.subjects.analysisexamsubject-edit')->withAnalysisExamSubject($subjectAnalysisExamSubject);
    }

    /**
     * @param $id
     * @param UpdateSubjectRequest $request
     * @return mixed
     */
    public function update($id, Request $request) {
        $subject = $this->analysisexamsubjects->update($id, $request->all());

        return redirect()->route('admin.analysisexamsubjects.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.analysisexamsubjects.updated"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id) {
        $subCourseRelation = $this->analysisexamsubjects->findOrThrowException($id);

        $subCourseRelation->delete();
//        $subject = $subCourseRelation->subject;
//        $subject->courses()->detach($subCourseRelation->course->id);
        return redirect()->back()->withFlashSuccess(trans("alerts.analysisexamsubjects.deleted"));
    }


    public function addIndex(Request $request) {
        $request->session()->put('lastpage', $request->only('page')['page']);

        $subject_list = $this->subjects->getSubjectByLevel(2);
        foreach ($subject_list as $subject) {
            $subject->name = ($subject->parent != null ? '[' . $subject->parent->name . '] - ' . $subject->name : '');
        }


        return view('backend.analysisexams.analysisexamsubject-add')->withSubjects_list($subject_list);
    }

    public function add(Request $request){
        $f_analysisexam_edit = get_parameter_or_session( $request, 'f_analysisexam_id', '', '', '' );

        $this->analysisexamsubjects->add($request['subjects'][0], $request['count'], $f_analysisexam_edit);

        return redirect()->route('admin.analysisexamsubjects.index')->withFlashSuccess(trans("alerts.analysisexamsubjects.addsuccess"));
    }



}