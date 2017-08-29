<?php

namespace App\Repositories\Backend\Module;

use App\Module;
use App\TeacherLesson;
use App\Exceptions\GeneralException;
use App\Repositories\Backend\Tag\TagContract;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

/**
 * Class EloquentModuleRepository
 * @package App\Repositories\Module
 */
class EloquentModuleRepository implements ModuleContract {

    public function __construct(TagContract $tags) {
        $this->tags = $tags;
    }

    /**
     * @param $id
     * @return mixed
     * @throws GeneralException
     */
    public function findOrThrowException($id) {
        $module = Module::withTrashed()->find($id);

        if (!is_null($module))
            return $module;

        throw new GeneralException('That module does not exist.');
    }

    /**
     * @param $per_page
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getModulesPaginated($per_page, $order_by = 'id', $sort = 'asc') {
        return Module::orderBy($order_by, $sort)->paginate($per_page);
    }

    /**
     * @param $per_page
     * @return \Illuminate\Pagination\Paginator
     */
    public function getDeletedModulesPaginated($per_page) {
        return Module::onlyTrashed()->paginate($per_page);
    }

    /**
     * @param string $order_by
     * @param string $sort
     * @return mixed
     */
    public function getAllModules($order_by = 'id', $sort = 'asc') {
        return Module::orderBy($order_by, $sort)->get();
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



        $module = $this->createModuleStub($input);
        if ($module->save())
            return $module;
        throw new GeneralException('There was a problem creating this module. Please try again.');
    }

    /**
     * @param $id
     * @param $input
     * @return bool
     * @throws GeneralException
     */
    public function update($id, $input) {
        $module = $this->findOrThrowException($id);

        if (isset($input['tags']) && $input['tags'] > 0) {
            $this->tags->createIfNew($input['tags']);
        }
        if (isset($input['tags']))
            $input['tags'] = implode(';', $input['tags']);


        if ($module->update($input)) {
            $module->subsection_id = $input['subsection_id'];
            $module->name = $input['name'];
            $module->description = $input['description'];
            $module->price = $input['price'];
            $module->discount_price = $input['discount_price'];
            $module->sequence = $input['sequence'];
            if (isset($input['tags']))
                $module->tags = $input['tags'];
            if (isset($input['video_ad_url']))
                $module->video_ad_url = $input['video_ad_url'];
            if (isset($input['activation_date']))
                $module->activation_date = parsebr($input['activation_date']);
            if (isset($input['featured_img']))
                $module->featured_img = $input['featured_img'];
            if (isset($input['presential']))
                $module->presential = true;
            else
                $module->presential = false;
            if (isset($input['complementary']))
                $module->complementary = true;
            else
                $module->complementary = false;


            if ($module->save())
                return $module;
            else
                return null;
        }

        throw new GeneralException('There was a problem updating this module. Please try again.');
    }

    /**
     * @param $id
     * @param $new_file_name
     * @return bool
     * @throws GeneralException
     */
    public function updateImg($id, $new_file_name) {
        $module = $this->findOrThrowException($id);
        $module->featured_img = $new_file_name;
        if ($module->save())
            return true;

        throw new GeneralException('There was a problem updating this article. Please try again.');
    }

    /**
     * @param $id
     * @return bool
     * @throws GeneralException
     */
    public function destroy($id) {
        $module = $this->findOrThrowException($id);
        if ($module->delete())
            return true;

        throw new GeneralException("There was a problem deleting this module. Please try again.");
    }

    public function basicCreate($name, $course_id) {
        $module = $this->createBasicModuleStub($name, $course_id);
        $module->course()->associate($course_id);
        if ($module->save()) {



            return $module;
        }
        throw new GeneralException('There was a problem creating this module. Please try again.');
    }

    public function createBasicModuleStub($name) {
        $module = new Module;
        $module->is_sold_separately = 0;
        $module->name = $name;
        return $module;
    }

    /**
     * @param $input
     * @return mixed
     */
    private function createModuleStub($input) {
        $module = new Module;
        $module->subsection_id = $input['subsection_id'];
        $module->name = $input['name'];
        $module->description = $input['description'];
        $module->price = $input['price'];
        $module->discount_price = $input['discount_price'];
        $module->sequence = $input['sequence'];
        $module->is_sold_separately = 1;
        if (isset($input['tags']))
            $module->tags = implode(';', $input['tags']);
        if (isset($input['video_ad_url']))
            $module->video_ad_url = $input['video_ad_url'];
        if (isset($input['activation_date']))
            $module->activation_date = parsebr($input['activation_date']);
        if (isset($input['featured_img']))
            $module->featured_img = $input['featured_img'];
        if (isset($input['presential']))
            $module->presential = true;
        else
            $module->presential = false;
        if (isset($input['complementary']))
            $module->complementary = true;
        else
            $module->complementary = false;

        return $module;
    }

    public function selectModules($term = '', $order_by = 'name', $sort = 'asc') {


        return Module::where('name', 'like', $term . '%')->where('activation_date', '<=', Carbon::now())->orderBy($order_by, $sort)->get();
    }

    public function getAllModulesPerCourse($course, $order_by = 'sequence', $sort = 'asc') {
        $query = Module::where('course_id', '=', $course->id);
        return $query->orderBy($order_by, $sort)->get();
    }

    public function getPresentialModulesPerCourse($course, $order_by = 'sequence', $sort = 'asc') {
        $query = Module::where('course_id', '=', $course->id)->where('presential', '=', 1);
        return $query->orderBy($order_by, $sort)->get();
    }

    public function getComplementaryModulesPerCourse($course, $order_by = 'sequence', $sort = 'asc') {
        $query = Module::where('course_id', '=', $course->id)->where('complementary', '=', 1);
        return $query->orderBy($order_by, $sort)->get();
    }

    public function getOnlineModulesPerCourse($course, $order_by = 'sequence', $sort = 'asc') {
        $query = Module::where('course_id', '=', $course->id)->where('complementary', '=', 0)->where('presential', '=', 0);
        $return = $query->orderBy($order_by, $sort)->get();
        return $return;
    }

    public function getLessonsPerTeacherPerModule($module) {
        $teachers = TeacherLesson::join('lessons', 'lessons.id', '=', 'lesson_teachers.lesson_id')
                        ->join('users', 'users.id', '=', 'lesson_teachers.teacher_id')
                        ->where('lessons.module_id', '=', $module->id)
                        ->groupBy('users.name', 'users.id', 'users.photo')
                        ->select('users.name as name', 'users.id as id', 'users.photo as photo', 'users.educational_title as educational_title', DB::raw('count(*) as lesson_teachers'))
                        ->orderBy('users.name', 'asc')->get();
        return $teachers;
    }

}
