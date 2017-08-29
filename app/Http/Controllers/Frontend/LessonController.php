<?PHP namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Repositories\Frontend\Lesson\LessonContract;

/**
 * Class DashboardControllerapp
 * @package App\Http\Controllers\Backend
 */
class LessonController extends Controller {

    /**
     * @param CourseContract $courses
     */
    public function __construct(LessonContract $lessons) {
        $this->lessons = $lessons;
    }

    /**
     * @return mixed
     */

    public function show($id) {
        $lesson = $this->lessons->findOrThrowException($id, true);
        $lesson->video_frag = parse_video($lesson->video_ad_url);

        return view('frontend.lessons.show')
            ->withLesson($lesson);
    }

}