<?php

namespace App\Repositories\Backend\Course;

use App\Course;
use App\CourseAggregatedCourse;
use App\CourseAggregatedExam;
use App\CourseContent;
use App\Content;
use App\CourseTeacher;
use App\Exceptions\GeneralException;
use App\Group;
use App\Lesson;
use App\Module;
use App\Repositories\Backend\Tag\TagContract;
use App\TeacherLesson;
use Carbon\Carbon;

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
     * @param $per_page
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getCoursesPaginated($per_page, $order_by = 'id', $sort = 'asc', $f_CourseController_title = '', $f_CourseController_active = '', $f_CourseController_featured = '', $f_CourseController_special_offer = '') {
        $query = Course::where('title', 'like', '%' . $f_CourseController_title . '%');
        if ($f_CourseController_active == '1') {
            $query->where('is_active', '=', 1);
        }
        if ($f_CourseController_featured == '1') {
            $query->where('featured', '=', 1);
        }
        if ($f_CourseController_special_offer == '1') {
            $query->where('special_offer', '=', 1);
        }

        return $query->orderBy($order_by, $sort)->paginate($per_page);
    }

    public function getCourses($order_by = 'id', $sort = 'asc', $f_CourseController_title = '', $f_CourseController_active = '', $f_CourseController_featured = '', $f_CourseController_special_offer = '') {
        $query = Course::where('title', 'like', '%' . $f_CourseController_title . '%');
        if ($f_CourseController_active == '1') {
            $query->where('is_active', '=', 1);
        }
        if ($f_CourseController_featured == '1') {
            $query->where('featured', '=', 1);
        }
        if ($f_CourseController_special_offer == '1') {
            $query->where('special_offer', '=', 1);
        }

        return $query->orderBy($order_by, $sort)->get();
    }

    /**
     * @param $per_page
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getCoursesBySection($id, $order_by = 'id', $sort = 'asc') {
        $section_id = $id;
        return Course::whereHas('subsection', function($query) use ($section_id) {
                    $query->where('section_id', $section_id);
                })->get();
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
        return Course::orderBy($order_by, $sort)->get();
    }

    public function desctivate($id) {
        $course = $this->findOrThrowException($id);

        if ($course->update(["is_active" => false])) {
            return $course;
        }
        throw new GeneralException('There was a problem updating this course. Please try again.');
    }

    public function activate($id) {
        $course = $this->findOrThrowException($id);

        if ($course->update(["is_active" => true])) {
            return $course;
        }
        throw new GeneralException('There was a problem updating this course. Please try again.');
    }

    public function deactivate($course) {
        if ($course->update(["is_active" => false])) {
            return $course;
        }
        throw new GeneralException('There was a problem updating this course. Please try again.');
    }

    public function setLessonAdUrl($lesson) {

        $lesson->update(["ad_url" => get_vimeo_thumbnail($lesson->contents->first()->url, 'small')]);
    }

    /**
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function create($input) {
        if (isset($input['tags']))
            $this->tags->createIfNew($input['tags']);
        $course = $this->createCourseStub($input);
        if ($course->save()){
            $course->coordinators()->attach($input['teachers']);
            return $course;
 }
        throw new GeneralException('There was a problem creating this course. Please try again.');
    }

    /**
     * @param $id
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function update($id, $input)
    {
        $course = $this->findOrThrowException($id);

        if (isset($input['tags'])) {
            $this->tags->createIfNew($input['tags']);
        }
        if (isset($input['tags'])) {
            $input['tags'] = implode(';', $input['tags']);
        }else {
            $input['tags'] = '';
        }


        $course->subsection_id = $input['subsection_id'];
        $course->title = $input['title'];
        $course->slug = $input['slug'];
        $course->description = $input['description'];
        $course->short_description = $input['short_description'];
        $course->course_content = $input['course_content'];
        $course->methodology = $input['methodology'];
        $course->testimonials = $input['testimonials'];
        $course->welcome_message = $input['welcome_message'];
        $course->time_per_content = $input['time_per_content'];
        $course->price = parsemoneybr($input['price']);
        $course->discount_price = parsemoneybr($input['discount_price']);
        $course->payment = $input['payment'];
        $course->teachers_percentage = $input['teachers_percentage'];
        $course->special_offer = isset($input['special_offer']) ? 1 : 0;
        $course->featured = isset($input['featured']) ? 1 : 0;
        $course->is_active = isset($input['is_active']) ? 1 : 0;
        $course->show_files = isset($input['show_files']) ? 1 : 0;
        $course->show_alert = isset($input['show_alert']) ? 1 : 0;
        $course->show_calendar = isset($input['show_calendar']) ? 1 : 0;
        $course->generate_certificate = isset($input['generate_certificate']) ? 1 : 0;
        $course->online_for_presential = isset($input['online_for_presential']) ? 1 : 0;
        $course->certification_individual_auth = isset($input['certification_individual_auth']) ? 1 : 0;
        $course->certification_individual_text = $input['certification_individual_text'];
        $course->combo = isset($input['combo']) ? 1 : 0;

        $course->minimum_percentage = $input['minimum_percentage'];
        $course->access_time = $input['access_time'];
        $course->workload = parseminutebr($input['workload']);
        $course->workload_presential = parseminutebr($input['workload_presential']);
        $course->max_installments = $input['max_installments'];
        $course->max_view = $input['max_view'];

        $course->certification = isset($input['certification']) ? $input['certification'] : NULL;
        $course->certification_template = isset($input['certification_template']) ? $input['certification_template'] : NULL;

        $course->target_public = (isset($input['target_public']) && !empty($input['target_public'])) ? $input['target_public'] : NULL;
        $course->demonstrative_lesson = isset($input['demonstrative_lesson']) && !empty($input['demonstrative_lesson']) ? $input['demonstrative_lesson'] : NULL;
        $course->notice = (isset($input['notice']) && !empty($input['notice'])) ? $input['notice'] : NULL;
        $course->differentials = (isset($input['differentials']) && !empty($input['differentials'])) ? $input['differentials'] : NULL;

        if ($input['custom_workshop_title'] != null && $input['custom_workshop_title'] != "") {
            $course->custom_workshop_title = $input['custom_workshop_title'];
        }

        if (isset($input['start_special_price'])) {
            $course->start_special_price = parsebr($input['start_special_price']);
        }
        if (isset($input['end_special_price'])) {
            $course->end_special_price = parsebr($input['end_special_price']);
        }
        if (isset($input['special_price'])) {
            $course->special_price = parsemoneybr($input['special_price']);
        }
        if (isset($input['tags'])) {
            $course->tags = $input['tags'];
        }
        if (isset($input['video_ad_url'])) {
            $course->video_ad_url = $input['video_ad_url'];
        }
        if (isset($input['activation_date'])) {
            $course->activation_date = parsebr($input['activation_date']);
        }
        if (isset($input['featured_img'])) {
            $course->featured_img = $input['featured_img'];
        }
        if (isset($input['classroom_img'])) {
            $course->classroom_img = $input['classroom_img'];
        }

        $course->analysis = $input['analysis'];
        $course->ask_the_teacher = isset($input['ask_the_teacher']) ? 1 : 0;

        $course->meta_title = (isset($input['meta_title']) && !empty($input['meta_title'])) ? $input['meta_title'] : NULL;

        $course->meta_description = (isset($input['meta_description']) && !empty($input['meta_description'])) ? $input['meta_description'] : NULL;

        if ($course->save()){
            if (isset($input['teachers']) && count($input['teachers']) > 0) {
                $course->coordinators()->sync($input['teachers']);
            } else {
                $course->coordinators()->sync([]);
            }
            return $course;
        }

        throw new GeneralException('There was a problem updating this course. Please try again.');
    }

    /**
     * @param $id
     * @param $new_file_name
     * @return bool
     * @throws GeneralException
     */
    public function updateImg($id, $new_file_name) {
        $course = $this->findOrThrowException($id);
        $course->featured_img = $new_file_name;
        if ($course->save())
            return true;

        throw new GeneralException('There was a problem updating this article. Please try again.');
    }

    /**
     * @param $id
     * @param $new_file_name
     * @return bool
     * @throws GeneralException
     */
    public function updateClassroomImg($id, $new_file_name) {
        $course = $this->findOrThrowException($id);
        $course->classroom_img = $new_file_name;
        if ($course->save())
            return true;

        throw new GeneralException('There was a problem updating this article. Please try again.');
    }

    /**
     * @param $id
     * @return bool
     * @throws GeneralException
     */
    public function destroy($id) {
        $course = $this->findOrThrowException($id);
        $course->is_active = 0;
        $course->save();
        if ($course->delete())
            return true;

        throw new GeneralException("There was a problem deleting this course. Please try again.");
    }

    /**
     * @param $input
     * @return mixed
     */
    private function createCourseStub($input) {
        $course = new Course;
        $course->subsection_id = $input['subsection_id'];
        $course->user_admin_id = auth()->id();
        $course->title = $input['title'];
        $course->slug = $input['slug'];
        $course->description = $input['description'];
        $course->short_description = $input['short_description'];
        $course->methodology = $input['methodology'];
        $course->testimonials = $input['testimonials'];
        $course->welcome_message = $input['welcome_message'];
        $course->time_per_content = $input['time_per_content'];
        $course->course_content = $input['course_content'];
        $course->price = parsemoneybr($input['price']);
        $course->discount_price = parsemoneybr($input['discount_price']);
        $course->payment = $input['payment'];
        $course->teachers_percentage = $input['teachers_percentage'];
        $course->special_offer = isset($input['special_offer']) ? 1 : 0;
        $course->featured = isset($input['featured']) ? 1 : 0;
        $course->is_active = isset($input['is_active']) ? 1 : 0;
        $course->show_files = isset($input['show_files']) ? 1 : 0;
        $course->show_alert = isset($input['show_alert']) ? 1 : 0;
        $course->show_calendar = isset($input['show_calendar']) ? 1 : 0;
        $course->generate_certificate = isset($input['generate_certificate']) ? 1 : 0;
        $course->online_for_presential = isset($input['online_for_presential']) ? 1 : 0;
        $course->certification = isset($input['certification']) ? $input['certification'] : NULL;
        $course->certification_template = isset($input['certification_template']) ? $input['certification_template'] : NULL;
        $course->certification_individual_auth = isset($input['certification_individual_auth']) ? 1 : 0;
        $course->certification_individual_text = $input['certification_individual_text'];
        $course->combo = isset($input['combo']) ? 1 : 0;

        $course->minimum_percentage = $input['minimum_percentage'];
        $course->access_time = $input['access_time'];
        $course->workload = parseminutebr($input['workload']);
        $course->workload_presential = parseminutebr($input['workload_presential']);
        $course->max_installments = $input['max_installments'];
        $course->max_view = $input['max_view'];

        $course->target_public = (isset($input['target_public']) && !empty($input['target_public'])) ? $input['target_public'] : NULL;
        $course->demonstrative_lesson = isset($input['demonstrative_lesson']) && !empty($input['demonstrative_lesson']) ? $input['demonstrative_lesson'] : NULL;
        $course->notice = (isset($input['notice']) && !empty($input['notice'])) ? $input['notice'] : NULL;
        $course->differentials = (isset($input['differentials']) && !empty($input['differentials'])) ? $input['differentials'] : NULL;

        if ($input['custom_workshop_title'] != null && $input['custom_workshop_title'] != "")
            $course->custom_workshop_title = $input['custom_workshop_title'];
        if (isset($input['start_special_price']))
            $course->start_special_price = parsebr($input['start_special_price']);
        if (isset($input['end_special_price']))
            $course->end_special_price = parsebr($input['end_special_price']);
        if (isset($input['special_price']))
            $course->special_price = parsemoneybr($input['special_price']);

        if (isset($input['tags']))
            $course->tags = implode(';', $input['tags']);
        if (isset($input['video_ad_url']))
            $course->video_ad_url = $input['video_ad_url'];
        if (isset($input['activation_date']))
            $course->activation_date = parsebr($input['activation_date']);
        if (isset($input['featured_img']))
            $course->featured_img = $input['featured_img'];

        $course->analysis = $input['analysis'];
        $course->ask_the_teacher = isset($input['ask_the_teacher']) ? 1 : 0;

        $course->meta_title = (isset($input['meta_title']) && !empty($input['meta_title'])) ? $input['meta_title'] : NULL;

        $course->meta_description = (isset($input['meta_description']) && !empty($input['meta_description'])) ? $input['meta_description'] : NULL;

        return $course;
    }

    public function selectCourses($term = '', $order_by = 'title', $sort = 'asc') {
        return Course::where('title', 'like', $term . '%')->where('activation_date', '<=', Carbon::now())->orderBy($order_by, $sort)->get();
    }


    public function cloneCourse( $id ){
        $courseOld = Course::find($id);

        if ($courseOld  == null)
            return "Curso inexistente";

        try{
            \DB::beginTransaction();

            $course = new Course;
            $course->is_active = 0;
            $course->title = $courseOld->title . ' :: Copy :: ' . format_datetimebr(Carbon::now());
            $course->slug = $courseOld->slug . '.copia.' .  format_datetimebr(Carbon::now());

            $course->subsection_id = $courseOld->subsection_id;
            $course->user_admin_id = $courseOld->user_admin_id;
            $course->description = $courseOld->description;
            $course->short_description = $courseOld->short_description;
            $course->methodology = $courseOld->methodology;
            $course->testimonials = $courseOld->testimonials;
            $course->welcome_message = $courseOld->welcome_message;
            $course->time_per_content = $courseOld->time_per_content;
            $course->course_content = $courseOld->course_content;
            $course->price = $courseOld->price;
            $course->discount_price = $courseOld->discount_price;
            $course->payment = $courseOld->payment;
            $course->teachers_percentage = $courseOld->teachers_percentage;
            $course->special_offer = $courseOld->special_offer;
            $course->featured = $courseOld->featured;
            $course->show_files = $courseOld->show_files;
            $course->show_alert = $courseOld->show_alert;
            $course->show_calendar = $courseOld->show_calendar;
            $course->generate_certificate = $courseOld->generate_certificate;
            $course->online_for_presential = $courseOld->online_for_presential;
            $course->certification = $courseOld->certification;
            $course->certification_template = $courseOld->certification_template;
            $course->certification_individual_auth = $courseOld->certification_individual_auth;
            $course->certification_individual_text = $courseOld->certification_individual_text;
            $course->combo = $courseOld->combo;

            $course->minimum_percentage = $courseOld->minimum_percentage;
            $course->access_time = $courseOld->access_time;
            $course->workload = $courseOld->workload;
            $course->workload_presential = $courseOld->workload_presential;
            $course->max_installments = $courseOld->max_installments;
            $course->max_view = $courseOld->max_view;
            $course->custom_workshop_title = $courseOld->custom_workshop_title;
            $course->start_special_price = $courseOld->start_special_price;
            $course->end_special_price = $courseOld->end_special_price;
            $course->special_price = $courseOld->special_price;

            $course->tags = $courseOld->tags;
            $course->video_ad_url = $courseOld->video_ad_url;
            $course->activation_date = $courseOld->activation_date;

            $course->analysis = $courseOld->analysis;
            $course->ask_the_teacher = $courseOld->ask_the_teacher;
            $course->meta_title = $courseOld->meta_title;
            $course->meta_description = $courseOld->meta_description;

            $course->save();

            $courseTeachers = CourseTeacher::where('course_id', '=', $courseOld->id)->get();
            foreach ($courseTeachers as $courseTeacherOld) {
                $courseTeacher = new CourseTeacher;
                $courseTeacher->teacher_id = $courseTeacherOld->teacher_id;
                $courseTeacher->percentage = $courseTeacherOld->percentage;
                $courseTeacher->course_id = $course->id;
                $courseTeacher->save();
            }

            $courseDocs = CourseContent::where('course_id', '=', $courseOld->id)->where('is_video', '=', 0)->get();
            foreach ($courseDocs as $docOld) {
                $doc = new CourseContent;
                $doc->course_id = $course->id;
                $doc->title = $docOld->title;
                $doc->sequence = $docOld->sequence;
                $doc->is_video = 0;
                //copiar arquivo e alterar url !!!!!!!!!!!!
                $doc->url = $docOld->url;
                $doc->save();
            }

            $courseAggregatedCourses = CourseAggregatedCourse::where('course_id_bought', '=', $courseOld->id)->get();
            foreach ($courseAggregatedCourses as $courseAggregatedCourseOld) {
                $courseAggregatedCourse = new CourseAggregatedCourse;
                $courseAggregatedCourse->course_id_extra = $courseAggregatedCourseOld->course_id_extra;
                $courseAggregatedCourse->course_id_bought = $course->id;
                $courseAggregatedCourse->save();
            }

            $courseAggregatedExams = CourseAggregatedExam::where('course_id_bought', '=', $courseOld->id)->get();
            foreach ($courseAggregatedExams as $courseAggregatedExamOld) {
                $courseAggregatedExam = new CourseAggregatedExam;
                $courseAggregatedExam->exam_id_extra = $courseAggregatedExamOld->exam_id_extra;
                $courseAggregatedExam->course_id_bought = $course->id;
                $courseAggregatedExam->save();
            }

            $modules = Module::where('course_id', '=', $courseOld->id)->get();
            foreach ($modules as $moduleOld){
                $module = new Module;
                $module->name = $moduleOld->name;
                $module->course_id = $course->id;
                $module->save();

                $lessons = Lesson::where('module_id', '=', $moduleOld->id)->get();
                foreach ($lessons as $lessonOld) {
                    $lesson = new Lesson;
                    $lesson->module_id = $module->id;
                    $lesson->title = $lessonOld->title;
                    $lesson->sequence = $lessonOld->sequence;
                    $lesson->is_active = $lessonOld->is_active;
                    $lesson->save();

                    $videos = Content::where('lesson_id', '=', $lessonOld->id)->where('is_video', '=', 1)->get();
                    foreach ($videos as $videoOld) {
                        $video = new Content;
                        $video->lesson_id = $lesson->id;
                        $video->sequence = $videoOld->sequence;
                        $video->is_video = 1;
                        $video->url = $videoOld->url;
                        $video->save();
                    }

                    $docs = Content::where('lesson_id', '=', $lessonOld->id)->where('is_video', '=', 0)->get();
                    foreach ($docs as $docOld) {
                        $doc = new Content;
                        $doc->lesson_id = $lesson->id;
                        $doc->title = $docOld->title;
                        $doc->sequence = $docOld->sequence;
                        $doc->is_video = 0;
                        //copiar arquivo e alterar url !!!!!!!!!!!!
                        $doc->url = $docOld->url;
                        $doc->save();
                    }

                    $teachers = TeacherLesson::where('lesson_id', '=', $lessonOld->id)->get();
                    foreach ($teachers as $teacherOld) {
                        $teacher = new TeacherLesson;
                        $teacher->lesson_id = $lesson->id;
                        $teacher->teacher_id = $teacherOld->teacher_id;
                        $teacher->percentage = $teacherOld->percentage;
                        $teacher->save();
                    }

                    $groups = Group::where('lesson_id', '=', $lessonOld->id)->get();
                    foreach ($groups as $groupOld) {
                        $group = new Group;
                        $group->lesson_id = $lesson->id;
                        $group->answer_type = $groupOld->answer_type;
                        $group->is_random = $groupOld->is_random;
                        $group->weight = $groupOld->weight;
                        $group->title = $groupOld->title;
                        $group->save();

                        $groupSubjects =  $groupOld->subjects;
                        foreach ($groupSubjects as $groupSubjectOld) {
                            $group->subjects()->attach($groupSubjectOld->id, ['questions_count' => $groupSubjectOld->pivot->questions_count, 'source_id' => $groupSubjectOld->pivot->source_id]);
                        }
                        $group->save();
                    }
                }
            }
            \DB::commit();

            return $course;
        } catch (Exception $e) {
            \DB::rollback();
            return view('frontend.preenrollments.subscribe')->withError(trans("alerts.preenrollments.error"));
        }
    }
}
