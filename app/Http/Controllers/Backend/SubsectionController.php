<?PHP namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Subsection\CreateSubsectionRequest;
use App\Http\Requests\Backend\Subsection\UpdateSubsectionRequest;
use App\Repositories\Backend\Section\SectionContract;
use App\Repositories\Backend\Subsection\SubsectionContract;
use Illuminate\Http\Request;

/**
 * Class DashboardController
 * @package App\Http\Controllers\Backend
 */
class SubsectionController extends Controller {

    /**
     * @param SubsectionContract $subsections
     */
    public function __construct(SubsectionContract $subsections, SectionContract $sections) {
        $this->subsections = $subsections;
        $this->sections = $sections;
    }

    /**
     * @return mixed
     */
    public function index(Request $request) {
        $request->session()->put('lastpage', $request->only('page')['page']);

        return view('backend.subsections.index')
            ->withSubsections($this->subsections->getSubsectionsPaginated(config('access.users.default_per_page')));
    }

    /**
     * @return mixed
     */
    public function create() {
        return view('backend.subsections.create')->withSections($this->sections->getAllSections());
    }

    /**
     * @param CreateSubsectionRequest $request
     * @return mixed
     */
    public function store(CreateSubsectionRequest $request) {
        $this->subsections->create($request);
        return redirect()->route('admin.subsections.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.subsections.created"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit($id) {
        $subsection = $this->subsections->findOrThrowException($id, true);
        return view('backend.subsections.edit')->withSubsection($subsection)->withSections($this->sections->getAllSections());
    }

    /**
     * @param $id
     * @param UpdateSubsectionRequest $request
     * @return mixed
     */
    public function update($id, UpdateSubsectionRequest $request) {
        $this->subsections->update($id, $request->all());


        return redirect()->route('admin.subsections.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.subsections.updated"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id) {
        $this->subsections->destroy($id);
        return redirect()->back()->withFlashSuccess(trans("alerts.subsections.deleted"));
    }

}