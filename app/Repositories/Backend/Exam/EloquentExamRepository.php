<?php namespace App\Repositories\Backend\Exam;

use App\Exam;
use App\Exceptions\GeneralException;
use App\Repositories\Backend\Tag\TagContract;

/**
 * Class EloquentExamRepository
 * @package App\Repositories\Exam
 */
class EloquentExamRepository implements ExamContract {


	public function __construct(TagContract $tags) {
        $this->tags = $tags;
	}

    /**
     * @param $id
     * @return mixed
     * @throws GeneralException
     */
    public function findOrThrowException($id) {
        $exam = Exam::withTrashed()->find($id);

        if (! is_null($exam)) return $exam;

        throw new GeneralException('That exam does not exist.');
    }

    /**
     * @param $per_page
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */

    public function getExamsPaginated($per_page, $order_by = 'id', $sort = 'asc', $f_ExamController_title = '') {
        return Exam::where('title', 'like', '%'.$f_ExamController_title.'%')->orderBy($order_by, $sort)->paginate($per_page);
    }

    /**
     * @param $per_page
     * @return \Illuminate\Pagination\Paginator
     */
    public function getDeletedExamsPaginated($per_page) {
        return Exam::onlyTrashed()->paginate($per_page);
    }

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAllExams($order_by = 'id', $sort = 'asc') {
        return Exam::orderBy($order_by, $sort)->get();
    }

    /**
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function create($input) {
        if ((isset($input['tags'])) && ($input['tags'] > 0)) {
            $this->tags->createIfNew($input['tags']);
        }

        $exam = $this->createExamStub($input);
        $exam->subsection()->associate($input['subsection_id']);        unset($input['subsection_id']);
        $exam->teacherMessage()->associate($input['teacher_message_id']);        unset($input['teacher_message_id']);
        if($exam->save())
            return $exam;
        throw new GeneralException('There was a problem creating this exam. Please try again.');
    }

    /**
     * @param $id
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function update($id, $input) {
        $exam = $this->findOrThrowException($id);

        if ((isset($input['tags'])) && ($input['tags'] > 0)) {
            $this->tags->createIfNew($input['tags']);
        }
        if(isset($input['tags'])) $input['tags'] = implode(';', $input['tags']);

        $exam->subsection()->associate($input['subsection_id']);        unset($input['subsection_id']);
        $exam->teacherMessage()->associate($input['teacher_message_id']);        unset($input['teacher_message_id']);
        if ($exam->update($input)) {
            if(isset($input['tags'])) $exam->tags = $input['tags'];
            $exam->duration = parseminutebr($input['duration']);
            $exam->video_time = parseminutebr($input['video_time']);
            $exam->result_level = (isset($input['result_level']) ? $input['result_level'] : '2');
            $exam->save();

            return $exam;
        }

        throw new GeneralException('There was a problem updating this exam. Please try again.');
    }

    /**
     * @param $id
     * @return bool
     * @throws GeneralException
     */
    public function destroy($id) {
        $exam = $this->findOrThrowException($id);
        if ($exam->delete())
            return true;

        throw new GeneralException("There was a problem deleting this exam. Please try again.");
    }

    /**
     * @param $input
     * @return mixed
     */
    private function createExamStub($input)
    {

        $exam = new Exam;
        $exam->title = $input['title'];
        $exam->description = $input['description'];
        $exam->slug = $input['slug'];
        $exam->max_tries = $input['max_tries'];
        $exam->explanation = $input['explanation'];
        $exam->required_reading = $input['required_reading'];
        $exam->additional_reading = $input['additional_reading'];
        $exam->duration = parseminutebr($input['duration']);
        $exam->questions_count = $input['questions_count'];
        $exam->minimum_percentage = $input['minimum_percentage'];
        $exam->finish_message = $input['finish_message'];
        $exam->analysis = $input['analysis'];
        $exam->video_time = parseminutebr($input['video_time']);
        $exam->video_ad_url = $input['video_ad_url'];
        if(isset($input['tags'])) $exam->tags = implode(';', $input['tags']);
        if(isset($input['featured_img'])) $exam->featured_img = $input['featured_img'];
        if(isset($input['classroom_img'])) $exam->classroom_img = $input['classroom_img'];
        $exam->result_level = (isset($input['result_level']) ? $input['result_level'] : '2');
        return $exam;
    }

    /**
     * @param $id
     * @param $new_file_name
     * @return bool
     * @throws GeneralException
     */
    public function updateFeaturedImg($id, $new_file_name) {
        $exam = $this->findOrThrowException($id);
        $exam->featured_img  = $new_file_name;
        if($exam->save())
            return true;

        throw new GeneralException('There was a problem updating this article. Please try again.');
    }
    /**
     * @param $id
     * @param $new_file_name
     * @return bool
     * @throws GeneralException
     */
    public function updateClassroomImg($id, $new_file_name) {
        $exam = $this->findOrThrowException($id);
        $exam->classroom_img  = $new_file_name;
        if($exam->save())
            return true;

        throw new GeneralException('There was a problem updating this article. Please try again.');
    }

    public function getExamsSelect($order_by = 'id', $sort = 'asc')
    {

        $exams = Exam::orderBy($order_by, $sort)->get();

        $return = [];
        foreach ($exams as $exam) {
            $return[$exam->id] = $exam->title;
        }
        return $return;
    }
}