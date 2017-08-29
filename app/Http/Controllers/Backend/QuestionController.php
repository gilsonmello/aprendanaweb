<?PHP namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Question\CreateQuestionRequest;
use App\Http\Requests\Backend\Question\UpdateQuestionRequest;
use App\Repositories\Backend\Answer\AnswerContract;
use App\Repositories\Backend\Question\QuestionContract;
use App\Services\UploadService\UploadService;
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
class QuestionController extends Controller {

    /**
     * @param QuestionContract $questions
     * @param UploadService $uploadService
     * @param SourceContract $sources
     * @param SubjectContract $subjects
     * @param OfficeContract $offices
     * @param InstitutionContract $institutions
     * @param AnswerContract $answers
     */
    public function __construct(QuestionContract $questions, UploadService $uploadService,
                                SourceContract $sources, SubjectContract $subjects,
                                OfficeContract $offices, InstitutionContract $institutions,
                                AnswerContract $answers) {
        $this->questions = $questions;
        $this->uploadService = $uploadService;
        $this->sources = $sources;
        $this->subjects = $subjects;
        $this->institutions = $institutions;
        $this->offices = $offices;
        $this->answers = $answers;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function questionsReports(Request $request){

        //Get submit
        $f_submit = $request->input('f_submit', '');

        //Get original
        $f_QuestionController_original = get_parameter_or_session($request, 'f_QuestionController_original', '', $f_submit, '0');

        //Get theme id
        $f_QuestionController_discipline_id = get_parameter_or_session($request, 'f_QuestionController_discipline_id', '', $f_submit, '');

        //Get year
        $f_QuestionController_year = get_parameter_or_session($request, 'f_QuestionController_year', '', $f_submit, '');

        //Get teacher id
        $f_QuestionController_teacher_id = get_parameter_or_session($request, 'f_QuestionController_teacher_id', '', $f_submit, '');

        //Get source id
        $f_QuestionController_source_id = get_parameter_or_session($request, 'f_QuestionController_source_id', '', $f_submit, '');

        $f_QuestionController_duplicated = get_parameter_or_session($request, 'duplicated_questions', '', $f_submit, '');

        $f_QuestionController_export_to_csv = get_parameter_or_session($request, 'export_to_csv', '', $f_submit, '');

        //Get all themes
        $disciplines = $this->questions->getAllDisciplines();

        //Get all teachers
        $teachers = $this->questions->getAllTeachers();

        //Get all sources
        $sources = $this->questions->getAllSources();

        //Get all results
        $results = $this->questions->allFilteredQuestions(
            $f_QuestionController_original,
            $f_QuestionController_discipline_id,
            $f_QuestionController_year,
            $f_QuestionController_teacher_id,
            $f_QuestionController_source_id,
            $f_QuestionController_duplicated
        );

        if($f_QuestionController_export_to_csv == '1'){
            $this->executions_to_csv_download($results);
        }else{
            /*dd($results);
            foreach($results as $result){
                
            }*/
            //dd($results[240], $results[241], $results[242], $results[243]);
            return view('backend.reports.questionreport.questions')
                ->withResults($results)
                ->withQuestioncontrolleroriginal($f_QuestionController_original)
                ->withQuestioncontrollerothemeid($f_QuestionController_discipline_id)
                ->withQuestioncontrolleryear($f_QuestionController_year)
                ->withQuestioncontrollerteacherid($f_QuestionController_teacher_id)
                ->withQuestioncontrollersourceid($f_QuestionController_source_id)
                ->withQuestioncontrollerduplicated($f_QuestionController_duplicated)
                ->withQuestioncontrollerexporttocsv($f_QuestionController_export_to_csv)
                ->withDisciplines($disciplines)
                ->withTeachers($teachers)
                ->withSources($sources);
        }
    }

    private function executions_to_csv_download($data, $delimiter = "|") {
        // open raw memory as file so no temp files needed, you might run out of memory though
        $f = fopen('php://output', 'w');
        $filename = "relatorio_de_questoes_" . time()  . ".csv";
        fputs($f, $bom =( chr(0xEF) . chr(0xBB) . chr(0xBF) ));
        header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename="'.$filename.'";');

        fputcsv(
            $f,
            [
                trans('strings.question_text'),
                trans('strings.answer_type'),
                trans('strings.year'),
                trans('strings.result_level_1'),
                trans('strings.subtheme'),
                trans('strings.teacher'),
                trans('strings.source'),
                trans('strings.count_right'),
                trans('strings.count_wrong'),
                trans('strings.count_not_answred'),
                trans('strings.total_responses'),
                /*,
                trans('strings.exam'),
                trans('strings.max_tries'),
                trans('strings.is_finished'),
                trans('menus.avg')*/
            ],
            $delimiter
        );
        foreach($data as $result){
            
            if($result->original == 0){
                $type_question = trans('strings.adaptada');
            }elseif($result->original == 1){
                $type_question = trans('strings.original_question');
            }elseif($result->original == 2){
                $type_question = 'Concursos Anteriores';
            }
            
            
            $line = [
                str_replace(["\n", "\r"], '', strip_tags($result->text)),
                $type_question,
                !empty($result->year) ? str_replace(array("\n", "\r", "\t"), '', $result->year) : "",
                !empty($result->Discipline_name) && !empty($result->Theme_name) ? str_replace(array("\n", "\r", "\t"), '', $result->Discipline_name).' - '.str_replace(array("\n", "\r", "\t"), '', $result->Theme_name) : "",
                !empty($result->Subject_name) ? str_replace(array("\n"), '', str_replace(array(";"), '-', $result->Subject_name)) : "",
                !empty($result->Teacher_name) ? str_replace(array("\n", "\r", "\t"), '', $result->Teacher_name) : "",
                !empty($result->source_name) ? str_replace(array("\n", "\r", "\t"), '', $result->source_name) : "",
                ($result->count_exec > 0) ? $result->count_right." [".number_format(($result->count_right / $result->count_exec * 100), 2).'%]' : "[0%]",
                ($result->count_exec > 0) ? $result->count_wrong." [".number_format(($result->count_wrong / $result->count_exec * 100), 2).'%]' : "[0%]",
                ($result->count_exec > 0) ? $result->count_not_answred." [".number_format(($result->count_not_answred / $result->count_exec * 100), 2).'%]' : "[0%]",
                ($result->count_exec > 0) ? $result->count_exec : "0"
                /*
                (isset($result->title)) ? $result->title : "",
                ($result->attempt.'/'. $result->max_tries),
                (format_datebr($result->finished_at) ? format_datebr($result->finished_at) : ""),
                (number_format(($result->grade / $result->questions_count) * 100, 1, '.', '.').'%'),*/

            ];
            fputcsv($f, $line, $delimiter);
        }
        fpassthru($f);
    }

    /**
     * @return mixed
     */
    public function index(Request $request) {
        $request->session()->put('lastpage', $request->only('page')['page']);

        $f_submit = $request->input('f_submit', '');

        $f_QuestionController_text = get_parameter_or_session( $request, 'f_QuestionController_text', '', $f_submit, '' );

        return view('backend.questions.index')
            ->withQuestions($this->questions->getQuestionsPaginated(config('access.users.default_per_page'), 'text', 'asc', $f_QuestionController_text))
            ->withQuestioncontrollertext($f_QuestionController_text);
    }

    /**
     * @return mixed
     */
    public function create() {
        return view('backend.questions.create')
            ->withInstitutions($this->institutions->getAllInstitutions())
            ->withSubjects($this->subjects->getSubjectsLastLevel())
            ->withOffices($this->offices->getAllOffices())
            ->withSources($this->sources->getAllSources())
            ->withTeachers( User::teachers()->orderBy('name', 'asc'))
            ->withGroup( null );
    }

    /**
     * @param CreateQuestionRequest $request
     * @return mixed
     */
    public function store(CreateQuestionRequest $request) {
        $question = $this->questions->create($request);

        if($request->hasFile('image')) {
            $upload_result = $this->uploadService->addImg($request->file('image'), $question->id, $question->id, 'questions');
            if(!isset($upload_result['error'])) $this->questions->updateImage($question->id, $upload_result['filename']);
        }

        if (($request['group_id'] != null) && (isset($request['group_id']))){
            return redirect()->route('admin.groupquestions.index', ['f_group_id' => $request['group_id']])->withFlashSuccess(trans("alerts.questions.created"));
        } else {
            return redirect()->route('admin.questions.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.questions.created"));
        }
    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit($id, Request $request) {
        $question = $this->questions->findOrThrowException($id, true);

        $f_QuestionController_edit_as_text = get_parameter_or_session( $request, 'f_QuestionController_edit_as_text', '', '1', '0');

        $answers = $this->answers->getAllAnswersByQuestion($id);

        $photooriginal = imageurl("questions/", $id, $question->image);
        $photoresize = imageurl("questions/", $id, $question->image, 100);

        return view('backend.questions.edit')->withQuestion($question)
            ->withInstitutions($this->institutions->getAllInstitutions())
            ->withSubjects($this->subjects->getSubjectsLastLevel())
            ->withOffices($this->offices->getAllOffices())
            ->withSources($this->sources->getAllSources())
            ->withAnswers( $answers )
            ->withTeachers( User::teachers()->orderBy('name', 'asc'))
            ->withGroup( null )
            ->withEditastext( $f_QuestionController_edit_as_text )
            ->withPhotooriginal($photooriginal)
            ->withPhotoresize($photoresize);
    }

    /**
     * @param $id
     * @param UpdateQuestionRequest $request
     * @return mixed
     */
    public function update($id, UpdateQuestionRequest $request) {


        if(isset($request['subjects']) && isset($request['subjects'][0]) && $request['subjects'][0] == "") return redirect()->back()->withFlashDanger('É preciso informar um subtema');

        $question = $this->questions->update($id, $request->except(['image']));

        if($request->hasFile('image')) {
            $upload_result = $this->uploadService->addImg($request->file('image'), $question->id, $question->id, 'questions');
            if(!isset($upload_result['error'])) $this->questions->updateImage($question->id, $upload_result['filename']);
        }

        if (($request['group_id'] != null) && (isset($request['group_id']))){
            return redirect()->route('admin.groupquestions.index', ['f_group_id' => $request['group_id']])->withFlashSuccess(trans("alerts.questions.updated"));
        } else {
            return redirect()->route('admin.questions.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.questions.updated"));
        }

    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id) {
        $this->questions->destroy($id);
        return redirect()->back()->withFlashSuccess(trans("alerts.questions.deleted"));
    }

}