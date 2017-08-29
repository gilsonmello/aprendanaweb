<?PHP namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Repositories\Backend\Answer\AnswerContract;
use App\Repositories\Backend\Exam\ExamContract;
use App\Repositories\Backend\GroupQuestion\GroupQuestionContract;
use Illuminate\Http\Request;
use App\Repositories\Backend\Source\SourceContract;
use App\Repositories\Backend\Subject\SubjectContract;
use App\Repositories\Backend\Institution\InstitutionContract;
use App\Repositories\Backend\Office\OfficeContract;
use App\Repositories\Backend\Question\QuestionContract;
use App\User;


/**
 * Class DashboardController
 * @package App\Http\Controllers\Backend
 */
class GroupQuestionController extends Controller {

    /**
     * @param ExamContract $exams
     */
    public function __construct(GroupQuestionContract $groupquestions, SourceContract $sources, SubjectContract $subjects,
                                OfficeContract $offices, InstitutionContract $institutions, QuestionContract $questions,
                                AnswerContract $answers) {
        $this->groupquestions = $groupquestions;
        $this->sources = $sources;
        $this->subjects = $subjects;
        $this->institutions = $institutions;
        $this->offices = $offices;
        $this->questions = $questions;
        $this->answers = $answers;
    }


    /**
     * @return mixed
     */
    public function index(Request $request) {
        $request->session()->put('lastpage', $request->only('page')['page']);

        $f_submit = $request->input('f_submit', '');

        $f_group_edit = get_parameter_or_session( $request, 'f_group_id', '', $f_submit, '' );

        return view('backend.exams.groupquestion-index')
            ->withGroupquestions($this->groupquestions->getAllGroupQuestions('sequence', 'asc', $f_group_edit));
    }

    /**
     * @return mixed
     */
    public function create(Request $request) {
        $f_group_edit = get_parameter_or_session( $request, 'f_group_id', '', '', '' );

        return view('backend.questions.create')
            ->withInstitutions($this->institutions->getAllInstitutions())
            ->withSubjects($this->subjects->getAllSubjects())
            ->withOffices($this->offices->getAllOffices())
            ->withSources($this->sources->getAllSources())
            ->withTeachers( User::teachers()->orderBy('name', 'asc'))
            ->withGroup( $f_group_edit );
    }

    /**
     * @param CreateExamRequest $request
     * @return mixed
     */
    public function store(Request $request) {
        $f_group_edit = get_parameter_or_session( $request, 'f_group_id', '', '', '' );

        $groupquestion = $this->groupquestions->create($request, $f_group_edit );

        return redirect()->route('admin.groupquestions.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.exams.groupquestion.created"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit($id, Request $request) {
        $f_group_edit = get_parameter_or_session( $request, 'f_group_id', '', '', '' );

        $f_QuestionController_edit_as_text = get_parameter_or_session( $request, 'f_QuestionController_edit_as_text', '', '1', '0' );

        $question = $this->questions->findOrThrowException($id, true);

        $answers = $this->answers->getAllAnswersByQuestion($id);

        $photooriginal = imageurl("questions/", $id, $question->image);
        $photoresize = imageurl("questions/", $id, $question->image, 100);

        return view('backend.questions.edit')->withQuestion($question)
            ->withInstitutions($this->institutions->getAllInstitutions())
            ->withSubjects($this->subjects->getAllSubjects())
            ->withOffices($this->offices->getAllOffices())
            ->withSources($this->sources->getAllSources())
            ->withAnswers( $answers )
            ->withTeachers( User::teachers()->orderBy('name', 'asc'))
            ->withGroup( $f_group_edit )
            ->withEditastext( $f_QuestionController_edit_as_text )
            ->withPhotooriginal($photooriginal)
            ->withPhotoresize($photoresize);
    }

    /**
     * @param $id
     * @param UpdateExamRequest $request
     * @return mixed
     */
    public function update($id, Request $request) {
        $exam = $this->groupquestions->update($id, $request->all());

        return redirect()->route('admin.groupquestions.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.exams.updated"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id) {
        $this->groupquestions->destroy($id);
        return redirect()->back()->withFlashSuccess(trans("alerts.exams.deleted"));
    }

    public function changeSequence(Request $request){
        $return = $this->groupquestions->changeSequence($request['group_question_id'],$request['new_sequence']);
        if ($return === false){
            return redirect()->back()->withFlashDanger(trans("alerts.groupquestion.changesequenceerror"));
        } else {
            return redirect()->back()->withFlashSuccess(trans("alerts.groupquestion.changesequencesuccess"));
        }


    }

    public function addIndex(Request $request) {
        $request->session()->put('lastpage', $request->only('page')['page']);

        $f_submit = $request->input('f_submit', '');

        $f_QuestionController_text = get_parameter_or_session( $request, 'f_QuestionController_text', '', $f_submit, '' );

        $questions = null;
        if (($f_QuestionController_text != null) && (strlen($f_QuestionController_text) > 2)){
            $questions = $this->questions->getQuestionsPaginated(config('access.users.default_per_page'), 'text', 'asc', $f_QuestionController_text);
        }

        return view('backend.exams.question-add')
            ->withQuestions($questions)
            ->withQuestioncontrollertext($f_QuestionController_text);
    }

    public function add($question_id, Request $request){
        $f_group_edit = get_parameter_or_session( $request, 'f_group_id', '', '', '' );

        $this->groupquestions->add($question_id, $f_group_edit);

        return redirect()->route('admin.groupquestions.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.groupquestions.addsuccess"));
    }


    /**
     * @return mixed
     */
    public function conf($id, Request $request) {
        return view('backend.exams.groupquestion-conf')
            ->withGroupquestions($this->groupquestions->getAllGroupQuestions('sequence', 'asc', $id));
    }

    /**
     * @return mixed
     */
    public function themes($id, Request $request) {
        $themes = $this->groupquestions->getThemesOccurence( $id);

        $total = 0;
        foreach ($themes as $theme){
            $total = $total + $theme->questions;
        }

        return view('backend.exams.groupquestion-themes')
            ->withThemes( $themes )
            ->withTotal( $total )
            ->withGroup( $id );
    }

    /**
     * @return mixed
     */
    public function subthemes($id, Request $request) {
        $subthemes = $this->groupquestions->getSubthemesOccurence( $id);

        $total = 0;
        foreach ($subthemes as $subtheme){
            $total = $total + $subtheme->questions;
        }

        return view('backend.exams.groupquestion-subthemes')
            ->withSubthemes( $subthemes )
            ->withTotal( $total )
            ->withGroup( $id );
    }

    /**
     * @return mixed
     */
    public function originals($id, Request $request) {
        $originals = $this->groupquestions->getOriginalsOccurence( $id);

        $total = 0;
        foreach ($originals as $original){
            $total = $total + $original->questions;
        }

        return view('backend.exams.groupquestion-originals')
            ->withOriginals( $originals )
            ->withTotal( $total )
            ->withGroup( $id );
    }



}