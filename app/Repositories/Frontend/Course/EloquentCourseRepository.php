<?php

namespace App\Repositories\Frontend\Course;

use App\Course;
use App\Exceptions\GeneralException;
use App\Repositories\Backend\Tag\TagContract;
use Carbon\Carbon;
use App\CourseAggregatedExam;

/**
 * Class EloquentCourseRepository
 * @package App\Repositories\Course
 */
class EloquentCourseRepository implements CourseContract {

    public function __construct(TagContract $tags) {
        $this->tags = $tags;
    }

    /**
     * @param $id
     * @return mixed
     * @throws GeneralException
     */
    public function findOrThrowException($id) {
        $course = Course::withTrashed()->find($id);
        if (!is_null($course))
            return $course;

        throw new GeneralException('That course does not exist.');
    }

    /**
     * @param $slug
     * @return mixed
     * @throws GeneralException
     */
    public function findBySlug($slug) {
        $course = Course::where('is_active', 1)->where('activation_date', '<=', Carbon::now())->where('slug', $slug)->first();
        if (!is_null($course))
            return $course;
    }

    /**
     * @param $per_page
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getCoursesPaginated($per_page, $order_by = 'id', $sort = 'asc') {
        return Course::where('is_active', 1)->where('activation_date', '<=', Carbon::now())->orderBy($order_by, $sort)->paginate($per_page);
    }

    /**
     * @param $per_page
     * @return \Illuminate\Pagination\Paginator
     */
    public function getDeletedCoursesPaginated($per_page) {
        return Course::onlyTrashed()->paginate($per_page);
    }

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAllCourses($order_by = 'id', $sort = 'asc') {
        return Course::where('is_active', 1)->where('activation_date', '<=', Carbon::today())->orderBy($order_by, $sort)->get();
    }

    /**
     * @param int $limit
     * @return mixed
     */
    public function getFeatured($limit = 8) {
        return Course::with('subsection.section')->where('is_active', 1)->where('activation_date', '<=', Carbon::today())->where('featured', 1)->paginate($limit);
    }

    /**
     * @param int $limit
     * @return mixed
     */
    public function getRelease($limit = 8) {
        return Course::with('subsection.section')->where('is_active', 1)->where('activation_date', '<=', Carbon::now())->orderBy('activation_date', 'desc')->paginate($limit);
    }

    /**
     * @param int $limit
     * @return mixed
     */
    public function getSpecialOffer($limit = 8) {
        return Course::with('subsection.section')->where('is_active', 1)->where('activation_date', '<=', Carbon::today())->where('special_offer', 1)->paginate($limit);
    }

    /**
     * @param int $limit
     * @return mixed
     */
    public function getRecommended($limit = 8) {
        return Course::with('subsection.section')->where('is_active', 1)->where('activation_date', '<=', Carbon::today())->orderBy('average_grade', 'desc')->paginate($limit);
    }

    /**
     * @param int $limit
     * @return mixed
     */
    public function getBestSelling($limit = 8) {
        return Course::with('subsection.section')->where('is_active', 1)->where('activation_date', '<=', Carbon::today())->orderBy('orders_count', 'desc')->paginate($limit);
    }

    public function getBySectionName($name, $limit = 8) {
        return Course::with('subsection.section')->join('subsections', 'subsection_id', '=', 'subsections.id')->join('sections', 'subsections.section_id', '=', 'sections.id')->where('is_active', 1)->where('activation_date', '<=', Carbon::now())->where('sections.name', $name)->orderBy('featured', 'desc')->select("courses.*")->paginate($limit);
    }

    /**
     * @param $term
     * @return mixed
     */
    public function getBySearch($term) {
        return Course::where('is_active', 1)->where('activation_date', '<=', Carbon::now())->whereRaw(
                        "MATCH(title,description,course_content,tags) AGAINST(? IN BOOLEAN MODE)", array($term)
                )->get();
    }

    /**
     * @param $term
     * @return mixed
     */
    public function getCourseByTags($term, $limit = 8) {

        $arrTags = explode(';', $term);
        $courses = Course::where('is_active', 1)
                ->where('activation_date', '<=', Carbon::now());

        $i = 0;
        foreach ($arrTags as $value => $tag) {
            if ($i == 0) {
                $courses->where('tags', 'like', '%' . $tag . '%');
            } else {
                $courses->orWhere('tags', 'like', '%' . $tag . '%');
            }
            $i++;
        }

        
        
        return $courses->get()->take($limit);
    }

    public function findEager($id) {
        $course = Course::with('modules.lessons.contents')->find($id);

        if (!is_null($course))
            return $course;

        throw new GeneralException('That course does not exist.');
    }

    public function incrementClick($course, $count = 1) {
        $course->indication_count = $course->indication_count + $count;
        $course->save();
    }

    /**
     * Recupera os cursos que possuem Exams associados
     * return CourseAggregatedExam Object
     */
    public function getCourseWithExamsAgregated() {
        $examAgregatedForCourse = CourseAggregatedExam::
                select('course_id_bought as id')
                ->groupBy('course_id_bought')
                ->orderBy('course_id_bought')
                ->get();

        return $examAgregatedForCourse;
    }

    /**
     * Recupera os exams agregados aos cursos
     * return ID dos exams Object
     */
    public function getExamsAgregatedCourse($course_id) {
        $exams = CourseAggregatedExam::where('course_id_bought', '=', $course_id)
                ->select('id')
                ->orderBy('course_id_bought')
                ->get();

        return $exams;
    }

}
