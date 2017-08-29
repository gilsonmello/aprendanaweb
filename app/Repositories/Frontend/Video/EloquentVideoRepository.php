<?php namespace App\Repositories\Frontend\Video;

use App\Video;
use App\Exceptions\GeneralException;
use Carbon\Carbon;

/**
 * Class EloquentNewsletterRepository
 * @package App\Repositories\Newsletter
 */
class EloquentVideoRepository implements VideoContract {


//	public function __construct() {
//	}

    /**
     * @param $slug
     * @return mixed
     * @throws GeneralException
     */
	public function findOrThrowException($slug) {
		$video = Video::whereSlug($slug)->first();

		if (! is_null($video)) return $video;

		throw new GeneralException('That video does not exist.');
	}

	/**
	 * @param $per_page
	 * @param string $order_by
	 * @param string $sort
	 * @return mixed
	 */
	public function getVideosPaginated($per_page, $order_by = 'activation_date', $sort = 'desc') {
		return Video::isActivatedAndPublished()->orderBy($order_by, $sort)->paginate($per_page);
	}

	/**
	 * @param string $order_by
	 * @param string $sort
	 * @return mixed
	 */
	public function getAllVideos($order_by = 'id', $sort = 'asc') {
		return Video::isActivatedAndPublished()->orderBy($order_by, $sort)->get();
	}

    public function getBySearch($term) {
        return Video::isActivatedAndPublished()->whereRaw(
            "MATCH(title,content,tags) AGAINST(? IN BOOLEAN MODE)",
            array($term)
        )->get();
    }

}