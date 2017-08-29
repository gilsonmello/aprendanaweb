<?PHP namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Banner\CreateBannerRequest;
use App\Http\Requests\Backend\Banner\UpdateBannerRequest;
use App\Repositories\Backend\Banner\BannerContract;
use App\Repositories\Backend\Package\PackageContract;
use App\Repositories\Backend\User\UserContract;
use App\Services\UploadService\UploadService;
use App\Repositories\Backend\Course\CourseContract;
use App\Repositories\Backend\Exam\ExamContract;
use Illuminate\Http\Request;


/**
 * Class DashboardControllerapp/Http/Controllers/Backend/BannerController.php:7
 * @package App\Http\Controllers\Backend
 */
class BannerController extends Controller {

    /**
     * @param BannerContract $banners
     * @param UserContract $users
     * @param UploadService $uploadService
     */
    public function __construct(BannerContract $banners, UploadService $uploadService, CourseContract $courses, PackageContract $exams ) {
        $this->courses = $courses;
        $this->exams = $exams;
        $this->banners = $banners;
        $this->uploadService = $uploadService;
    }

    /**
     * @return mixed
     */
    public function index(Request $request) {
        $request->session()->put('lastpage', $request->only('page')['page']);
        $f_submit = $request->input('f_submit', '');
        $f_carousel = get_parameter_or_session($request, 'carousel', '', $f_submit, '' );
        $f_is_active = get_parameter_or_session($request, 'is_active', '', $f_submit, '' );

        return view('backend.banners.index')
        ->withBanners($this->banners->getBannersPaginated(
                config('access.users.default_per_page'), 
                'order', 
                'asc',
                $f_carousel,
                $f_is_active
            )
        )
        ->withCarousel($f_carousel)
        ->withIsactive($f_is_active);
    }

    /**
     * @return mixed
     */
    public function create() {
        $courses = $this->courses->getAllCourses();
        $exams = $this->exams->getAllPackages();
        return view('backend.banners.create')
            ->withCourses($courses)
            ->withExams($exams);;
    }

    /**
     * @param CreateBannerRequest $request
     * @return mixed
     */
    public function store(CreateBannerRequest $request) {
        $banner = $this->banners->create($request);

        if($request->hasFile('img')) {
            $upload_result = $this->uploadService->addImg($request->file('img'), $banner->name, $banner->id, 'banners');
            if(!isset($upload_result['error'])) $this->banners->updateImg($banner->id, $upload_result['filename']);
        }

        return redirect()->route('admin.banners.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.banners.created"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit($id) {
        $banner = $this->banners->findOrThrowException($id, true);

        $courses = $this->courses->getAllCourses();

        $exams = $this->exams->getAllPackages();



        return view('backend.banners.edit')->withBanner($banner)
            ->withCourses($courses)
            ->withExams($exams);;
    }

    /**
     * @param $id
     * @param UpdateBannerRequest $request
     * @return mixed
     */
    public function update($id, UpdateBannerRequest $request) {
        $banner = $this->banners->update($id, $request->all());
        if($request->hasFile('img')) {
            $upload_result = $this->uploadService->editImg($request->file('img'), $banner->name, $banner->id, 'banners', $banner->img_sizes);
            if(!isset($upload_result['error'])) $this->banners->updateImg($banner->id, $upload_result['filename']);
        }
        return redirect()->route('admin.banners.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.banners.updated"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id) {
        $this->banners->destroy($id);
        return redirect()->back()->withFlashSuccess(trans("alerts.banners.deleted"));
    }

}