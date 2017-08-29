<?PHP namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Repositories\Backend\Subject\SubjectContract;
use App\Repositories\Backend\SubjectCourse\SubjectCourseContract;
use Illuminate\Http\Request;
use App\Repositories\Backend\Course\CourseContract;
use App\Repositories\Backend\Exam\ExamContract;
use App\User;


/**
 * Class DashboardController
 * @package App\Http\Controllers\Backend
 */
class SubjectCourseController extends Controller {

    /**
     * @param SubjectContract $subjects
     */
    public function __construct(SubjectCourseContract $subjectcourses, CourseContract $courses, ExamContract $exams ) {
        $this->subjectcourses = $subjectcourses;
        $this->courses = $courses;
        $this->exams = $exams;
    }


    /**
     * @return mixed
     */
    public function index(Request $request) {
        $request->session()->put('lastpage', $request->only('page')['page']);

        $f_submit = $request->input('f_submit', '');

        $f_subject_edit = get_parameter_or_session( $request, 'f_subject_id', '', $f_submit, '' );

        return view('backend.subjects.subjectcourse-index')
            ->withSubjectcourses($this->subjectcourses->getAllSubjectCourses('id', 'asc', $f_subject_edit));
    }

    /**
     * @return mixed
     */
    public function create(Request $request) {
        $f_subject_edit = get_parameter_or_session( $request, 'f_subject_id', '', '', '' );

        return view('backend.courses.create')
            ->withCourses($this->courses->getAllCourses())
            ->withSubject( $f_subject_edit );
    }

    /**
     * @param CreateSubjectRequest $request
     * @return mixed
     */
    public function store(Request $request) {
        $f_subject_edit = get_parameter_or_session( $request, 'f_subject_id', '', '', '' );

        $subjectcourse = $this->subjectcourses->create($request, $f_subject_edit );

        return redirect()->route('admin.subjectcourses.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.subjectcourses.created"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit($id) {
        $subjectSubjectCourse = $this->subjectcourses->findOrThrowException($id, true);

        return view('backend.subjects.subjectcourse-edit')->withSubjectCourse($subjectSubjectCourse);
    }

    /**
     * @param $id
     * @param UpdateSubjectRequest $request
     * @return mixed
     */
    public function update($id, Request $request) {
        $subject = $this->subjectcourses->update($id, $request->all());

        return redirect()->route('admin.subjectcourses.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.subjectcourses.updated"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id) {
        $subCourseRelation = $this->subjectcourses->findOrThrowException($id);

        $subCourseRelation->delete();
//        $subject = $subCourseRelation->subject;
//        $subject->courses()->detach($subCourseRelation->course->id);
        return redirect()->back()->withFlashSuccess(trans("alerts.subjectcourses.deleted"));
    }


    public function addIndex(Request $request) {
        $request->session()->put('lastpage', $request->only('page')['page']);

        $courses = $this->courses->getAllCourses();

        $exams = $this->exams->getAllExams();

        return view('backend.subjects.course-add')
            ->withCourses($courses)
            ->withExams($exams);
    }

    public function add(Request $request){
        $f_subject_edit = get_parameter_or_session( $request, 'f_subject_id', '', '', '' );

        $this->subjectcourses->add($request['courses'][0], $request['exams'][0], $f_subject_edit);

        return redirect()->route('admin.subjectcourses.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.subjectcourses.addsuccess"));
    }


    /**
     * @return mixed
     */
    public function conference(Request $request) {
        return view('backend.subjects.subjectcourse-conference')
            ->withSubjectcourses($this->subjectcourses->getAllSubjectCoursesConference());
    }

}