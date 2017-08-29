<?php namespace App\Repositories\FrontEnd\AskTheTeacher;

use App\AskTheTeacher;
use App\Exceptions\GeneralException;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Repositories\Frontend\Question\QuestionContract;
use App\Repositories\Frontend\Lesson\LessonContract;
use App\Workshop;
use App\User;
use Illuminate\Support\Facades\Auth;

/**
 * Class EloquentAskTheTeacherRepository
 * @package App\Repositories\AskTheTeacher
 */
class EloquentAskTheTeacherRepository implements AskTheTeacherContract {



    /**
     * @param AskTheTeacherContract $askTheTeachers
     */
    public function __construct(QuestionContract $questions, LessonContract $lessons) {
        $this->questions = $questions;
        $this->lessons = $lessons;
    }

	/**
	 * @param $id
	 * @return mixed
	 * @throws GeneralException
	 */
	public function findOrThrowException($id) {
		$askTheTeacher = AskTheTeacher::withTrashed()->find($id);

		if (! is_null($askTheTeacher)) return $askTheTeacher;

		throw new GeneralException('That askTheTeacher does not exist.');
	}

    public function getAskTheTeachersPerStudent($user_id, $order_by = 'id', $sort = 'desc'){
        return AskTheTeacher::where('user_student_id', '=', $user_id)->orderBy($order_by, $sort)->get();
    }

    public function createAskTheTutor($input){

        $askTheTutor = $this->createAskTheTutorStub($input);

        //Buscando a oficina e os tutores que o usuário fez a pergunta
        $query = Workshop::select(
            'workshops.id',
            'workshops.description AS workshopsDescription',
            'users.id AS usersId',
            'users.name AS usersName',
            'users.email AS usersEmail'
        )
        ->where('workshops.id', '=', $askTheTutor->workshop_id)
        ->where('students.id', '=', Auth::user()->id)
        ->join('my_workshop_tutors', 'my_workshop_tutors.workshop_id', '=', 'workshops.id')
        ->join('users', 'users.id', '=', 'my_workshop_tutors.tutor_id')
        ->join('enrollments', 'enrollments.id', '=', 'my_workshop_tutors.enrollment_id')
        ->join('users AS students', 'students.id', '=', 'enrollments.student_id')
        ->get();

        //Atribuindo a nova duvida para o primeiro tutor encontrado
        $askTheTutor->user_teacher_id = (count($query) > 0) ? $query->first()->usersId : null;

        //Pegando o nome do primeiro tutor encontrado
        $tutorName = (count($query) > 0) ? $query->first()->usersName : null;

        //Pegando o e-mail do primeiro tutor encontrado
        $tutorEmail = (count($query) > 0) ? $query->first()->usersEmail : null;

        $userName = Auth::user()->name;
        $userEmail = Auth::user()->email;

        if(isset($askTheTutor->user_teacher_id)){
            if($askTheTutor->save()) {

                //Envio de E-mail para o primeiro tutor encontrado da oficina
                Mail::send('emails.askthetutor', ['student_name' => Auth::user()->name, 'tutor_name' => $tutorName, 'question' => $input['question']], function ($message) use ($tutorName, $tutorEmail, $userName, $userEmail) {
                    $message->from($userEmail, $userName);
                    $message->to([
                        $tutorEmail, 
                        'fontenele@brasiljuridico.com.br', 
                        'biancamacedo@brasiljuridico.com.br', 
                        'ppachecorodrigo@gmail.com',
                        'jeferson@brasiljuridico.com.br'
                    ], $tutorName)->subject('Brasil Jurídico :: '.trans('strings.asktheteacher'));
                });
                //Envio de E-mails para os coordenadores da oficina
                if (count($query->first()->coordinators) > 0) {
                    $coordinators = $query->first()->coordinators;
                    foreach ($coordinators as $coordinator) {
                        Mail::send('emails.askthetutor', [
                            'student_name' => Auth::user()->name,
                            'tutor_name' => $tutorName, 
                            'question' => $input['question']
                        ], function ($message) use ($coordinator, $userName, $userEmail) {
                            $message->from($userEmail, $userName)
                            ->to($coordinator->email, $coordinator->name)
                            ->subject('Brasil Jurídico :: '.trans('strings.asktheteacher'));
                        });
                    }
                }
                return true;
            }
        }

        return false;
    }

    /**
     * @param $input
     * @return mixed
     */
    private function createAskTheTutorStub($input)
    {
        $askTheTutor = new AskTheTeacher;
        $askTheTutor->user_student_id = auth()->id();
        $askTheTutor->question = $input['question'];
        $askTheTutor->answer = null;
        $askTheTutor->created_at = Carbon::now();
        $askTheTutor->updated_at = Carbon::now();
        $askTheTutor->date_question = Carbon::now();
        $askTheTutor->date_answer = null;
        //Se a pergunta vinher de um workshop(oficina), lesson será nulo
        $askTheTutor->workshop_id = $input['workshop_id'];
        return $askTheTutor;
    }

    /**
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function create($question, $question_id, $lesson_id)
    {
        $askTheTeacher = $this->createAskTheTeacherStub($question);
        $teacher = null;
        if ($question_id != null) {
            $questionObj = $this->questions->findOrThrowException($question_id);
            $askTheTeacher->question_id = $questionObj->id;
            $askTheTeacher->user_teacher_id = $questionObj->teacher_id;
            $teacher = $questionObj->$teacher;
        } else if ($lesson_id != null) {
            $lessonObj = $this->lessons->findOrThrowException($lesson_id);
            $askTheTeacher->lesson_id = $lessonObj->id;
            if ($lessonObj->teachers->first() != null) {
                $askTheTeacher->user_teacher_id = $lessonObj->teachers->first()->id;
                $teacher = $lessonObj->teachers->first();
            }
        }
        if($askTheTeacher->save()) {
            $users =[$teacher];

//            Mail::send('emails.asktheteacher', ['id' => $askTheTeacher->id,
//                'asktheteacher_message' => $askTheTeacher->question,
//                'from' => $askTheTeacher->userStudent->name,
//                'reply_message' => ''
//            ], function($message) use ($askTheTeacher, $users)
//            {
//                foreach($users as $user){
//                    $message->to($user->email, $user->name);
//                }
//                $message->subject(utf8_encode(app_name() . ': ' .  trans('strings.asktheteacher') . ' : ' . $askTheTeacher->id ));
//            });

            return $askTheTeacher->id;
        }
        throw new GeneralException('There was a problem creating this askTheTeacher. Please try again.');
    }

    /**
     * @param $input
     * @return mixed
     */
    private function createAskTheTeacherStub($question)
    {
        $askTheTeacher = new AskTheTeacher;
        $askTheTeacher->user_student_id = auth()->id();
        $askTheTeacher->question = $question;
        $askTheTeacher->answer = null;
        $askTheTeacher->created_at = Carbon::now();
        $askTheTeacher->updated_at = Carbon::now();
        $askTheTeacher->date_question = Carbon::now();
        $askTheTeacher->date_answer = null;
        return $askTheTeacher;
    }

    public function getAskTheTeacherPerPartner($partner_id, $order_by = 'id', $sort = 'desc')
    {
        $questions  = AskTheTeacher::join('users','users.id','=','user_student_id')
            ->join('enrollments','enrollments.student_id', '=', 'users.id')->where('enrollments.partner_id',$partner_id)->select('ask_the_teacher.*')->distinct()->orderBy('ask_the_teacher.' .$order_by,$sort);



        return $questions->get();
    }


    public function getBySearch($term,$partners_id) {
        return AskTheTeacher::join('users','users.id','=','user_student_id')
            ->join('enrollments','enrollments.student_id', '=', 'users.id')->whereIn('enrollments.partner_id',$partners_id)->whereRaw(
            "MATCH(question,answer) AGAINST(? IN BOOLEAN MODE)",
            array($term)
        )->select("ask_the_teacher.*")->distinct()->get();
    }

}