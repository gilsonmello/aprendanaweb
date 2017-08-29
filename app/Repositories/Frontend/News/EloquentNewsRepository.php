<?php

namespace App\Repositories\Frontend\News;

use App\News;
use App\Exceptions\GeneralException;
use Carbon\Carbon;

/**
 * Class EloquentNewsRepository
 * @package App\Repositories\News
 */
class EloquentNewsRepository implements NewsContract {
//	public function __construct() {
//	}

    /**
     * @param $slug
     * @return mixed
     * @throws GeneralException
     */
    public function findOrThrowException($slug) {
        $new = News::where('slug', 'like', $slug)->first();

        if (!is_null($new))
            return $new;

        throw new GeneralException('Notícia não encontrada.');
    }

    /**
     * @param $per_page
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getNewsPaginated($per_page, $order_by = 'id', $sort = 'asc', $except = null, $tag = null, $domain_id = null) {
        $query = News::orderBy($order_by, $sort);

        if ($domain_id != null) {
            $query->where('domain_id', '=', $domain_id);
        } else {
            $query->whereNull('domain_id');
        }

        if ($except != null) {
            $query->whereNotIn('id', $except);
        }

        if ($tag != null) {
            $query->where('tags', 'like', '%' . $tag . '%');
        }

        return $query->paginate($per_page);
    }

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAllNews($order_by = 'id', $sort = 'asc') {
        return News::whereNull('domain_id')->where('activation_date', '<=', Carbon::now())->orderBy($order_by, $sort)->get();
    }

    public function getFeaturedNews($order_by = 'id', $sort = 'desc') {
        return News::whereNull('domain_id')
                        ->where('featured', 1)
                        ->where('activation_date', '<=', Carbon::now())
                        ->orderBy($order_by, $sort)
                        ->get();
    }

    public function getFeaturedNewsByDomain($domain_id, $order_by = 'id', $sort = 'desc') {
        return News::where('domain_id', '=', $domain_id)->where('featured', 1)->where('activation_date', '<=', Carbon::now())->orderBy($order_by, $sort)->get();
    }

    public function getBySearch($term) {
        $news = News::whereNull('domain_id')
                        ->where('activation_date', '<=', Carbon::now())
                        ->whereRaw(
                                "MATCH(title,content,tags) AGAINST(? IN BOOLEAN MODE)", array($term)
                        )->get();



        return $news;
    }

    public function getLastNews() {
        $lastNews = News::where('activation_date', '<=', Carbon::now())
                ->orderBy('activation_date', 'desc')
                ->limit(3)
                ->get();
        return $lastNews;
    }

}
