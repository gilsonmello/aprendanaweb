<?PHP

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Repositories\Frontend\Course\CourseContract;
use App\Repositories\Frontend\Video\VideoContract;
use App\Repositories\Frontend\CourseTeacher\CourseTeacherContract;
use Illuminate\Support\Collection;

/**
 * Class DashboardControllerapp/Http/Controllers/Backend/VideoController.php:7
 * @package App\Http\Controllers\Backend
 */
class VideoController extends Controller {

    /**
     * @param VideoContract $videos
     */
    public function __construct(VideoContract $videos, CourseTeacherContract $courseteachers, CourseContract $courses) {
        $this->videos = $videos;
        $this->courseteachers = $courseteachers;
        $this->courses = $courses;
    }

    /**
     * @return mixed
     */
    public function index() {
        return view('frontend.videos.index')
                        ->withVideos($this->videos->getVideosPaginated(12));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id) {
        $video = $this->videos->findOrThrowException($id, true);
        $video->hits = $video->hits + 1;
        $video->save();
        $video->url_frag = parse_video($video->url);
        $coursesrelated = null;

        if (count($video->users) > 0) {
            $coursesrelated = $this->courseteachers->getAllCourseTeachersPerTeacher($video->users[0]->id);
            $collection = new Collection($coursesrelated);

            // Sort descending by stars.
            $collection = $collection->sortByDesc(function($item) {

                $item->course->section = getSectionData($item->course->subsection_id);

                if (count($item->course->section) == 0) {
                    $item->course->section = getSubsectionData($item->course->subsection_id);
                }

                return $item->course->orders_count;
            });
        } else {

            $tags = $video->tags;
            if ($tags != null && $tags != '') {
                $tags = explode(";", $tags);
            }

            $coursesrelated = new Collection();
            $i = 0;
            if ($tags != '') {
                foreach ($tags as $tag) {
                    $coursesrelated = $coursesrelated->merge($this->courses->getBySearch($tag)->diff($coursesrelated));
                    $coursesrelated[$i]->section = getSectionData($coursesrelated[$i]->subsection_id);

                    if (count($coursesrelated[$i]->section) == 0) {
                        $coursesrelated[$i]->section = getSubsectionData($coursesrelated[$i]->subsection_id);
                    }
                    $i++;
                }
            }

            $collection = $coursesrelated;
        }

        $more_videos = null;
        if (count($video->users) > 0) {
            $more_videos = $video->users->first()->videos->reject(function ($item) use ($video) {
                        return ($item->id == $video->id) || ($item->status == 0);
                    })->slice(0, 3);
        }


        return view('frontend.videos.show')
                        ->withVideo($video)
                        ->withMoreCourses($collection->slice(0, 2))
                        ->withMoreVideos($more_videos);
    }

}
