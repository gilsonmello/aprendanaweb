<?PHP namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Lesson\CreateLessonRequest;
use App\Http\Requests\Backend\Lesson\UpdateLessonRequest;
use App\Repositories\Backend\Lesson\LessonContract;
use App\Repositories\Backend\Subsection\SubsectionContract;
use App\Services\UploadService\UploadService;

/**
 * Class DashboardController
 * @package App\Http\Controllers\Backend
 */
class LessonController extends Controller {

    /**
     * @param LessonContract $lessons
     * @param SubsectionContract $subsections
     * @param UploadService $uploadService
     */
    public function __construct(LessonContract $lessons, SubsectionContract $subsections, UploadService $uploadService) {
        $this->lessons = $lessons;
        $this->subsections = $subsections;
        $this->uploadService = $uploadService;
    }

    /**
     * @return mixed
     */
    public function index() {
        return view('backend.lessons.index')
            ->withLessons($this->lessons->getLessonsPaginated(config('access.users.default_per_page')));
    }

    /**
     * @return mixed
     */
    public function create() {
        $subsections = $this->subsections->getSubsectionsSelect();
        return view('backend.lessons.create')->withSubsections($subsections);
    }

    /**
     * @param CreateLessonRequest $request
     * @return mixed
     */
    public function store(CreateLessonRequest $request) {
        $lesson = $this->lessons->create($request);

        if($request->hasFile('featured_img')) {
            $upload_result = $this->uploadService->addImg($request->file('featured_img'), $lesson->name, $lesson->id, 'lessons');
            if(!isset($upload_result['error'])) $this->lessons->updateImg($lesson->id, $upload_result['filename']);
        }
        
        return redirect()->route('admin.lessons.index')->withFlashSuccess(trans("alerts.lessons.created"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit($id) {
        $lesson = $this->lessons->findOrThrowException($id, true);
        $subsections = $this->subsections->getSubsectionsSelect();
        return view('backend.lessons.edit')->withLesson($lesson)->withSubsections($subsections);
    }

    /**
     * @param $id
     * @param UpdateLessonRequest $request
     * @return mixed
     */
    public function update($id, UpdateLessonRequest $request) {
        $lesson = $this->lessons->update($id, $request->all());

        if($request->hasFile('featured_img')) {
            $upload_result = $this->uploadService->editImg($request->file('featured_img'), $lesson->title, $lesson->id, 'lessons', $lesson->featured_img_sizes);
            if(!isset($upload_result['error'])) $this->lessons->updateImg($lesson->id, $upload_result['filename']);
        }
        
        return redirect()->route('admin.lessons.index')->withFlashSuccess(trans("alerts.lessons.updated"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id) {
        $this->lessons->destroy($id);
        return redirect()->back()->withFlashSuccess(trans("alerts.lessons.deleted"));
    }

    public function selectLesson()
    {
        $lessons = $this->lessons->selectLessons( $_POST['term'],$_POST['other'] );

        $list = [];
        foreach ($lessons as $lesson) {
            $title = $lesson->title == "" ? $lesson->module->name : $lesson->title;
            $list[] = ['id' => $lesson->id, 'text' => $title . ' - Aula ' . $lesson->sequence ];
        }

        return json_encode($list);
    }

}