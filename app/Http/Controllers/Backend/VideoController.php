<?PHP namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Video\CreateVideoRequest;
use App\Http\Requests\Backend\Video\UpdateVideoRequest;
use App\Repositories\Backend\Video\VideoContract;
use App\Repositories\Backend\User\UserContract;
use App\Services\UploadService\UploadService;
use Illuminate\Http\Request;

/**
 * Class DashboardController
 * @package App\Http\Controllers\Backend
 */
class VideoController extends Controller {

    /**
     * @param VideoContract $videos
     */
    public function __construct(VideoContract $videos, UserContract $users, UploadService $uploadService) {
        $this->videos = $videos;
        $this->users = $users;
        $this->uploadService = $uploadService;
    }

    /**
     * @return mixed
     */
    public function index(Request $request) {
        $request->session()->put('lastpage', $request->only('page')['page']);

        $f_submit = $request->input('f_submit', '');

        $f_VideoController_title = get_parameter_or_session( $request, 'f_VideoController_title', '', $f_submit, '' );

        return view('backend.videos.index')
            ->withVideos($this->videos->getVideosPaginated(config('access.users.default_per_page'), 'id', 'asc', $f_VideoController_title))
            ->withVideocontrollertitle($f_VideoController_title);
    }

    /**
     * @return mixed
     */
    public function create() {
        return view('backend.videos.create')->withTeachers($this->users->getOnlyTeachers());
    }

    /**
     * @param CreateVideoRequest $request
     * @return mixed
     */
    public function store(CreateVideoRequest $request) {
        $video = $this->videos->create($request);

        if($request->hasFile('img')) {
            $upload_result = $this->uploadService->addImg($request->file('img'), $video->title, $video->id, 'videos');
            if(!isset($upload_result['error'])) $this->videos->updateImg($video->id, $upload_result['filename']);
        }

        return redirect()->route('admin.videos.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.videos.created"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit($id) {
        $video = $this->videos->findOrThrowException($id, true);

        $photooriginal = imageurl("videos/", $id, $video->img);
        $photoresize = imageurl("videos/", $id, $video->img, 100);

        return view('backend.videos.edit')
            ->withVideo($video)
            ->withPhotooriginal($photooriginal)
            ->withPhotoresize($photoresize)
            ->withTeachers($this->users->getOnlyTeachers());;
    }

    /**
     * @param $id
     * @param UpdateVideoRequest $request
     * @return mixed
     */
    public function update($id, UpdateVideoRequest $request) {
        $video = $this->videos->update($id, $request->except(['teachers', 'img']), $request->only('teachers'));

        if($request->hasFile('img')) {
            $upload_result = $this->uploadService->editImg($request->file('img'), $video->title, $video->id, 'videos', $video->img_sizes);
            if(!isset($upload_result['error'])) $this->videos->updateImg($video->id, $upload_result['filename']);
        }

        return redirect()->route('admin.videos.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.videos.updated"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id) {
        $this->videos->destroy($id);
        return redirect()->back()->withFlashSuccess(trans("alerts.videos.deleted"));
    }

}