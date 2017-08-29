<?php namespace App\Repositories\Backend\CourseContent;

use App\CourseContent;
use App\Exceptions\GeneralException;

/**
 * Class EloquentFaqCategoryRepository
 * @package App\Repositories\FaqCategory
 */
class EloquentCourseContentRepository implements CourseContentContract {


//	public function __construct() {
//	}

	/**
	 * @param $id
	 * @return mixed
	 * @throws GeneralException
	 */
	public function findOrThrowException($id) {
		$course_content = CourseContent::withTrashed()->find($id);

		if (! is_null($course_content)) return $course_content;

        return null;

	}

	/**
	 * @param $per_page
	 * @param string $order_by
	 * @param string $sort
	 * @return mixed
	 */
	public function getContentPaginated($per_page, $order_by = 'id', $sort = 'asc') {


		$query = CourseContent::whereNotNull('id');
		return $query->orderBy($order_by, $sort)->paginate($per_page);
	}


	/**
	 * @param $per_page
	 * @return \Illuminate\Pagination\Paginator
	 */
	public function getDeletedContentPaginated($per_page) {
		return Content::onlyTrashed()->paginate($per_page);
	}

	/**
	 * @param string $order_by
	 * @param string $sort
	 * @return mixed
	 */
	public function getAllContent($order_by = 'id', $sort = 'asc') {
		return Content::orderBy($order_by, $sort)->get();
	}

    /**
     * @param $input
     * @return bool
     * @throws GeneralException
     */

    /**
     * @param $id
     * @return bool
     * @throws GeneralException
     */
    public function destroy($id) {
        $content = $this->findOrThrowException($id);
        if ($content->delete())
            return true;

        throw new GeneralException("There was a problem deleting this Comentary. Please try again.");
    }


	public function create($course,$url,$sequence) {;
		$course_content = new CourseContent;
        $course_content->url = $url;
        $course_content->sequence = $sequence;
        $course_content->is_video = 1;
        $course_content->course()->associate($course);
        $course_content->save();

		return true;

		throw new GeneralException('There was a problem updating this comentary. Please try again.');
	}


    public function update($now_content, $url) {
        $content = $now_content;
        $content->url = $url;
        $content->update(['url' => $url]);


        return true;


        throw new GeneralException('There was a problem updating this course. Please try again.');
    }


	public function saveFile($course,$name, $destinationPath){
		$course_content = new CourseContent;
        $course_content->title = $name;
        $course_content->url = $destinationPath;
        $course_content->sequence = 0;
        $course_content->is_video = 0;
        $course_content->course()->associate($course);
        $course_content->save();


		return $course_content;

		throw new GeneralException('There was a problem saving this file. Please try again.');
	}


    public function findByCourse($course_id){
        $query = CourseContent::where("course_id", $course_id)->orderBy('sequence','asc')->get();
        return $query;
    }


	public function findByCourseAndSequence($course_id,$sequence){
		$course_content = CourseContent::where("course_id", "=", $course_id)->where("sequence", "=", $sequence)->get()->first();



		if (! is_null($course_content)) return $course_content;

        return false;
	}


}