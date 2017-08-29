<?php namespace App\Repositories\Backend\ContentsComments;

use App\ContentComment;
use App\Exceptions\GeneralException;

/**
 * Class EloquentFaqCategoryRepository
 * @package App\Repositories\FaqCategory
 */
class EloquentContentsCommentsRepository implements ContentsCommentsContract {


//	public function __construct() {
//	}

	/**
	 * @param $id
	 * @return mixed
	 * @throws GeneralException
	 */
	public function findOrThrowException($id) {
		$contentsComments = ContentComment::withTrashed()->find($id);

		if (! is_null($contentsComments)) return $contentsComments;

		throw new GeneralException('That Comentary does not exist.');
	}

	/**
	 * @param $per_page
	 * @param string $order_by
	 * @param string $sort
	 * @return mixed
	 */
	public function getContentsCommentsPaginated($per_page,$status, $order_by = 'id', $sort = 'asc') {


		$query = ContentComment::whereNotNull('id');
		if (isset($status) && $status != "" && $status != "2")
			$query->where('is_active', '=', $status);
		return $query->orderBy($order_by, $sort)->paginate($per_page);
	}


	/**
	 * @param $per_page
	 * @return \Illuminate\Pagination\Paginator
	 */
	public function getDeletedContentsCommentsPaginated($per_page) {
		return ContentComment::onlyTrashed()->paginate($per_page);
	}

	/**
	 * @param string $order_by
	 * @param string $sort
	 * @return mixed
	 */
	public function getAllContentsComments($order_by = 'id', $sort = 'asc') {
		return ContentComment::orderBy($order_by, $sort)->get();
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
        $contentsComments = $this->findOrThrowException($id);
        if ($contentsComments->delete())
            return true;

        throw new GeneralException("There was a problem deleting this Comentary. Please try again.");
    }


	public function deactivated($id) {
		$contentcomment = $this->findOrThrowException($id);
		$contentcomment->is_active  = 0;
		$contentcomment->moderator_id  =  auth()->user()->id;
		$contentcomment->save();
		return true;

		throw new GeneralException('There was a problem updating this comentary. Please try again.');
	}

	public function activated($id) {
		$contentcomment = $this->findOrThrowException($id);
		$contentcomment->is_active  = 1;
		$contentcomment->moderator_id  =  auth()->user()->id;
		$contentcomment->save();
		return true;

		throw new GeneralException('There was a problem updating this comentary. Please try again.');
	}



}