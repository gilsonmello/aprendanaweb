<?PHP namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\MyWorkshopActivity\CreateMyWorkshopActivityRequest;
use App\Http\Requests\Backend\MyWorkshopActivity\UpdateMyWorkshopActivityRequest;
use App\Repositories\Backend\MyWorkshopActivity\MyWorkshopActivityContract;
use App\Services\UploadService\UploadService;
use Illuminate\Http\Request;

/**
 * Class DashboardController
 * @package App\Http\Controllers\Backend
 */
class MyWorkshopActivityController extends Controller {

    /**
     * @param MyWorkshopActivityContract $myworkshopactivitys
     */
    public function __construct(MyWorkshopActivityContract $myworkshopactivitys, UploadService $uploadService) {
        $this->myworkshopactivitys = $myworkshopactivitys;
        $this->uploadService = $uploadService;
    }

    /**
     * @return mixed
     */
    public function index(Request $request) {
        $request->session()->put('lastpage', $request->only('page')['page']);

        $f_submit = $request->input('f_submit', '');

        $f_MyWorkshopActivityController_name = get_parameter_or_session( $request, 'f_MyWorkshopActivityController_name', '', $f_submit, '' );

        return view('backend.myworkshopactivitys.index')
            ->withMyWorkshopActivitys(
                $this->myworkshopactivitys->getMyWorkshopActivitysPaginated(
                    config('access.users.default_per_page'),
                    'name',
                    'asc',
                    $f_MyWorkshopActivityController_name
                )
            )
            ->withMyWorkshopActivitycontrollername($f_MyWorkshopActivityController_name);
    }

    /**
     * @return mixed
     */
    public function create() {
        return view('backend.myworkshopactivitys.create');
    }

    /**
     * @param CreateMyWorkshopActivityRequest $request
     * @return mixed
     */
    public function store(CreateMyWorkshopActivityRequest $request) {
        $myworkshopactivity = $this->myworkshopactivitys->create($request);

        if($request->hasFile('addimg')) {
            $upload_result = $this->uploadService->addImg($request->file('addimg'), $myworkshopactivity->name, $myworkshopactivity->id, 'myworkshopactivitys');
            if(!isset($upload_result['error'])) $this->myworkshopactivitys->updateImg($myworkshopactivity->id, $upload_result['filename']);
        }

        return redirect()->route('admin.myworkshopactivitys.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.myworkshopactivitys.created"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit($id) {
        $myworkshopactivity = $this->myworkshopactivitys->findOrThrowException($id, true);

        $photooriginal = imageurl("myworkshopactivitys/", $id, $myworkshopactivity->addimg);
        $photoresize = imageurl("myworkshopactivitys/", $id, $myworkshopactivity->addimg, 100);

        return view('backend.myworkshopactivitys.edit')->withMyWorkshopActivity($myworkshopactivity)
            ->withPhotooriginal($photooriginal)
            ->withPhotoresize($photoresize);
    }

    /**
     * @param $id
     * @param UpdateMyWorkshopActivityRequest $request
     * @return mixed
     */
    public function update($id, UpdateMyWorkshopActivityRequest $request) {

        $myworkshopactivity = $this->myworkshopactivitys->update($id, $request->except(['addimg']));

        if($request->hasFile('addimg')) {
            $upload_result = $this->uploadService->editImg($request->file('addimg'), $myworkshopactivity->name, $myworkshopactivity->id, 'myworkshopactivitys', $myworkshopactivity->img_sizes);
            if(!isset($upload_result['error'])) $this->myworkshopactivitys->updateImg($myworkshopactivity->id, $upload_result['filename']);
        }

        return redirect()->route('admin.myworkshopactivitys.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.myworkshopactivitys.updated"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id) {
        $this->myworkshopactivitys->destroy($id);
        return redirect()->back()->withFlashSuccess(trans("alerts.myworkshopactivitys.deleted"));
    }

}