<?PHP namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Occupation\CreateOccupationRequest;
use App\Http\Requests\Backend\Occupation\UpdateOccupationRequest;
use App\Repositories\Backend\Occupation\OccupationContract;
use App\Services\UploadService\UploadService;
use Illuminate\Http\Request;

/**
 * Class DashboardController
 * @package App\Http\Controllers\Backend
 */
class OccupationController extends Controller {

    /**
     * @param OccupationContract $occupations
     */
    public function __construct(OccupationContract $occupations, UploadService $uploadService) {
        $this->occupations = $occupations;
        $this->uploadService = $uploadService;
    }

    /**
     * @return mixed
     */
    public function index(Request $request) {
        $request->session()->put('lastpage', $request->only('page')['page']);

        $f_submit = $request->input('f_submit', '');

        $f_OccupationController_description = get_parameter_or_session( $request, 'f_OccupationController_description', '', $f_submit, '' );

        return view('backend.occupations.index')
            ->withOccupations($this->occupations->getOccupationsPaginated(config('access.users.default_per_page'), 'description', 'asc', $f_OccupationController_description))
            ->withOccupationcontrollerdescription($f_OccupationController_description);
    }

    /**
     * @return mixed
     */
    public function create() {
        return view('backend.occupations.create');
    }

    /**
     * @param CreateOccupationRequest $request
     * @return mixed
     */
    public function store(CreateOccupationRequest $request) {
        $occupation = $this->occupations->create($request);

        return redirect()->route('admin.occupations.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.occupations.created"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit($id) {
        $occupation = $this->occupations->findOrThrowException($id, true);

        $photooriginal = imageurl("occupations/", $id, $occupation->addimg);
        $photoresize = imageurl("occupations/", $id, $occupation->addimg, 100);

        return view('backend.occupations.edit')->withOccupation($occupation)
            ->withPhotooriginal($photooriginal)
            ->withPhotoresize($photoresize);
    }

    /**
     * @param $id
     * @param UpdateOccupationRequest $request
     * @return mixed
     */
    public function update($id, UpdateOccupationRequest $request) {

        $occupation = $this->occupations->update($id, $request->except(['addimg']));

        return redirect()->route('admin.occupations.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.occupations.updated"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id) {
        $this->occupations->destroy($id);
        return redirect()->back()->withFlashSuccess(trans("alerts.occupations.deleted"));
    }

}