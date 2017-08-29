<?php namespace App\Repositories\Frontend\Article;

use App\Article;
use App\Exceptions\GeneralException;
use Carbon\Carbon;

/**
 * Class EloquentArticleRepository
 * @package App\Repositories\Article
 */
class EloquentArticleRepository implements ArticleContract {


//	public function __construct() {
//	}

    /**
     * @param $slug
     * @return mixed
     * @throws GeneralException
     */
	public function findOrThrowException($slug) {
		$article = Article::whereSlug($slug)->first();

		if (! is_null($article)) return $article;

		throw new GeneralException('That article does not exist.');
	}

	/**
	 * @param $per_page
	 * @param string $order_by
	 * @param string $sort
	 * @return mixed
	 */
	public function getArticlesPaginated($per_page, $order_by = 'id', $sort = 'asc') {
		return Article::isActivatedAndPublished()->orderBy($order_by, $sort)->paginate($per_page);
	}

	/**
	 * @param string $order_by
	 * @param string $sort
	 * @return mixed
	 */
	public function getAllArticles($order_by = 'id', $sort = 'asc') {
		return Article::isActivatedAndPublished()->orderBy($order_by, $sort)->get();
	}


	public function getArticlesByTeachers($teachers){
		$articles = Article::join('users','user_id','=','users.id');

		foreach($teachers as $index => $teacher){
			if($index == 0){
				$articles = $articles->where('users.id','=',$teacher->id);
			}else{
				$articles = $articles->orWhere('users.id','=',$teacher->id);
			}


		}

		return $articles->orderBy('id','desc')->get();
	}




    public function getBySearch($term) {
        return Article::isActivatedAndPublished()->whereRaw(
            "MATCH(title,content,tags) AGAINST(? IN BOOLEAN MODE)",
            array($term)
        )->get();
    }

}