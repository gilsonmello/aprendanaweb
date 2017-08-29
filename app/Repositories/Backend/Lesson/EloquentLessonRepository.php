<?php namespace App\Repositories\Backend\Lesson;

use App\Lesson;
use App\Exceptions\GeneralException;
use App\Repositories\Backend\Tag\TagContract;

/**
 * Class EloquentLessonRepository
 * @package App\Repositories\Lesson
 */
class EloquentLessonRepository implements LessonContract {


    public function __construct(TagContract $tags) {
        $this->tags = $tags;
    }

	/**
	 * @param $id
	 * @return mixed
	 * @throws GeneralException
	 */
	public function findOrThrowException($id) {
		$lesson = Lesson::withTrashed()->find($id);

		if (! is_null($lesson)) return $lesson;

		throw new GeneralException('That lesson does not exist.');
	}

	/**
	 * @param $per_page
	 * @param string $order_by
	 * @param string $sort
	 * @return mixed
	 */
	public function getLessonsPaginated($per_page, $order_by = 'id', $sort = 'asc') {
		return Lesson::orderBy($order_by, $sort)->paginate($per_page);
	}

	/**
	 * @param $per_page
	 * @return \Illuminate\Pagination\Paginator
	 */
	public function getDeletedLessonsPaginated($per_page) {
		return Lesson::onlyTrashed()->paginate($per_page);
	}

	/**
	 * @param string $order_by
	 * @param string $sort
	 * @return mixed
	 */
	public function getAllLessons($order_by = 'id', $sort = 'asc') {
		return Lesson::orderBy($order_by, $sort)->get();
	}



    public function getAllModuleLessons($module_id, $order_by= 'sequence', $sort = 'asc'){
        return Lesson::where('module_id',$module_id)->orderBy($order_by,$sort)->get();
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

        $lesson = $this->createLessonStub($input);
        if($lesson->save())
            return $lesson;
        throw new GeneralException('There was a problem creating this lesson. Please try again.');
    }

    /**
     * @param $id
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function update($id, $input) {
        $lesson = $this->findOrThrowException($id);

        if (isset($input['tags']) && $input['tags'] > 0) {
            $this->tags->createIfNew($input['tags']);
        }


        if(isset($input['tags'])) $input['tags'] = implode(';', $input['tags']);



        if($input['exam_id'] == "" ) $input['exam_id'] = null;


        if ($lesson->update($input)) {
            $lesson->subsection_id = $input['subsection_id'];
            $lesson->exam_id = $input['exam_id'];
            $lesson->title = $input['title'];
            $lesson->description = $input['description'];
            $lesson->price = $input['price'];
            $lesson->discount_price = $input['discount_price'];
            $lesson->sequence = $input['sequence'];
            $lesson->duration = $input['duration'];
            if(isset($input['tags'])) $lesson->tags = $input['tags'];
            if(isset($input['video_ad_url'])) $lesson->video_ad_url = $input['video_ad_url'];
            if(isset($input['activation_date'])) $lesson->activation_date = parsebr($input['activation_date']);
            if(isset($input['featured_img'])) $lesson->featured_img = $input['featured_img'];
            if(isset($input['is_active'])) $lesson->is_active = 1;
            else $lesson->is_active = 0;
            if(isset($input['presential'])) $lesson->presential = 1;
            else $lesson->presential = 0;

            $lesson->save();

            return $lesson;
        }

        throw new GeneralException('There was a problem updating this lesson. Please try again.');
    }

    /**
     * @param $id
     * @param $new_file_name
     * @return bool
     * @throws GeneralException
     */
    public function updateImg($id, $new_file_name) {
        $lesson = $this->findOrThrowException($id);
        $lesson->featured_img  = $new_file_name;
        if($lesson->save())
            return true;

        throw new GeneralException('There was a problem updating this article. Please try again.');
    }

    /**
     * @param $id
     * @return bool
     * @throws GeneralException
     */
    public function destroy($id) {
        $lesson = $this->findOrThrowException($id);
        if ($lesson->delete())
            return true;

        throw new GeneralException("There was a problem deleting this lesson. Please try again.");
    }

    public function basicCreate($module_id, $title, $sequence, $duration){
        $lesson = $this->createBasicLessonStub($title,$sequence,$duration);
        $lesson->module()->associate($module_id);
        if($lesson->save()) {

            return $lesson;
        }
        throw new GeneralException('There was a problem creating this lesson. Please try again.');

    }

    public function createBasicLessonStub($title, $sequence, $duration){
        $lesson = new Lesson;
        $lesson->sequence =  $sequence;
        $lesson->title = $title;
        $lesson->duration = $duration;
        $lesson->is_active = 1;
        return $lesson;

    }

    public function linkTeacher($id,$teacher,$percentage){
        $lesson = Lesson::find($id);
        $related_teacher = $lesson->teachers()->find($teacher);
        if($related_teacher == null) {
            $lesson->teachers()->attach($teacher, ['percentage' => $percentage]);
        }else{
            $related_teacher->pivot->percentage = $percentage;
            $related_teacher->pivot->save();
            return true;
        }


        if($lesson->save()){



            return true;
        }
        throw new GeneralException('There was a problem creating this lesson. Please try again.');

    }

    public function unlinkTeacher($lesson_id,$teacher_id){
        $lesson = Lesson::find($lesson_id);
        $lesson->teachers()->detach($teacher_id);
        return true;
    }



    /**
     * @param $input
     * @return mixed
     */
    private function createLessonStub($input)
    {
        $lesson = new Lesson;
        $lesson->subsection_id = $input['subsection_id'];

        $lesson->exam_id = $input['exam_id'] == '' ? null : $input['exam_id'];
        $lesson->title = $input['title'];
        $lesson->description = $input['description'];
        $lesson->price = $input['price'];
        $lesson->discount_price = $input['discount_price'];
        $lesson->sequence = $input['sequence'];
        $lesson->duration = $input['duration'];
        if(isset($input['tags'])) $lesson->tags = implode(';', $input['tags']);
        if(isset($input['video_ad_url'])) $lesson->video_ad_url = $input['video_ad_url'];
        if(isset($input['activation_date'])) $lesson->activation_date = parsebr($input['activation_date']);
        if(isset($input['featured_img'])) $lesson->featured_img = $input['featured_img'];
        return $lesson;
    }


    public function getMaxSequence($module_id){
        return Lesson::where("module_id",$module_id)->max("sequence");
    }

    public function selectLessons($term = '', $course_id = null, $order_by = 'title', $sort = 'asc') {
        if($course_id != null){
        return Lesson::join('modules','modules.id','=','lessons.module_id')->
        join('courses','courses.id','=','modules.course_id')->where(function ($query) use($term) {
            $query->where('lessons.title', 'like', $term.'%')
                ->orWhere('modules.name', 'like', $term.'%');
        })
        ->where('modules.course_id',$course_id)->orderBy($order_by, $sort)->select('lessons.*')->get();
        }else{
            return Lesson::where('title', 'like', $term.'%')->orderBy($order_by, $sort)->get();
        }
    }

}