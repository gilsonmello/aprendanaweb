<?php namespace App\Repositories\Backend\Content;

use App\Content;
use App\Exceptions\GeneralException;

/**
 * Class EloquentFaqCategoryRepository
 * @package App\Repositories\FaqCategory
 */
class EloquentContentRepository implements ContentContract {


//	public function __construct() {
//	}

	/**
	 * @param $id
	 * @return mixed
	 * @throws GeneralException
	 */
	public function findOrThrowException($id) {
		$content = Content::withTrashed()->find($id);

		if (! is_null($content)) return $content;

        return null;

	}

	/**
	 * @param $per_page
	 * @param string $order_by
	 * @param string $sort
	 * @return mixed
	 */
	public function getContentPaginated($per_page,$status, $order_by = 'id', $sort = 'asc') {


		$query = Content::whereNotNull('id');
		if (isset($status) && $status != "" && $status != "2")
			$query->where('is_active', '=', $status);
		return $query->orderBy($order_by, $sort)->paginate($per_page);
	}


	/**
	 * @param $per_page
	 * @return \Illuminate\Pagination\Paginator
	 */
	public function getDeletedContentPaginated($per_page) {
		return Contentt::onlyTrashed()->paginate($per_page);
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


	public function create($lesson,$url,$sequence) {;
		$content = new Content;
		$content->url = $url;
        $content->sequence = $sequence;
		$content->is_video = 1;
		$content->lesson()->associate($lesson);
		$content->save();

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


	public function saveFile($lesson,$name, $destinationPath){
		$content = new Content;
		$content->title = $name;
		$content->url = $destinationPath;
		$content->sequence = 0;
		$content->is_video = 0;
		$content->lesson()->associate($lesson);
		$content->save();


		return $content;

		throw new GeneralException('There was a problem saving this file. Please try again.');
	}


    public function findByLesson($lesson_id){
        $query = Content::where("lesson_id", $lesson_id)->orderBy('sequence','asc')->get();
        return $query;
    }


	public function findByLessonAndSequence($lesson_id,$sequence){
		$content = Content::where("lesson_id", "=", $lesson_id)->where("sequence", "=", $sequence)->get()->first();



		if (! is_null($content)) return $content;

        return false;
	}


}