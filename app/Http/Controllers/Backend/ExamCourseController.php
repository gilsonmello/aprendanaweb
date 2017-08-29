<?PHP namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Repositories\Backend\Exam\ExamContract;
use App\Repositories\Backend\ExamCourse\ExamCourseContract;
use Illuminate\Http\Request;
use App\Repositories\Backend\Course\CourseContract;
use App\User;


/**
 * Class DashboardController
 * @package App\Http\Controllers\Backend
 */
class ExamCourseController extends Controller {

    /**
     * @param ExamContract $exams
     */
    public function __construct(ExamCourseContract $examcourses, CourseContract $courses ) {
        $this->examcourses = $examcourses;
        $this->courses = $courses;
    }


    /**
     * @return mixed
     */
    public function index(Request $request) {
        $request->session()->put('lastpage', $request->only('page')['page']);

        $f_submit = $request->input('f_submit', '');

        $f_exam_edit = get_parameter_or_session( $request, 'f_exam_id', '', $f_submit, '' );

        return view('backend.exams.examcourse-index')
            ->withExamcourses($this->examcourses->getAllExamCourses('id', 'asc', $f_exam_edit));
    }

    /**
     * @return mixed
     */
    public function create(Request $request) {
        $f_exam_edit = get_parameter_or_session( $request, 'f_exam_id', '', '', '' );

        return view('backend.courses.create')
            ->withCourses($this->courses->getAllCourses())
            ->withExam( $f_exam_edit );
    }

    /**
     * @param CreateExamRequest $request
     * @return mixed
     */
    public function store(Request $request) {
        $f_exam_edit = get_parameter_or_session( $request, 'f_exam_id', '', '', '' );

        $examcourse = $this->examcourses->create($request, $f_exam_edit );

        return redirect()->route('admin.examcourses.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.exams.examcourse.created"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit($id) {
        $examExamCourse = $this->examcourses->findOrThrowException($id, true);

        return view('backend.exams.examcourse-edit')->withExamCourse($examExamCourse);
    }

    /**
     * @param $id
     * @param UpdateExamRequest $request
     * @return mixed
     */
    public function update($id, Request $request) {
        $exam = $this->examcourses->update($id, $request->all());

        return redirect()->route('admin.examcourses.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.exams.updated"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id) {
        $this->examcourses->destroy($id);
        return redirect()->back()->withFlashSuccess(trans("alerts.exams.deleted"));
    }


    public function addIndex(Request $request) {
        $request->session()->put('lastpage', $request->only('page')['page']);

        $courses = $this->courses->getAllCourses();

        return view('backend.exams.course-add')
            ->withCourses($courses);
    }

    public function add(Request $request){
        $f_exam_edit = get_parameter_or_session( $request, 'f_exam_id', '', '', '' );

        $this->examcourses->add($request['courses'][0], $f_exam_edit);

        return redirect()->route('admin.examcourses.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.examcourses.addsuccess"));
    }



}