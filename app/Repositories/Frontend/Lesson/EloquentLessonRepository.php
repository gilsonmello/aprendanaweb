<?php

namespace App\Repositories\Frontend\Lesson;

use App\Lesson;
use App\Exceptions\GeneralException;
use App\Repositories\Backend\Tag\TagContract;

/**
 * Class EloquentCourseRepository
 * @package App\Repositories\Course
 */
class EloquentLessonRepository implements LessonContract {

    public function __construct(TagContract $tags) {
        $this->tags = $tags;
    }

    /**
     * @param $id
     * @return mixed
     * @throws GeneralException
     */
    public function findOrThrowException($id) {
        $lesson = Lesson::withTrashed()->find($id);

        if (!is_null($lesson))
            return $lesson;

        throw new GeneralException('That lesson does not exist.');
    }

    /**
     * @param $per_page
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getsLessonPaginated($per_page, $order_by = 'id', $sort = 'asc') {
        return Lesson::orderBy($order_by, $sort)->paginate($per_page);
    }

    /**
     * @param $per_page
     * @return \Illuminate\Pagination\Paginator
     */
    public function getDeletedLessonsPaginated($per_page) {
        return Lesson::onlyTrashed()->paginate($per_page);
    }

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAllLessons($order_by = 'sequence', $sort = 'asc') {
        return Lesson::orderBy($order_by, $sort)->get();
    }

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAllLessonsByModule($module_id, $order_by = 'sequence', $sort = 'asc') {
        return Lesson::where('module_id', '=', $module_id)->orderBy($order_by, $sort)->get();
    }

    /**
     * @param int $limit
     * @return mixed
     */
    public function getFeatured($limit = 8) {
        return Lesson::where('featured', 1)->take($limit)->get();
    }

    /**
     * @param int $limit
     * @return mixed
     */
    public function getRelease($limit = 8) {
        return Lesson::orderBy('created_at', 'desc')->take($limit)->get();
    }

    /**
     * @param int $limit
     * @return mixed
     */
    public function getSpecialOffer($limit = 8) {
        return Lesson::where('special_offer', 1)->take($limit)->get();
    }

    /**
     * @param int $limit
     * @return mixed
     */
    public function getRecommended($limit = 8) {
        return Lesson::orderBy('average_grade', 'desc')->take($limit)->get();
    }

    /**
     * @param int $limit
     * @return mixed
     */
    public function getBestSelling($limit = 8) {
        return Lesson::orderBy('orders_count', 'desc')->take($limit)->get();
    }

}
