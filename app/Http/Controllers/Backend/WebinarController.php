<?PHP namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Webinar\CreateWebinarRequest;
use App\Http\Requests\Backend\Webinar\UpdateWebinarRequest;
use App\Repositories\Backend\Banner\BannerContract;
use App\Repositories\Backend\Package\PackageContract;
use App\Repositories\Backend\User\UserContract;
use App\Services\UploadService\UploadService;
use App\Repositories\Backend\Course\CourseContract;
use Illuminate\Http\Request;
use App\Repositories\Backend\Webinar\WebinarContract;


/**
 * Class DashboardControllerapp/Http/Controllers/Backend/BannerController.php:7
 * @package App\Http\Controllers\Backend
 */
class WebinarController extends Controller {

    /**
     * @param UploadService $uploadService
     * @param CourseContract $courses
     * @param WebinarContract $webinar
     */
    public function __construct(UploadService $uploadService, CourseContract $courses, WebinarContract $webinar) {
        $this->courses = $courses;
        $this->uploadService = $uploadService;
        $this->webinar = $webinar;
    }

    /**
     * @return mixed
     */
    public function index(Request $request) {
        $request->session()->put('lastpage', $request->only('page')['page']);

        $f_submit = $request->input('f_submit', '');

        $f_WebinarController_title = get_parameter_or_session( $request, 'f_WebinarController_title', '', $f_submit, '' );

        $webinars = $this->webinar->getWebinarsPaginated(config('access.users.default_per_page'), $f_WebinarController_title);

        return view('backend.webinars.index')
            ->withWebinars($webinars)
            ->withWebinarontrollertitle($f_WebinarController_title);
    }

    /**
     * @return mixed
     */
    public function create() {
        $courses = $this->courses->getAllCourses('title', 'asc');
        return view('backend.webinars.create')
            ->withCourses($courses);
    }

    /**
     * @param CreateWebinarRequest $request
     * @return mixed
     */
    public function store(CreateWebinarRequest $request) {
        $webinar = $this->webinar->create($request->all());

        if($webinar) {
            return redirect()->route('admin.webinars.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.webinars.created"));
        }
        return redirect()->route('admin.banners.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashDanger(trans("alerts.webinars.error"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit($id) {
        $webinar = $this->webinar->findOrThrowException($id, true);
        $courses = $this->courses->getAllCourses();

        return view('backend.webinars.edit')
            ->withCourses($courses)
            ->withWebinar($webinar);
    }

    /**
     * @param $id
     * @param UpdateWebinarRequest $request
     * @return mixed
     */
    public function update($id, UpdateWebinarRequest $request) {
        $webinar = $this->webinar->update($id, $request->all());
        if($webinar) {
            return redirect()->route('admin.webinars.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.webinars.updated"));
        }
        return redirect()->route('admin.webinars.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashDanger(trans("alerts.webinars.error"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id) {
        $this->webinar->destroy($id);
        return redirect()->back()->withFlashSuccess(trans("alerts.webinars.deleted"));
    }


    public function usersCourse(Request $request){
        $result = $this->webinar->getAllUsersCourse($request->all());

        if(count($result) > 0){
            die(json_encode($this->webinar->getAllUsersCourse($request->all())));
        }

        die('false');
    }

}