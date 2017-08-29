<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Repositories\Frontend\Course\CourseContract;
use App\Repositories\Frontend\News\NewsContract;
use App\Repositories\Frontend\Package\PackageContract;
use Illuminate\Support\Collection;

/**
 * Class DashboardControllerapp/Http/Controllers/Backend/NewsController.php:7
 * @package App\Http\Controllers\Backend
 */
class NewsController extends Controller {

    /**
     * @param NewsContract $news
     */
    public function __construct(NewsContract $news, CourseContract $courses, PackageContract $packages) {
        $this->news = $news;
        $this->courses = $courses;
        $this->packages = $packages;
    }

    /**
     * @return mixed
     */
    public function index() {

        $featured_news = $this->news->getFeaturedNews()->take(3);
        $except_ids = $featured_news->pluck('id');

        $news = $this->news->getNewsPaginated(10, 'activation_date', 'desc', $except_ids);



        return view('frontend.news.index')
                        ->withNews($news)
                        ->withFeatureds($featured_news);
    }

    public function show_share() {
        return view('frontend.news.show_to_share');
    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id) {


        $news = $this->news->findOrThrowException($id, true);
        $news->hits = $news->hits + 1;
        $news->save();
        $news->video_frag = parse_video($news->video);

        $tags = $news->tags;
        if ($tags != null && $tags != '') {
            $tags = explode(";", $tags);
        }



        $news_remaining = 3;
        $more_news = Collect([]);

//Comentado por solicitação de Fontenele
//        if ($tags != '') {
//            foreach ($tags as $tag) {
//                if ($news_remaining > 0) {
//                    $more_news = $more_news->merge($this->news->getBySearch($tag)->diff($more_news));
//                    $news_remaining = $news_remaining - $more_news->count();
//                }
//            }
//        }
//         dd($more_news);
//
//        if ($news_remaining > 0) {
//            $more_news = $more_news->merge($this->news->getFeaturedNews()->diff($more_news));
//        }
        /**
         * Fontenele solicitou que fosse exibida apenas as últimas notícias
         * 10/02/2017
         */
        $more_news = $this->news->getLastNews();
        /*
         * ***************************************************
         */

        $packages_remaining = 8;
        $more_packages = Collect([]);

        if (count($tags) > 0) {
            foreach ($tags as $tag) {
//                if ($packages_remaining > 0) {
                $more_packages = $more_packages->merge($this->packages->getPackageByTags($tag));
//                    $packages_remaining = $packages_remaining - $more_packages->count();
//                }
            }
        }

        $courses_remaining = 2;
        $more_courses = Collect([]);


        if ($tags != '') {
            foreach ($tags as $tag) {

//                if ($courses_remaining > 0) {
//                dd($this->courses->getCourseByTags($tag));
                $more_courses = $more_courses->merge($this->courses->getCourseByTags($tag));
//                    $courses_remaining = $courses_remaining - $more_courses->count();
//                }
            }
        }
//        if ($courses_remaining > 0) {
//            $more_courses = $more_courses->merge($this->courses->getFeatured()->take($courses_remaining)->diff($more_courses));
//        }

        return view('frontend.news.show')
                        ->withNews($news)
                        ->withMoreNews($more_news->take(3))
                        ->withMorePackages($more_packages->shuffle()->take(2))
                        ->withMoreCourses($more_courses->take(2));
    }

}
