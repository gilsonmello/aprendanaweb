<?php namespace App\Repositories\Backend\AskTheTeacher;

use App\AskTheTeacher;
use App\Exceptions\GeneralException;
use Carbon\Carbon;
use App\Repositories\Backend\Tag\TagContract;
use App\Workshop;
use Illuminate\Support\Facades\Mail;


/**
 * Class EloquentAskTheTeacherRepository
 * @package App\Repositories\AskTheTeacher
 */
class EloquentAskTheTeacherRepository implements AskTheTeacherContract {


	public function __construct(TagContract $tags) {
        $this->tags = $tags;
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

	/**
	 * @param $per_page
	 * @param string $order_by
	 * @param string $sort
	 * @return mixed
	 */
    public function getAskTheTeachersPaginated($per_page, $order_by = 'id', $sort = 'asc', $f_AskTheTeacherController_question = '', $f_AskTheTeacherController_is_replied = '2'){
		$query = AskTheTeacher::allIfOwner();
        if (($f_AskTheTeacherController_question != null) && ($f_AskTheTeacherController_question != '')){
            $query->where('question', 'like', '%'.$f_AskTheTeacherController_question.'%');
        }
        if ($f_AskTheTeacherController_is_replied === '1'){
            $query->whereNotNull('answer')->where('answer', 'NOT LIKE', '');
        }
        if ($f_AskTheTeacherController_is_replied === '0'){
            $query->whereNull('answer');
        }
        $query->whereNull('workshop_id');
        $query->where('user_teacher_id', '=', auth()->id());
        return $query->orderBy($order_by, $sort)->paginate($per_page);
	}

    /**
     * @param $per_page
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAskTheTutorsPaginated($per_page, $order_by = 'ask_the_teacher.id', $sort = 'asc', $f_AskTheTeacherController_question = '', $f_AskTheTeacherController_is_replied = '2'){
        
        $query = AskTheTeacher::query();

        if (($f_AskTheTeacherController_question != null) && ($f_AskTheTeacherController_question != '')){
            $query->where('question', 'like', '%'.$f_AskTheTeacherController_question.'%');
        }
        if ($f_AskTheTeacherController_is_replied === '1'){
            $query->whereNotNull('answer')->where('answer', 'NOT LIKE', '');
        }
        if ($f_AskTheTeacherController_is_replied === '0'){
            $query->whereNull('answer');
        }

        /* Saber se o usuário logado é coordenador */
        $workshops = Workshop::query();
        $isCoordinator = false;
        $idsWorkshop = [];
        foreach($workshops->get() as $workshop){
            foreach($workshop->coordinators as $coordinator){
                if($coordinator->id == auth()->id()){
                    $isCoordinator = true;
                    $idsWorkshop[] = $workshop->id;
                }
            }

        }
        //Se for coordenador, busco os workshops que ele tem acesso
        //Se não, busco as questões que o usuário logado tem acesso
        if(access()->hasRole('Administrador')){
            $query->join('workshops', 'workshops.id', '=', 'ask_the_teacher.workshop_id');
        }else if($isCoordinator === true){
            $query->whereIn('workshop_id', $idsWorkshop);
        }else if(access()->hasRole('Administrador')){
            $query->join('workshops', 'workshops.id', '=', 'ask_the_teacher.workshop_id');
        }else{
            $query->join('workshops', 'workshops.id', '=', 'ask_the_teacher.workshop_id');
            $query->where('user_teacher_id', '=', auth()->id());
        }
        //dd($query->get());
        $query->select('ask_the_teacher.*');
        return $query->orderBy('ask_the_teacher.id', $sort)->paginate($per_page);
    }

	/**
	 * @param $per_page
	 * @return \Illuminate\Pagination\Paginator
	 */
	public function getDeletedAskTheTeachersPaginated($per_page) {
		return AskTheTeacher::allIfOwner()->onlyTrashed()->paginate($per_page);
	}

	/**
	 * @param string $order_by
	 * @param string $sort
	 * @return mixed
	 */
	public function getAllAskTheTeachers($order_by = 'id', $sort = 'asc') {
		return AskTheTeacher::allIfOwner()->orderBy($order_by, $sort)->get();
	}

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAskTheTeachersNotActive($order_by = 'id', $sort = 'asc') {
        return AskTheTeacher::allIfOwner()->where('status', '=', 0)->orderBy($order_by, $sort)->get();
    }


    /**
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function create($input) {
//        if ((isset($input['tags'])) && ($input['tags'] > 0)) {
//            $this->tags->createIfNew($input['tags']);
//        }
//
//        $askTheTeacher = $this->createAskTheTeacherStub($input);
//        if($askTheTeacher->save()) {
//
//            if($input['teachers'])
//                $askTheTeacher->users()->attach($input['teachers']);
//            else
//                throw new GeneralException('É preciso selecionar pelo menos um professor para o artigo.');
//
//            return $askTheTeacher;
//        }
//        throw new GeneralException('There was a problem creating this askTheTeacher. Please try again.');
    }

    /**
     * @param $id
     * @param $input
     * @param $teachers
     * @return bool
     * @throws GeneralException
     */
    public function update($id, $input) {
        $askTheTeacher = $this->findOrThrowException($id);

        if (($askTheTeacher->answer == null) || ($askTheTeacher->answer === '') &&
            ($input['answer'] != null) && ($input['answer'] != '')){
            $askTheTeacher->date_answer = Carbon::now();
        }
        if ($askTheTeacher->update($input)) {
            $askTheTeacher->user_teacher_id = auth()->id();
            $askTheTeacher->answer = $input['answer'];
            
            
            $student_name = $askTheTeacher->userStudent->name;
            $student_email = $askTheTeacher->userStudent->email;
            $tutor_name = $askTheTeacher->userTeacher->name;
            $tutor_email = $askTheTeacher->userTeacher->email;
            $workshop_description = (isset($askTheTeacher->workshop)) ? $askTheTeacher->workshop->description : null;
            $question = $askTheTeacher->question;
            $answer = $askTheTeacher->answer;
            
            //Se a pergunta for de uma oficina
            if(isset($askTheTeacher->workshop)){
                //Envio de E-mail
                Mail::send('emails.answeraskthetutor', 
                    [
                        'student_name' => $student_name,
                        'student_email' => $student_email,
                        'tutor_name' => $tutor_name,
                        'tutor_email' => $tutor_email,
                        'workshop_description' => $workshop_description,
                        'question' => $question,
                        'answer' => $answer
                    ], 
                    function ($message) use ($student_name, $tutor_name, $tutor_email) {
                        $message->from($tutor_email, $tutor_name);
                        $message->to('aprendawebunidom@gmail.com', 'Aprenda na Web')
                        ->subject('Aprenda na Web :: Resposta do Tutor');
                });
            }
            
            $askTheTeacher->save();

            return $askTheTeacher;
        }

        throw new GeneralException('There was a problem updating this askTheTeacher. Please try again.');
    }

    /**
     * @param $id
     * @param $new_file_name
     * @return bool
     * @throws GeneralException
     */
    public function updateImg($id, $new_file_name) {
        $askTheTeacher = $this->findOrThrowException($id);
        $askTheTeacher->img  = $new_file_name;
        if($askTheTeacher->save())
            return true;

        throw new GeneralException('There was a problem updating this askTheTeacher. Please try again.');
    }

    /**
     * @param $id
     * @return bool
     * @throws GeneralException
     */
    public function destroy($id) {
        $askTheTeacher = $this->findOrThrowException($id);
        if ($askTheTeacher->delete())
            return true;

        throw new GeneralException("There was a problem deleting this askTheTeacher. Please try again.");
    }

    /**
     * @param $input
     * @return mixed
     */
    private function createAskTheTeacherStub($input)
    {
//        $askTheTeacher = new AskTheTeacher;
//        $askTheTeacher->title = $input['title'];
//        $askTheTeacher->slug = $input['slug'];
//        $askTheTeacher->date   = parsebr($input['date']);
//        $askTheTeacher->content = $input['content'];
//        if(isset($input['tags'])) $askTheTeacher->tags = implode(';', $input['tags']);
//        if(isset($input['video'])) $askTheTeacher->video = $input['video'];
//        if(isset($input['activation_date'])) $askTheTeacher->activation_date = parsebr($input['activation_date']);
//        $askTheTeacher->status = isset($input['status']) ? 1 : 0;
//        if(isset($input['img'])) $askTheTeacher->img = $input['img'];
//        return $askTheTeacher;
    }

}