<?php namespace App\Repositories\Backend\Question;

use App\Question;
use App\GroupQuestion;
use App\Answer;
use App\Subject;
use App\User;
use App\Source;
use App\QuestionsExecution;
use App\Exceptions\GeneralException;
use App\Repositories\Backend\GroupQuestion\EloquentGroupQuestionRepository;
use App\Repositories\Backend\GroupQuestion\GroupQuestionContract;
use Illuminate\Support\Facades\DB;

/**
 * Class EloquentQuestionRepository
 * @package App\Repositories\Question
 */
class EloquentQuestionRepository implements QuestionContract {


	public function __construct(GroupQuestionContract $groupquestions ) {
        $this->groupquestions = $groupquestions;
	}

    public function allFilteredQuestions($answer_type, $discipline, $year, $teacher, $source, $repeated = null) {

        $questions = QuestionsExecution::query()
        ->join('questions', 'questions.id', '=', 'questions_executions.question_id')
        ->groupBy('questions.id');
        /*
         * Selected answer type
         */
        if(isset($answer_type) && $answer_type != "" ){
            $questions->where('questions.original', '=', $answer_type);
        }

        /*
         * Selected Discipline
         */
        if(isset($discipline) && $discipline != ""){
            $questions->join('subjects as Subject', 'questions.subject_id', '=', 'Subject.id')
            ->join('subjects as Theme', 'Subject.subject_id', '=', 'Theme.id')
            ->join('subjects as Discipline', 'Theme.subject_id', '=', 'Discipline.id')
            ->selectRaw('
                Subject.id as Subject_id,
                Subject.name Subject_name,
                Subject.subject_id Subject_subjectid,
                Theme.id as Theme_id,
                Theme.name as Theme_name,
                Theme.subject_id as Theme_subjectid,
                Discipline.id as Discipline_id,
                Discipline.name as Discipline_name,
                Discipline.subject_id as Discipline_subject_id
            ')
            ->whereNull('Discipline.subject_id')
            ->where('Discipline.id', '=', $discipline);
        }else{
            $questions->join('subjects as Subject', 'questions.subject_id', '=', 'Subject.id')
            ->join('subjects as Theme', 'Subject.subject_id', '=', 'Theme.id')
            ->join('subjects as Discipline', 'Theme.subject_id', '=', 'Discipline.id')
            ->selectRaw('
                Subject.id as Subject_id,
                Subject.name Subject_name,
                Subject.subject_id Subject_subjectid,
                Theme.id as Theme_id,
                Theme.name as Theme_name,
                Theme.subject_id as Theme_subjectid,
                Discipline.id as Discipline_id,
                Discipline.name as Discipline_name,
                Discipline.subject_id as Discipline_subject_id
             ')
            ->whereNull('Discipline.subject_id');
        }

        /*
         * Year entered
         */
        if(isset($year) && $year != ""){
            $questions->where('questions.year', '=', $year);
        }

        /*
         * Selected teacher
         */
        if(isset($teacher) && $teacher != ""){
            $questions->join('users', 'questions.teacher_id', '=', 'users.id')
            ->where('questions.teacher_id', '=', $teacher)
            ->selectRaw('users.id as Teacher_id, users.name as Teacher_name');
        }else{
            $questions->join('users', 'questions.teacher_id', '=', 'users.id')
            ->selectRaw('users.id as Teacher_id, users.name as Teacher_name');
        }

        /*
         * Selected source
         */
        if(isset($source) && $source != ""){
            $questions->join('sources', 'questions.source_id', '=', 'sources.id')
            ->where('questions.source_id', '=', $source)
            ->selectRaw('sources.id as source_id, sources.name as source_name');
        }else{
            $questions->join('sources', 'questions.source_id', '=', 'sources.id')
            ->selectRaw('sources.id as source_id, sources.name as source_name');
        }


        if(isset($repeated) && $repeated != null && $repeated == '1'){
            $questions->selectRaw('count(questions.text)')->groupBy('questions.text')->havingRaw("COUNT(*) > 1");
        }

        $questions->join('executions', 'executions.id', '=', 'questions_executions.execution_id')
        ->selectRaw("
            COUNT(
                IF(questions_executions.grade = 1.00, 1, NULL)
            ) AS 'count_right',
            COUNT(
                IF(questions_executions.grade = 0.00, 1, NULL)
            ) AS 'count_wrong',
            COUNT(
                IF(questions_executions.grade IS NULL, 1, NULL)
            ) AS 'count_not_answred',
            COUNT(
                executions.id
            ) AS 'count_exec'
        ");
        
        /*
         * Selected default fields of the questions
         */
        $questions->selectRaw('questions.id, questions.original, questions.text, questions.year');

        //dd($questions->get());

        /*
         * Return all results
         */
        return $questions->orderBy('count_right', 'desc')->orderBy('questions.year', 'desc')->get();
    }

    /*
     * Return all the disciplines
     */
    public function getAllDisciplines(){
        return Subject::whereNull('subject_id')->orderBy('name', 'asc')->get();
    }

    /*
     * Return all the teachers
     */
    public function getAllTeachers(){
        return User::teachers()->orderBy('name', 'asc')->get();
    }

    public function getAllSources(){
        return Source::orderBy('name', 'asc');
    }

    /**
     * @param $id
     * @return mixed
     * @throws GeneralException
     */
    public function findOrThrowException($id) {
        $question = Question::withTrashed()->find($id);

        if (! is_null($question)) return $question;

        throw new GeneralException('That question does not exist.');
    }

    /**
     * @param $per_page
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */

    public function getQuestionsPaginated($per_page, $order_by = 'id', $sort = 'asc', $f_QuestionController_text = '') {
        return Question::where('text', 'like', '%'.$f_QuestionController_text.'%')->orderBy($order_by, $sort)->paginate($per_page);
    }

    /**
     * @param $per_page
     * @return \Illuminate\Pagination\Paginator
     */
    public function getDeletedQuestionsPaginated($per_page) {
        return Question::onlyTrashed()->paginate($per_page);
    }

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAllQuestions($order_by = 'id', $sort = 'asc') {
        return Question::orderBy($order_by, $sort)->get();
    }

    /**
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function create($input) {
        $question = $this->createQuestionStub($input);
        if($question->save()){
            $this->addAnswer( '1', $question, $input);
            $this->addAnswer( '2', $question, $input);
            $this->addAnswer( '3', $question, $input);
            $this->addAnswer( '4', $question, $input);
            $this->addAnswer( '5', $question, $input);

            if (($input['group_id'] != null) && (isset($input['group_id']))){
                $groupquestion = new GroupQuestion;
                $groupquestion->question_id = $question->id;
                $groupquestion->group_id = $input['group_id'];
                $groupquestion->sequence = $this->groupquestions->nextSequence( $input['group_id'] ) + 1;
                $groupquestion->save();
            }
            return $question;
        }
        throw new GeneralException('There was a problem creating this question. Please try again.');
    }

    private function addAnswer($choice, $question, $input){
        if ( (isset($input['answer' . $choice. '_choice'])) && ($input['answer' . $choice. '_choice'] != null) && ($input['answer' . $choice. '_choice'] != '')) {
            $answer = new Answer;
            $answer->question_id = $question->id;
            $answer->choice = $input['answer' . $choice . '_choice'];
            if ( (isset($input['answer' . $choice. '_is_right'])) && ($input['answer' . $choice. '_is_right'] != null) && ($input['answer' . $choice. '_is_right'] === '1')) {
                $answer->is_right = 1;
            } else {
                $answer->is_right = 0;
            }
            $answer->save();
        }
    }

    /**
     * @param $id
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function update($id, $input) {
        $question = $this->findOrThrowException($id);

        $question->text = $input['text'];
        $question->year = $input['year'];
        $question->original = $input['original'];
        $question->scope = (isset($input['scope']) ? $input['scope'] : '0');
        $question->answer_type = $input['answer_type'];
        $question->explanation_url = $input['explanation_url'];
        $question->explanation_text = $input['explanation_text'];
        
        if ( (isset($input['subjects'][0])) && ($input['subjects'][0] != null) && ($input['subjects'][0] != '')) {
            $question->subject_id = $input['subjects'][0];
        } else {
            $question->subject_id = null;
        }
        if ( (isset($input['institutions'][0])) && ($input['institutions'][0] != null) && ($input['institutions'][0] != '')) {
            $question->institution_id = $input['institutions'][0];
        } else {
            $question->institution_id = null;
        }
        if ( (isset($input['offices'][0])) && ($input['offices'][0] != null) && ($input['offices'][0] != '')) {
            $question->office_id = $input['offices'][0];
        } else {
            $question->office_id = null;
        }
        if ( (isset($input['sources'][0])) && ($input['sources'][0] != null) && ($input['sources'][0] != '')) {
            $question->source_id = $input['sources'][0];
        } else {
            $question->source_id = null;
        }
        if ( (isset($input['teachers'][0])) && ($input['teachers'][0] != null) && ($input['teachers'][0] != '')) {
            $question->teacher_id = $input['teachers'][0];
        } else {
            $question->teacher_id = null;
        }
        $question->note1 = $input['note1'];
        $question->note2 = $input['note2'];
        $question->note3 = $input['note3'];
        $question->note4 = $input['note4'];
        $question->is_active = isset($input['is_active']) ? 1 : 0;

        if ( $question->save()){
            $this->updateAnswer('1', $input);
            $this->updateAnswer('2', $input);
            $this->updateAnswer('3', $input);
            $this->updateAnswer('4', $input);
            $this->updateAnswer('5', $input);
            return $question;
        }

        throw new GeneralException('There was a problem updating this question. Please try again.');
    }

    private function updateAnswer($choice, $input){
        if ( (isset($input['answer' . $choice. '_id'])) && ($input['answer' . $choice. '_id'] != null) && ($input['answer' . $choice. '_id'] != '')) {
            $answer = Answer::findOrNew( $input['answer' . $choice. '_id'] );
            if ($answer->id != null) {
                $answer->choice = $input['answer' . $choice . '_choice'];


                if ((isset($input['answer' . $choice . '_is_right'])) && ($input['answer' . $choice . '_is_right'] != null) && ($input['answer' . $choice . '_is_right'] === '1')) {
                    $answer->is_right = 1;
                } else {
                    $answer->is_right = 0;
                }
                $answer->save();
            }
        }
    }

    /**
     * @param $id
     * @return bool
     * @throws GeneralException
     */
    public function destroy($id) {
        $question = $this->findOrThrowException($id);

        $answers = Answer::where('question_id', '=', $id)->get();
        foreach ($answers as $answer){
            $answer->delete();
        }

        if ($question->delete())
            return true;

        throw new GeneralException("There was a problem deleting this question. Please try again.");
    }

    /**
     * @param $input
     * @return mixed
     */
    private function createQuestionStub($input)
    {
        $question = new Question;
        $question->text = $input['text'];
        $question->year = $input['year'];
        $question->original = $input['original'];
        $question->scope = (isset($input['scope']) ? $input['scope'] : '0');
        $question->answer_type = $input['answer_type'];
        $question->explanation_url = $input['explanation_url'];
        $question->explanation_text = $input['explanation_text'];
        if ( (isset($input['subjects'][0])) && ($input['subjects'][0] != null) && ($input['subjects'][0] != '')) {
            $question->subject_id = $input['subjects'][0];
        }
        if ( (isset($input['institutions'][0])) && ($input['institutions'][0] != null) && ($input['institutions'][0] != '')) {
            $question->institution_id = $input['institutions'][0];
        }
        if ( (isset($input['offices'][0])) && ($input['offices'][0] != null) && ($input['offices'][0] != '')) {
            $question->office_id = $input['offices'][0];
        }
        if ( (isset($input['sources'][0])) && ($input['sources'][0] != null) && ($input['sources'][0] != '')) {
            $question->source_id = $input['sources'][0];
        }
        if ( (isset($input['teachers'][0])) && ($input['teachers'][0] != null) && ($input['teachers'][0] != '')) {
            $question->teacher_id = $input['teachers'][0];
        }
        $question->note1 = $input['note1'];
        $question->note2 = $input['note2'];
        $question->note3 = $input['note3'];
        $question->note4 = $input['note4'];

        $question->is_active = isset($input['is_active']) ? 1 : 0;

        return $question;
    }

    public function updateImage($id, $new_file_name) {
        $question = $this->findOrThrowException($id);
        $question->image = $new_file_name;
        if($question->save())
            return true;

        throw new GeneralException('There was a problem updating this article. Please try again.');
    }
}