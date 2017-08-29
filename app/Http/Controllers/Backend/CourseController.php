<?PHP

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Course\CreateCourseRequest;
use App\Http\Requests\Backend\Course\UpdateCourseRequest;
use App\Lesson;
use App\Repositories\Backend\Course\CourseContract;
use App\Repositories\Backend\CourseTeacher\CourseTeacherContract;
use App\Repositories\Backend\Exam\ExamContract;
use App\Repositories\Backend\Group\GroupContract;
use App\Repositories\Backend\Lesson\LessonContract;
use App\Repositories\Backend\Module\ModuleContract;
use App\Repositories\Backend\Content\ContentContract;
use App\Repositories\Backend\CourseContent\CourseContentContract;
use App\Repositories\Backend\Source\SourceContract;
use App\Repositories\Backend\Subject\SubjectContract;
use App\Repositories\Backend\Subsection\SubsectionContract;
use App\Repositories\Backend\User\UserTeacherContract;
use App\Repositories\Backend\Configuration\ConfigurationContract;
use App\Services\UploadService\UploadService;
use Illuminate\Http\Request;
use Input;
use LiveControl\EloquentDataTable\DataTable;
use App\Module;
use Symfony\Component\HttpFoundation\Session\Session;
use App\User;


/**
 * Class DashboardController
 * @package App\Http\Controllers\Backend
 */
class CourseController extends Controller {

    /**
     * @param CourseContract $courses
     * @param SubsectionContract $subsections
     * @param UploadService $uploadService
     */
    public function __construct(CourseContract $courses, SubsectionContract $subsections, ModuleContract $modules, LessonContract $lessons, ContentContract $contents, UserTeacherContract $teachers, UploadService $uploadService, CourseTeacherContract $courseTeacher, ConfigurationContract $configurations, ExamContract $exams, SubjectContract $subjects, GroupContract $groups, SourceContract $sources, CourseContentContract $courseContent) {

        $this->courses = $courses;
        $this->subsections = $subsections;
        $this->uploadService = $uploadService;
        $this->modules = $modules;
        $this->lessons = $lessons;
        $this->contents = $contents;
        $this->teachers = $teachers;
        $this->uploadService = $uploadService;
        $this->courseTeacher = $courseTeacher;
        $this->configurations = $configurations;
        $this->exams = $exams;
        $this->subjects = $subjects;
        $this->groups = $groups;
        $this->sources = $sources;
        $this->courseContent = $courseContent;
    }

    /**
     * @return mixed
     */
    public function index(Request $request) {

        $request->session()->put('lastpage', $request->only('page')['page']);

        $f_submit = $request->input('f_submit', '');

        $f_CourseController_title = get_parameter_or_session($request, 'f_CourseController_title', '', $f_submit, '');

        $f_CourseController_is_active = get_parameter_or_session($request, 'f_CourseController_is_active', '', $f_submit, '');

        $f_CourseController_featured = get_parameter_or_session($request, 'f_CourseController_featured', '', $f_submit, '');

        $f_CourseController_special_offer = get_parameter_or_session($request, 'f_CourseController_special_offer', '', $f_submit, '');

        $f_CourseController_validation = get_parameter_or_session($request, 'f_CourseController_validation', '', '1', '');

        if ($f_CourseController_validation != '1') {
            return view('backend.courses.index')
                            ->withCourses($this->courses->getCoursesPaginated(config('access.users.default_per_page'), 'id', 'asc', $f_CourseController_title, $f_CourseController_is_active, $f_CourseController_featured, $f_CourseController_special_offer))
                            ->withCoursecontrollertitle($f_CourseController_title)
                            ->withCoursecontrollerisactive($f_CourseController_is_active)
                            ->withCoursecontrollerfeatured($f_CourseController_featured)
                            ->withCoursecontrollerspecialoffer($f_CourseController_special_offer);
        } else {
            return view('backend.courses.list')
                            ->withCourses($this->courses->getCourses('id', 'asc', $f_CourseController_title, $f_CourseController_is_active, $f_CourseController_featured, $f_CourseController_special_offer));
        }
    }

    /**
     * @return mixed
     */
    public function create() {
        $subsections = $this->subsections->getSubsectionsSelect();

        $configuration = $this->configurations->findOrThrowException(1, true); //added code 1, as must only exists one row in configuration table
        //
        return view('backend.courses.create')
            ->withSubsections($subsections)
            ->withConfiguration($configuration)
            ->withTeachers(User::teachers()->get());
    }

    /**
     * @param CreateCourseRequest $request
     * @return mixed
     */
    public function store(CreateCourseRequest $request) {
        $course = $this->courses->create($request);
        
        if ($request->hasFile('featured_img')) {
            $upload_result = $this->uploadService->addImg($request->file('featured_img'), "featured_img_course", $course->id, 'courses');
            if (!isset($upload_result['error']))
                $this->courses->updateImg($course->id, $upload_result['filename']);
        }

        if ($request->hasFile('classroom_img')) {
            $upload_result = $this->uploadService->addImg($request->file('classroom_img'), "classroom_img_course", $course->id, 'courses');
            if (!isset($upload_result['error']))
                $this->courses->updateClassroomImg($course->id, $upload_result['filename']);
        }
        

        return redirect()->route('admin.courses.tabs', $course->id)->withFlashSuccess(trans("alerts.courses.created"));
    }

    public function aggregateSaapToCourse(Request $request) {
        $couseAggregated = new \App\CourseAggregatedExam();
        $couseAggregated->course_id_bought = $_POST["course_id_bought"];
        $couseAggregated->exam_id_extra = $_POST["exam_id_extra"];
        $couseAggregated->save();
        
        $couseAggregated->exam_title = $_POST["exam_title"];
        return json_encode($couseAggregated);
    }

    public function getAggregateSaapToCourse($course_id) {
        $examsOFCourse = \App\CourseAggregatedExam::join('exams as e', 'e.id', '=', 'courses_aggregated_exams.exam_id_extra')
                ->where('courses_aggregated_exams.course_id_bought', '=', $course_id)
                ->orderBy('e.title')
                ->selectRaw('e.id, title')
                ->get();
        return json_encode($examsOFCourse);
    }

    //@todo
    public function deleteAggregateSaapToCourse($course_id) {
        $return = ['status' => true];
        return $return;
    }

    public function course_teachers() {
        $course = $this->courses->findOrThrowException($_POST["course"]);
        return view('backend.courses.course-teachers');
    }

    public function tabs($id) {
        $course = $this->courses->findOrThrowException($id, true);
        $subsections = $this->subsections->getSubsectionsSelect();
        $exams = $this->exams->getExamsSelect();

        $view = view('backend.courses.tabs')
                ->withCourse($course)
                ->withExams($exams)
                ->withSubsections($subsections)
                ->withTeachers(User::teachers()->get());

        if ($course->groups != null && !$course->groups->isEmpty())
            $view->withGroup($course->groups->first());

        return $view;
    }

    public function modules() {

        if ($_POST["name"] != null && $_POST["name"] != "") {
            $module = $this->modules->basicCreate($_POST["name"], $_POST["course_id"]);
            return json_encode($module);
        } else {
            return ["error" => (trans("alerts.modules.noname"))];
        }
    }

    public function lessons($id) {
        $lessons = new Lesson();
        $dataTable = new DataTable($lessons->where('module_id', '=', $id)->orderBy('sequence', 'asc'), ['title', 'sequence', 'id', 'id']);


        $dataTable->setFormatRowFunction(function ($lessons) {
            return [
                $lessons->id,
                $lessons->sequence,
                $lessons->title,
                $lessons->contents->whereLoose('is_video', 1)->count(),
                '<a href="#" data-target-id="' . $lessons->id . '"  name="create-questions' . $lessons->id . '" class="btn btn-xs btn-primary create-questions">Associar</a>',
                '<a href="#" data-target-id="' . $lessons->id . '" data-method="delete" class="btn btn-xs btn-danger delete-lesson"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="' . trans('crud.delete_button') . '"></i></a>'
            ];
        });


        return $dataTable->make();
    }

    public function addLessons() {
        $lesson = $this->lessons->basicCreate($_POST['module_id'], $_POST["title"], $_POST["sequence"], $_POST["duration"]);
        return json_encode($lesson);
    }

    public function editLessons() {
        $lesson = $this->lessons->findOrThrowException($_POST['lesson_id']);
        $subsections = $this->subsections->getSubsectionsSelect();
        $exams = $this->exams->getExamsSelect();
        return view('backend.courses.lessons')->withLesson($lesson)->withSubsections($subsections)->withExams($exams);
    }

    public function editModule() {
        $module = $this->modules->findOrThrowException($_POST['module_id'], true);
        $subsections = $this->subsections->getSubsectionsSelect();
        return view('backend.courses.module')->withModule($module)->withSubsections($subsections);
    }

    public function editLessonContent() {
        $lesson = $this->lessons->findOrThrowException($_POST['lesson_id']);
        //$contents = $lesson->contents;
        $contents = $this->contents->findByLesson($_POST['lesson_id'])->whereLoose('is_video', 1);

        return view('backend.courses.videos')->withLesson($lesson)->withContents($contents);
    }

    public function editLessonMaterial() {

        $lesson = $this->lessons->findOrThrowException($_POST['lesson_id']);
        //$contents = $lesson->contents;
        $contents = $this->contents->findByLesson($_POST['lesson_id'])->whereLoose('is_video', '0');


        return view('backend.courses.material')->withLesson($lesson)->withContents($contents);
    }

    public function saveMaterial() {
        $lesson_id = $_POST['lesson_id'];
        $name = $_POST['material'];


        $file = ['file' => Input::file('material-upload')];

        $destinationPath = 'uploads/lessons/' . $_POST['lesson_id']; // upload path
        $fileName = Input::file('material-upload')->getClientOriginalName(); // renameing image
        Input::file('material-upload')->move($destinationPath, $fileName);
        $content = $this->contents->saveFile($lesson_id, $name, $destinationPath . '/' . $fileName);


        return ["choosen" => $name, "name" => $fileName, "extension" => Input::file('material-upload')->getClientOriginalExtension(), "id" => $content->id, "url" => $content->url];
    }

    public function saveCourseMaterial() {
        $course_id = $_POST['course_id'];
        $name = $_POST['course-material'];


        $file = ['file' => Input::file('course-material-upload')];

        $destinationPath = 'uploads/lessons/' . $_POST['course_id']; // upload path
        $fileName = Input::file('course-material-upload')->getClientOriginalName(); // renameing image
        Input::file('course-material-upload')->move($destinationPath, $fileName);
        $content = $this->courseContent->saveFile($course_id, $name, $destinationPath . '/' . $fileName);


        return ["choosen" => $name, "name" => $fileName, "extension" => Input::file('course-material-upload')->getClientOriginalExtension(), "id" => $content->id, "url" => $content->url];
    }

    public function removeMaterial() {
        if ($this->contents->destroy($_POST['content']))
            return 'true';
        return 'false';
    }

    public function removeCourseMaterial() {
        if ($this->courseContent->destroy($_POST['course-content']))
            return 'true';
        return 'false';
    }

    public function removeModule() {
        $module = $this->modules->findOrThrowException($_POST["module"]);
        if ($module->lessons->isEmpty()) {

            if ($this->modules->destroy($_POST["module"]))
                return 'true';
            return 'false';
        }else {
            return 'full';
        }
    }

    public function removeLesson() {
        $lesson = $this->lessons->findOrThrowException($_POST["lesson"]);

        if ($lesson != null || $lesson->contents->isEmpty() || !$lesson->contents->search(function($item) {
                    return $item->views->isEmpty();
                })) {

            if ($this->lessons->destroy($_POST["lesson"]))
                return 'true';
            return 'false';
        }else {
            return 'full';
        }
    }

    public function editTeachers() {
        $lesson = $this->lessons->findOrThrowException($_POST['lesson_id']);
        $relations = $lesson->teachers()->get()->unique();
        $teachersSelect = $this->teachers->getAllUserTeachers();


        return view('backend.courses.teachers')->withRelations($relations)->withTeachers($teachersSelect);
    }

    public function datatables($id) {
        $modules = new Module();
        $dataTable = new DataTable($modules->where('course_id', '=', $id), ['name', 'id', 'id', 'id']);


        $dataTable->setFormatRowFunction(function ($modules) {
            return [
                $modules->id,
                $modules->name,
                $modules->id,
                '<a href="#" data-target-id="' . $modules->id . '"  name="edit-module-' . $modules->id . '" class="btn btn-xs btn-primary edit-module"><i class="fa fa-book" data-toggle="tooltip" data-placement="top" title="' . trans('crud.edit_button') . '"></i></a>',
                '<a href="#" data-target-id="' . $modules->id . '" data-method="delete" class="btn btn-xs btn-danger delete-module"><i class="fa fa-trash" data-toggle="tooltip" data-placement="top" title="' . trans('crud.delete_button') . '"></i></a>'
            ];
        });


        return $dataTable->make();
    }

    public function updateLessonContent() {

        //  $videos = array();
        //   parse_str($_POST['video'],$videos);
        $error = null;
        $videos = $_POST['video'];
        $lesson = $this->lessons->findOrThrowException($_POST['lesson_id']);
        $teste = "";

        foreach ($videos as $sequence => $url) {



            $teste = $teste . " | " . $sequence . " -> " . $url;

            if ($url != "" && $url != null) {

                if (starts_with($url, 'vimeo:')) {
                    $url = 'https://player.vimeo.com/video/' . substr($url, 6);
                } else if (starts_with($url, 'http://')) {
                    $url = 'https://' . substr($url, 7);
                }
            }


            $new_content = @$this->contents->findByLessonAndSequence($_POST['lesson_id'], $sequence);




            if ($new_content != null && $new_content != false) {

                if ($url == "" || $url == null)
                    $this->contents->destroy($new_content->id);
                else
                    $this->contents->update($new_content, $url);
            }else {

                if ($url == "" || $url == null)
                    continue;
                $this->contents->create($lesson, $url, $sequence);
            }
        }

        return $teste;
    }

    public function updateTeachers() {

        $teachers_proportion = $_POST['teachers'];

        $lesson = $this->lessons->findOrThrowException($_POST['lesson_id']);


        foreach ($teachers_proportion as $userTeacher => $percentage) {
            $this->lessons->linkTeacher($_POST['lesson_id'], $userTeacher, $percentage);
        }


        return "Professores gravados com sucesso";
    }

    public function updateCourseTeachers() {

        $teachers_proportion = $_POST['teachers'];

        $course = $this->courses->findOrThrowException($_POST['course']);




        foreach ($teachers_proportion as $userTeacher => $percentage) {
            $courseTeacher = $this->courseTeacher->findByCourseAndTeacher($course->id, $userTeacher);


            if ($courseTeacher == null) {
                $this->courseTeacher->create($userTeacher, $course->id, $percentage);
            } else {
                $this->courseTeacher->update($courseTeacher->id, $percentage);
            }
        }


        return "Professores gravados com sucesso";
    }

    public function totalizeTeachers() {
        $teachers_by_course = $this->totalPercentageByCourse($_POST['course'], true);
        //dd($teachers_by_course);

        $course = $this->courses->findOrThrowException($_POST['course']);

        $this->courseTeacher->destroyByCourse($_POST['course']);




        foreach ($teachers_by_course as $teacher_id => $percentage) {
            $courseTeacher = $this->courseTeacher->findByCourseAndTeacher($course->id, $teacher_id);

            if ($courseTeacher == null) {
                $this->courseTeacher->create($teacher_id, $course->id, $percentage);
            } else {
                $this->courseTeacher->update($courseTeacher->id, $percentage);
            }
        }



        return view('backend.courses.course-teachers')->withCourse($course)->render();
    }

    public function removeCourseTeacher() {
        $course_teacher = $this->courseTeacher->findByCourseAndTeacher($_POST['course'], $_POST['teacher']);
        if($this->courseTeacher->destroy($course_teacher->id)){
            return "saved";
        }
        return "error";
    }

    public function removeLessonTeacher() {
        $teacher = $this->lessons->unlinkTeacher($_POST['lesson'], $_POST['teacher']);
        return "saved";
        //   $lesson_teacher = $this->findByCourseAndTeacher($_POST['course'],$_POST['teacher']);
        //   $this->courseTeacher->destroy($course_teacher->id);
        //  return "saved";
    }

    public function updateModule() {

        $params = array();
        parse_str($_POST["form"], $params);

        $module = $this->modules->update($_POST['id'], $params);

        /*
          if($request->hasFile('featured_img')) {
          $upload_result = $this->uploadService->editImg($request->file('featured_img'), $module->title, $module->id, 'modules', $module->featured_img_sizes);
          if(!isset($upload_result['error'])) $this->modules->updateImg($module->id, $upload_result['filename']);
          }
         */

        if ($module == null)
            return ["error" => (trans('alerts.modules.error'))];
        return ["success" => (trans("alerts.modules.updated"))];
    }

    public function updateLesson() {
        $params = array();
        parse_str($_POST["form"], $params);

        $lesson = $this->lessons->update($_POST['id'], $params);

        return ["success" => (trans("alerts.lessons.updated"))];
    }

    public function maxSequence() {

        return $this->lessons->getMaxSequence($_POST['id']);
    }

    public function unblock() {
        $course = $this->courses->findOrThrowException($_POST['course']);
        $modules = $course->modules()->get();
        if (!$modules->first()) {
            return ["error" => trans("alerts.modules.empty")];
        }
        foreach ($modules as $module) {

            $lessons = $module->lessons()->get();
            if (!$lessons->first()) {
                return ["error" => trans("alerts.lessons.empty")];
            }

            foreach ($lessons as $lesson) {
                $videos = $lesson->contents()->get();
                if (!$videos->first()) {
                    return ["error" => trans("alerts.videos.empty")];
                }

                $teachers = $lesson->teachers()->get();
                if (!$teachers->first()) {
                    return ["error" => trans("alerts.courses.teachers_empty")];
                }
            }

            $teachers_by_course = $this->totalPercentageByCourse($course->id);

            foreach ($teachers_by_course as $teacher_id => $percentage) {
                $courseTeacher = $this->courseTeacher->findByCourseAndTeacher($course->id, $teacher_id);

                if ($courseTeacher == null) {
                    $this->courseTeacher->create($teacher_id, $course->id, $percentage);
                } else {
                    $this->courseTeacher->update($courseTeacher->id, $percentage);
                }
            }

            $this->courses->activate($_POST['course']);

            return ["success" => trans("alerts.courses.unblock")];
        }
    }

    public function block($id = null) {
        $course_id = $id == null ? $_POST['course'] : $id;
        $course = $this->courses->findOrThrowException($course_id);
        $this->courses->deactivate($course);

        return ["error" => trans('alerts.courses.block')];
    }

    public function totalPercentageByModule($module_id = null) {
        if ($module_id == null)
            $module_id = $_POST['module'];
        $module = $this->modules->findOrThrowException($module_id);
        $lessons = $module->lessons()->get();

        $total_percentage = [];
        $number_of_lessons = 0;
        foreach ($lessons as $lesson) {
            $number_of_lessons++;
            foreach ($lesson->teachers()->get() as $teacher_percentage) {
                if (isset($total_percentage[$teacher_percentage->id])) {
                    $total_percentage[$teacher_percentage->id] += $teacher_percentage->pivot->percentage;
                } else {
                    $total_percentage[$teacher_percentage->id] = $teacher_percentage->pivot->percentage;
                }
            }
        }

        foreach ($total_percentage as $teacher_id => $percentage) {
            $total_percentage[$teacher_id] = $percentage / $number_of_lessons;
        }

        return $total_percentage;
    }

    public function totalPercentageByCourse($id = 0, $overwrite = null) {
        if ($id == 0)
            $current_course = $this->courses->findOrThrowException($_POST['course']);
        else
            $current_course = $this->courses->findOrThrowException($id);

        if ($current_course->teachers() != null && !$current_course->teachers->isEmpty() && $overwrite === null) {
            $total_percentage = [];
            foreach ($current_course->teachers as $teacher) {
                $total_percentage[$teacher->id] = $teacher->percentage;
            }
            return $total_percentage;
        }


        $total_percentage = [];
        $number_of_modules = 0;

        
         
        foreach ($current_course->modules()->get() as $module) {
            $number_of_modules++;
            foreach ($this->totalPercentageByModule($module->id) as $teacher_id => $percentage) {
                if (isset($total_percentage[$teacher_id])) {
                    $total_percentage[$teacher_id] += $percentage;
                } else {
                    $total_percentage[$teacher_id] = $percentage;
                }
            }
        }

        foreach ($total_percentage as $teacher_id => $percentage) {
            $total_percentage[$teacher_id] = $percentage / $number_of_modules;
        }



        return $total_percentage;
    }

    public function setTeacherPercentageByCourse($course_id = null, $teacher_id = null, $percentage = null) {
        if ($course_id === null) {
            $course_id = $_POST['course'];
            $teacher_id = $_POST['teacher'];
            $percentage = $_POST['percentage'];
        }


        $courseTeacher = $this->courseTeacher->findByCourseAndTeacher($course_id, $teacher_id);

        if ($courseTeacher == null) {
            $this->courseTeacher->create($teacher_id, $course_id, $percentage);
        } else {
            $this->courseTeacher->update($courseTeacher->id, $percentage);
        }
    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit($id) {
        $course = $this->courses->findOrThrowException($id, true);
        $subsections = $this->subsections->getSubsectionsSelect();
        return view('backend.courses.edit')->withCourse($course)->withSubsections($subsections);
    }

    public function selectCourse() {


        $courses = $this->courses->selectCourses($_POST['term']);

        $list = [];

        foreach ($courses as $course) {
            $list[] = ['id' => $course->id, 'text' => $course->title];
        }

        return json_encode($list);
    }

    /**
     * @param $id
     * @param UpdateCourseRequest $request
     * @return mixed
     */
    public function update($id, UpdateCourseRequest $request) {
        $course = $this->courses->update($id, $request->all());

        if ($request->hasFile('featured_img')) {
            $upload_result = $this->uploadService->editImg($request->file('featured_img'), "featured_img_course", $course->id, 'courses', $course->featured_img_sizes);
            if (!isset($upload_result['error']))
                $this->courses->updateImg($course->id, $upload_result['filename']);
        }

        if ($request->hasFile('classroom_img')) {
            $upload_result = $this->uploadService->editImg($request->file('classroom_img'), "classroom_img", $course->id, 'courses', $course->featured_img_sizes);
            if (!isset($upload_result['error']))
                $this->courses->updateClassroomImg($course->id, $upload_result['filename']);
        }

        return redirect()->route('admin.courses.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.courses.updated"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id) {
        $this->courses->destroy($id);
        return redirect()->back()->withFlashSuccess(trans("alerts.courses.deleted"));
    }

    public function createLessonGroup() {
        $lesson = $this->lessons->findOrThrowException($_POST['lesson']);

        if ($lesson->groups->isEmpty())
            $group = $this->groups->createForLesson($lesson->id);
        else
            $group = $lesson->groups->first();


        $sources = $this->sources->getAllSources();


        return view('backend.courses.questions')->withGroup($group)->withLesson($lesson)->withSources($sources)->render();
    }

    public function saveLessonGroup() {
        $params = array();

        parse_str($_POST['fields'], $params);

        $this->groups->createSubjectRelations($params);
    }

    public function createCourseGroup() {
        $course = $this->courses->findOrThrowException($_POST['course']);

        if ($course->groups->isEmpty())
            $group = $this->groups->createForCourse($course->id);
        else
            $group = $course->groups->first();



        //return view('backend.courses.course-questions')->withGroup($group)->withCourse($course)->render();
        return $group->id;
    }

    public function saveCourseGroup() {
        $params = array();

        parse_str($_POST['fields'], $params);
        if (!isset($params['course-group-id']) && isset($_POST['course-group-id']))
            $params['course-group-id'] = $_POST['course-group-id'];

        $this->groups->createCourseSubjectRelations($params);
    }

    public function cloneCourse($id) {
        dd($this->courses->cloneCourse($id));
    }

}
