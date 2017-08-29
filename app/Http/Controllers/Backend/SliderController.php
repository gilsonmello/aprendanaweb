<?PHP namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Slider\CreateSliderRequest;
use App\Http\Requests\Backend\Slider\UpdateSliderRequest;
use App\Repositories\Backend\Slider\SliderContract;
use App\Repositories\Backend\User\UserContract;
use App\Services\UploadService\UploadService;
use Illuminate\Http\Request;


/**
 * Class DashboardControllerapp/Http/Controllers/Backend/SliderController.php:7
 * @package App\Http\Controllers\Backend
 */
class SliderController extends Controller {

    /**
     * @param SliderContract $sliders
     * @param UserContract $users
     * @param UploadService $uploadService
     */
    public function __construct(SliderContract $sliders, UploadService $uploadService) {
        $this->sliders = $sliders;
        $this->uploadService = $uploadService;
    }

    /**
     * @return mixed
     */
    public function index(Request $request) {
        $request->session()->put('lastpage', $request->only('page')['page']);

        return view('backend.sliders.index')
            ->withSliders($this->sliders->getSlidersPaginated(config('access.users.default_per_page'), 'id', 'desc'));
    }

    /**
     * @return mixed
     */
    public function create() {
        return view('backend.sliders.create');
    }

    /**
     * @param CreateSliderRequest $request
     * @return mixed
     */
    public function store(CreateSliderRequest $request) {
        $slider = $this->sliders->create($request);

        if($request->hasFile('img')) {
            $upload_result = $this->uploadService->addImg($request->file('img'), $slider->name, $slider->id, 'sliders');
            if(!isset($upload_result['error'])) $this->sliders->updateImg($slider->id, $upload_result['filename']);
        }

        return redirect()->route('admin.sliders.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.sliders.created"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit($id) {
        $slider = $this->sliders->findOrThrowException($id, true);
        return view('backend.sliders.edit')->withSlider($slider);
    }

    /**
     * @param $id
     * @param UpdateSliderRequest $request
     * @return mixed
     */
    public function update($id, UpdateSliderRequest $request) {
        $slider = $this->sliders->update($id, $request->all());

        if($request->hasFile('img')) {
            $upload_result = $this->uploadService->editImg($request->file('img'), $slider->name, $slider->id, 'sliders', $slider->img_sizes);
            if(!isset($upload_result['error'])) $this->sliders->updateImg($slider->id, $upload_result['filename']);
        }

        return redirect()->route('admin.sliders.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.sliders.updated"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id) {
        $this->sliders->destroy($id);
        return redirect()->back()->withFlashSuccess(trans("alerts.sliders.deleted"));
    }

}