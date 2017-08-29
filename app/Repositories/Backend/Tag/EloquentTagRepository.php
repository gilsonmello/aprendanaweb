<?php namespace App\Repositories\Backend\Tag;

use App\Tag;
use App\Exceptions\GeneralException;
use Carbon\Carbon;


/**
 * Class EloquentArticleRepository
 * @package App\Repositories\Article
 */
class EloquenttagRepository implements TagContract {


//	public function __construct() {
//	}

	/**
	 * @param $id
	 * @return mixed
	 * @throws GeneralException
	 */
	public function findOrThrowException($id) {
		$tag = Tag::withTrashed()->find($id);

		if (! is_null($tag)) return $tag;

		throw new GeneralException('That tag does not exist.');
	}

	/**
	 * @param $per_page
	 * @param string $order_by
	 * @param string $sort
	 * @return mixed
	 */
	public function getTagsPaginated($per_page, $order_by = 'name', $sort = 'asc') {
		return Tag::orderBy($order_by, $sort)->paginate($per_page);
	}

	/**
	 * @param $per_page
	 * @return \Illuminate\Pagination\Paginator
	 */
	public function getDeletedTagsPaginated($per_page) {
		return Tag::onlyTrashed()->paginate($per_page);
	}

	/**
	 * @param string $order_by
	 * @param string $sort
	 * @return mixed
	 */
	public function getAllTags($order_by = 'id', $sort = 'asc') {
		return Tag::orderBy($order_by, $sort)->get();
	}

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getTagsNotActive($order_by = 'id', $sort = 'asc'){
        return Tag::whereNull('active_at')->orderBy($order_by, $sort)->get();
    }

    /**
     * @param string $term
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function selectTags($term = '', $order_by = 'name', $sort = 'asc') {
        return Tag::where('name', 'like', $term.'%')->orderBy($order_by, $sort)->get();
    }

    /**
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function create($input) {
        $tag = $this->createTagStub($input);
        if($tag->save())
            return true;
        throw new GeneralException('There was a problem creating this tag. Please try again.');
    }

    /**
     * @param array $tags
     * @return bool
     * @throws GeneralException
     * @internal param $input
     */
    public function createIfNew(array $tags) {

        foreach ($tags as $tag) {
            $model = Tag::firstOrNew(['name' => $tag]);
            $model->name = $tag;
            $model->save();
        }

    }

    /**
     * @param $id
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function update($id, $input) {
        $tag = $this->findOrThrowException($id);

        if ($tag->update($input)) {
            $tag->name  = $input['name'];
            $tag->description  = $input['description'];
            $tag->save();

            return true;
        }

        throw new GeneralException('There was a problem updating this tag. Please try again.');
    }

    /**
     * @param $id
     * @return bool
     * @throws GeneralException
     */
    public function destroy($id) {
        $tag = $this->findOrThrowException($id);
        if ($tag->delete())
            return true;

        throw new GeneralException("There was a problem deleting this tag. Please try again.");
    }

    /**
     * @param $input
     * @return mixed
     */
    private function createTagStub($input)
    {
        $tag = new Tag;
        $tag->name = $input['name'];
        $tag->description = $input['description'];
        return $tag;
    }

    public function deactivated($id) {
        $tag = $this->findOrThrowException($id);
        $tag->active_at  = null;
        $tag->user_moderator_id  =  auth()->user()->id;
        $tag->save();
        return true;

        throw new GeneralException('There was a problem updating this tag. Please try again.');
    }

    public function activated($id) {
        $tag = $this->findOrThrowException($id);
        $tag->active_at  = Carbon::now();
        $tag->user_moderator_id  =  auth()->user()->id;
        $tag->save();
        return true;

        throw new GeneralException('There was a problem updating this tag. Please try again.');
    }


}