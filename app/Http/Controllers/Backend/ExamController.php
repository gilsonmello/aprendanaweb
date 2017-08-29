<?PHP namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Exam\CreateExamRequest;
use App\Http\Requests\Backend\Exam\UpdateExamRequest;
use App\Repositories\Backend\Subsection\SubsectionContract;
use App\Repositories\Backend\Exam\ExamContract;
use App\Repositories\Backend\Configuration\ConfigurationContract;
use App\Repositories\Backend\User\UserTeacherContract;
use App\Repositories\Backend\Group\GroupContract;
use App\Services\UploadService\UploadService;
use Illuminate\Http\Request;

/**
 * Class DashboardController
 * @package App\Http\Controllers\Backend
 */
class ExamController extends Controller {

    /**
     * @param ExamContract $exams
     */
    public function __construct(ExamContract $exams, SubsectionContract $subsections, ConfigurationContract $configurations,
                                UploadService $uploadService, UserTeacherContract $teachers,
                                GroupContract $groups) {
        $this->exams = $exams;
        $this->subsections = $subsections;
        $this->uploadService = $uploadService;
        $this->configurations = $configurations;
        $this->teachers = $teachers;
        $this->groups = $groups;
    }

    public function associationSaap($saap_id){

        return view('backend.exams.association-saap');
    }

    /**
     * @return mixed
     */
    public function index(Request $request) {
        $request->session()->put('lastpage', $request->only('page')['page']);

        $f_submit = $request->input('f_submit', '');

        $f_ExamController_title = get_parameter_or_session( $request, 'f_ExamController_title', '', $f_submit, '' );

        return view('backend.exams.index')
            ->withExams($this->exams->getExamsPaginated(config('access.users.default_per_page'), 'id', 'asc', $f_ExamController_title))
            ->withExamcontrollertitle($f_ExamController_title);
    }

    /**
     * @return mixed
     */
    public function create() {
        $subsections = $this->subsections->getSubsectionsSelect();

        $configuration = $this->configurations->findOrThrowException(1, true); //added code 1, as must only exists one row in configuration table

        $teachersSelect = $this->teachers->getAllUserTeachers();

        return view('backend.exams.create')->withSubsections($subsections)->withConfiguration($configuration)->withTeachers($teachersSelect);
    }

    /**
     * @param CreateExamRequest $request
     * @return mixed
     */
    public function store(CreateExamRequest $request) {
        $exam = $this->exams->create($request);

        if($request->hasFile('featured_img')) {
            $upload_result = $this->uploadService->addImg($request->file('featured_img'), $exam->title, $exam->id, 'exams');
            if(!isset($upload_result['error'])) $this->articles->updateFeaturedImg($exam->id, $upload_result['filename']);
        }

        if($request->hasFile('classroom_img')) {
            $upload_result = $this->uploadService->addImg($request->file('classroom_img'), $exam->title, $exam->id, 'exams');
            if(!isset($upload_result['error'])) $this->articles->updateClassroomImg($exam->id, $upload_result['filename']);
        }

        return redirect()->route('admin.exams.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.exams.created"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit($id) {
        $exam = $this->exams->findOrThrowException($id, true);

        $subsections = $this->subsections->getSubsectionsSelect();

        $configuration = $this->configurations->findOrThrowException(1, true); //added code 1, as must only exists one row in configuration table

        $teachersSelect = $this->teachers->getAllUserTeachers();

        return view('backend.exams.edit')->withExam($exam)->withSubsections($this->subsections->getAllSubsections())
            ->withSubsections($subsections)->withConfiguration($configuration)->withTeachers($teachersSelect);
    }

    /**
     * @param $id
     * @param UpdateExamRequest $request
     * @return mixed
     */
    public function update($id, UpdateExamRequest $request) {
        $exam = $this->exams->update($id, $request->except(['teachers', 'featured_img', 'classroom_img']));

        if($request->hasFile('featured_img')) {
            $upload_result = $this->uploadService->addImg($request->file('featured_img'), $exam->title, $exam->id, 'exams');
            if(!isset($upload_result['error'])) $this->exams->updateFeaturedImg($exam->id, $upload_result['filename']);
        }

        if($request->hasFile('classroom_img')) {
            $upload_result = $this->uploadService->addImg($request->file('classroom_img'), $exam->title, $exam->id, 'exams');
            if(!isset($upload_result['error'])) $this->exams->updateClassroomImg($exam->id, $upload_result['filename']);
        }

        return redirect()->route('admin.exams.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.exams.updated"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id) {
        $this->exams->destroy($id);
        return redirect()->back()->withFlashSuccess(trans("alerts.exams.deleted"));
    }


}