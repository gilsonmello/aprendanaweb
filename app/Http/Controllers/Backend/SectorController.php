<?PHP namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Sector\CreateSectorRequest;
use App\Http\Requests\Backend\Sector\UpdateSectorRequest;
use App\Repositories\Backend\Sector\SectorContract;
use App\Repositories\Backend\User\UserContract;
use Illuminate\Contracts\Filesystem\Filesystem;
use Matriphe\Imageupload\Imageupload;
use Illuminate\Http\Request;

/**
 * Class DashboardControllerapp/Http/Controllers/Backend/SectorController.php:7
 * @package App\Http\Controllers\Backend
 */
class SectorController extends Controller {

    /**
     * @param SectorContract $sectors
     * @param UserContract $users
     * @param Imageupload $upload
     * @param Filesystem $filesystem
     */
    public function __construct(SectorContract $sectors, UserContract $users, Imageupload $upload, Filesystem $filesystem) {
        $this->sectors = $sectors;
        $this->users = $users;
        $this->upload = $upload;
        $this->filesystem = $filesystem;
    }

    /**
     * @return mixed
     */
    public function index(Request $request) {
        $request->session()->put('lastpage', $request->only('page')['page']);

        return view('backend.sectors.index')
            ->withSectors($this->sectors->getSectorsPaginated(config('access.users.default_per_page')));
    }

    /**
     * @return mixed
     */
    public function create() {
        return view('backend.sectors.create')->withAdmins($this->users->getOnlyAdmins());
    }

    /**
     * @param CreateSectorRequest $request
     * @return mixed
     */
    public function store(CreateSectorRequest $request) {
        $id_incremented = $this->sectors->create($request);

        return redirect()->route('admin.sectors.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.sectors.created"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit($id) {
        $sector = $this->sectors->findOrThrowException($id, true);
        return view('backend.sectors.edit')->withSector($sector)->withAdmins($this->users->getOnlyAdmins());
    }

    /**
     * @param $id
     * @param UpdateSectorRequest $request
     * @return mixed
     */
    public function update($id, UpdateSectorRequest $request) {
        $this->sectors->update($id, $request->except(['admins', 'img']), $request->only('admins'));

        return redirect()->route('admin.sectors.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.sectors.updated"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id) {
        $this->sectors->destroy($id);
        return redirect()->back()->withFlashSuccess(trans("alerts.sectors.deleted"));
    }

}