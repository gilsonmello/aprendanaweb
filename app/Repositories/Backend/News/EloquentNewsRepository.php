<?php namespace App\Repositories\Backend\News;

use App\News;
use App\Exceptions\GeneralException;
use Carbon\Carbon;
use App\Repositories\Backend\Tag\TagContract;


/**
 * Class EloquentNewsRepository
 * @package App\Repositories\News
 */
class EloquentNewsRepository implements NewsContract {


	public function __construct(TagContract $tags) {
        $this->tags = $tags;
	}

	/**
	 * @param $id
	 * @return mixed
	 * @throws GeneralException
	 */
	public function findOrThrowException($id) {
		$new = News::withTrashed()->find($id);

		if (! is_null($new)) return $new;

		throw new GeneralException('That new does not exist.');
	}

    /**
     * @param $per_page
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAllNewsPaginated($per_page, $order_by = 'id', $sort = 'asc', $f_NewsController_title = '') {
        return News::where('title', 'like', '%'.$f_NewsController_title.'%')->orderBy($order_by, $sort)->paginate($per_page);
    }

	/**
	 * @param $per_page
	 * @param string $order_by
	 * @param string $sort
	 * @return mixed
	 */
	public function getNewsPaginated($per_page, $order_by = 'id', $sort = 'asc', $f_NewsController_title = '') {
		return News::whereNull('domain_id')->where('title', 'like', '%'.$f_NewsController_title.'%')->orderBy($order_by, $sort)->paginate($per_page);
	}

	/**
	 * @param $per_page
	 * @return \Illuminate\Pagination\Paginator
	 */
	public function getDeletedNewsPaginated($per_page) {
		return News::onlyTrashed()->paginate($per_page);
	}

	/**
	 * @param string $order_by
	 * @param string $sort
	 * @return mixed
	 */
	public function getAllNews($order_by = 'id', $sort = 'asc') {
		return News::whereNull('domain_id')->orderBy($order_by, $sort)->get();
	}

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getNewsNotActive($order_by = 'id', $sort = 'asc') {
        return News::whereNull('domain_id')->where('status', '=', 0)->orderBy($order_by, $sort)->get();
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

        $new = $this->createNewsStub($input);
        if($new->save()) {
            return $new;
        }
        throw new GeneralException('There was a problem creating this new. Please try again.');
    }

    /**
     * @param $id
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function update($id, $input) {
        $new = $this->findOrThrowException($id);

        if ((isset($input['tags'])) && ($input['tags'] > 0)) {
            $this->tags->createIfNew($input['tags']);
        }
        if(isset($input['tags'])) $input['tags'] = implode(';', $input['tags']);

        if ( (isset($input['domains'][0])) && ($input['domains'][0] != null) && ($input['domains'][0] != '')) {
            $new->domain_id = $input['domains'][0];
        } else {
            $new->domain_id = null;
        }

        $new->title = $input['title'];
        $new->slug = $input['slug'];
        $new->date   = parsebr($input['date']);
        $new->content = $input['content'];
        $new->featured = isset($input['featured']) ? 1 : 0;
        if(isset($input['tags'])) $new->tags = $input['tags'];
        if(isset($input['video'])) $new->video = $input['video'];
        if(isset($input['activation_date'])) $new->activation_date = parsebr($input['activation_date']);
        $new->save();

        return $new;

        throw new GeneralException('There was a problem updating this new. Please try again.');
    }

    /**
     * @param $id
     * @param $new_file_name
     * @return bool
     * @throws GeneralException
     */
    public function updateImg($id, $new_file_name) {
        $new = $this->findOrThrowException($id);
        $new->img  = $new_file_name;
        if($new->save())
            return true;

        throw new GeneralException('There was a problem updating this new. Please try again.');
    }

    /**
     * @param $id
     * @return bool
     * @throws GeneralException
     */
    public function destroy($id) {
        $new = $this->findOrThrowException($id);
        if ($new->delete())
            return true;

        throw new GeneralException("There was a problem deleting this new. Please try again.");
    }

    /**
     * @param $input
     * @return mixed
     */
    private function createNewsStub($input)
    {
        $new = new News;
        $new->title = $input['title'];
        $new->slug = $input['slug'];
        $new->date   = parsebr($input['date']);
        $new->content = $input['content'];
        $new->featured = isset($input['featured']) ? 1 : 0;
        if(isset($input['tags'])) $new->tags = implode(';', $input['tags']);
        if(isset($input['video'])) $new->video = $input['video'];
        if(isset($input['activation_date'])) $new->activation_date = parsebr($input['activation_date']);
        if(isset($input['img'])) $new->img = $input['img'];

        if ( (isset($input['domains'][0])) && ($input['domains'][0] != null) && ($input['domains'][0] != '')) {
            $new->domain_id = $input['domains'][0];
        } else {
            $new->domain_id = null;
        }

        return $new;
    }

}