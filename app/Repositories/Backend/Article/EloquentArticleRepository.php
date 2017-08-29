<?php namespace App\Repositories\Backend\Article;

use App\Article;
use App\Exceptions\GeneralException;
use Carbon\Carbon;
use App\Repositories\Backend\Tag\TagContract;


/**
 * Class EloquentArticleRepository
 * @package App\Repositories\Article
 */
class EloquentArticleRepository implements ArticleContract {


	public function __construct(TagContract $tags) {
        $this->tags = $tags;
	}

	/**
	 * @param $id
	 * @return mixed
	 * @throws GeneralException
	 */
	public function findOrThrowException($id) {
		$article = Article::withTrashed()->find($id);

		if (! is_null($article)) return $article;

		throw new GeneralException('That article does not exist.');
	}

	/**
	 * @param $per_page
	 * @param string $order_by
	 * @param string $sort
	 * @return mixed
	 */
	public function getArticlesPaginated($per_page, $order_by = 'id', $sort = 'asc', $f_ArticleController_title = '') {
		return Article::allIfOwner()->where('title', 'like', '%'.$f_ArticleController_title.'%')->orderBy($order_by, $sort)->paginate($per_page);
	}

	/**
	 * @param $per_page
	 * @return \Illuminate\Pagination\Paginator
	 */
	public function getDeletedArticlesPaginated($per_page) {
		return Article::allIfOwner()->onlyTrashed()->paginate($per_page);
	}

	/**
	 * @param string $order_by
	 * @param string $sort
	 * @return mixed
	 */
	public function getAllArticles($order_by = 'id', $sort = 'asc') {
		return Article::allIfOwner()->orderBy($order_by, $sort)->get();
	}

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getArticlesNotActive($order_by = 'id', $sort = 'asc') {
        return Article::allIfOwner()->where('status', '=', 0)->orderBy($order_by, $sort)->get();
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

        $article = $this->createArticleStub($input);
        if($article->save()) {

            if($input['teachers'])
                $article->users()->attach($input['teachers']);
            else
                throw new GeneralException('É preciso selecionar pelo menos um professor para o artigo.');

            return $article;
        }
        throw new GeneralException('There was a problem creating this article. Please try again.');
    }

    /**
     * @param $id
     * @param $input
     * @param $teachers
     * @return bool
     * @throws GeneralException
     */
    public function update($id, $input, $teachers) {
        $article = $this->findOrThrowException($id);

        if ((isset($input['tags'])) && ($input['tags'] > 0)) {
            $this->tags->createIfNew($input['tags']);
        }
        if(isset($input['tags'])) $input['tags'] = implode(';', $input['tags']);

        if ($article->update($input)) {
            $article->title = $input['title'];
            $article->slug = $input['slug'];
            $article->date   = parsebr($input['date']);
            $article->content = $input['content'];
            if(isset($input['tags'])) $article->tags = $input['tags'];
            if(isset($input['video'])) $article->video = $input['video'];
            if(isset($input['activation_date'])) $article->activation_date = parsebr($input['activation_date']);
            $article->status = isset($input['status']) ? 1 : 0;
            $article->save();

            if($teachers['teachers'])
                $article->users()->sync($teachers['teachers']);
            else
                throw new GeneralException('É preciso selecionar pelo menos um professor para o artigo.');

            return $article;
        }

        throw new GeneralException('There was a problem updating this article. Please try again.');
    }

    /**
     * @param $id
     * @param $new_file_name
     * @return bool
     * @throws GeneralException
     */
    public function updateImg($id, $new_file_name) {
        $article = $this->findOrThrowException($id);
        $article->img  = $new_file_name;
        if($article->save())
            return true;

        throw new GeneralException('There was a problem updating this article. Please try again.');
    }

    /**
     * @param $id
     * @return bool
     * @throws GeneralException
     */
    public function destroy($id) {
        $article = $this->findOrThrowException($id);
        if ($article->delete())
            return true;

        throw new GeneralException("There was a problem deleting this article. Please try again.");
    }

    /**
     * @param $input
     * @return mixed
     */
    private function createArticleStub($input)
    {
        $article = new Article;
        $article->title = $input['title'];
        $article->slug = $input['slug'];
        $article->date   = parsebr($input['date']);
        $article->content = $input['content'];
        if(isset($input['tags'])) $article->tags = implode(';', $input['tags']);
        if(isset($input['video'])) $article->video = $input['video'];
        if(isset($input['activation_date'])) $article->activation_date = parsebr($input['activation_date']);
        $article->status = isset($input['status']) ? 1 : 0;
        if(isset($input['img'])) $article->img = $input['img'];
        return $article;
    }

}