<?PHP namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Package\CreatePackageRequest;
use App\Http\Requests\Backend\Package\UpdatePackageRequest;
use App\Repositories\Backend\Package\PackageContract;
use App\Repositories\Backend\Subsection\SubsectionContract;
use App\Repositories\Backend\Configuration\ConfigurationContract;
use App\Services\UploadService\UploadService;
use Illuminate\Http\Request;

/**
 * Class DashboardController
 * @package App\Http\Controllers\Backend
 */
class PackageController extends Controller {

    /**
     * @param PackageContract $packages
     */
    public function __construct(PackageContract $packages, UploadService $uploadService,
                                SubsectionContract $subsections, ConfigurationContract $configurations) {
        $this->packages = $packages;
        $this->uploadService = $uploadService;
        $this->subsections = $subsections;
        $this->configurations = $configurations;
    }

    /**
     * @return mixed
     */
    public function index(Request $request) {

        $request->session()->put('lastpage', $request->only('page')['page']);

        $f_submit = $request->input('f_submit', '');

        $f_PackageController_title = get_parameter_or_session( $request, 'f_PackageController_title', '', $f_submit, '' );

        return view('backend.packages.index')
            ->withPackages($this->packages->getPackagesPaginated(config('access.users.default_per_page'), 'title', 'asc', $f_PackageController_title))
            ->withPackagecontrollertitle($f_PackageController_title);
    }

    /**
     * @return mixed
     */
    public function create() {
        $subsections = $this->subsections->getSubsectionsSelect();

        $configuration = $this->configurations->findOrThrowException(1, true); //added code 1, as must only exists one row in configuration table

        return view('backend.packages.create')->withSubsections($subsections)->withConfiguration($configuration);
    }

    /**
     * @param CreatePackageRequest $request
     * @return mixed
     */
    public function store(CreatePackageRequest $request) {
        $package = $this->packages->create($request);

        if($request->hasFile('featured_img')) {
            $upload_result = $this->uploadService->addImg($request->file('featured_img'), $package->title, $package->id, 'packages');
            if(!isset($upload_result['error'])) $this->packages->updateImg($package->id, $upload_result['filename']);
        }

        return redirect()->route('admin.packages.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.packages.created"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit($id) {
        $package = $this->packages->findOrThrowException($id, true);

        $subsections = $this->subsections->getSubsectionsSelect();

        $photooriginal = imageurl("packages/", $id, $package->addimg);
        $photoresize = imageurl("packages/", $id, $package->addimg, 100);

        return view('backend.packages.edit')->withPackage($package)
            ->withPhotooriginal($photooriginal)
            ->withPhotoresize($photoresize)
            ->withSubsections($subsections);
    }

    /**
     * @param $id
     * @param UpdatePackageRequest $request
     * @return mixed
     */
    public function update($id, UpdatePackageRequest $request) {

        $package = $this->packages->update($id, $request->except(['featured_img']));

        if($request->hasFile('featured_img')) {
            $upload_result = $this->uploadService->editImg($request->file('featured_img'), $package->title, $package->id, 'packages', $package->img_sizes);
            if(!isset($upload_result['error'])) $this->packages->updateImg($package->id, $upload_result['filename']);
        }

        return redirect()->route('admin.packages.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.packages.updated"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id) {
        $this->packages->destroy($id);
        return redirect()->back()->withFlashSuccess(trans("alerts.packages.deleted"));
    }

}