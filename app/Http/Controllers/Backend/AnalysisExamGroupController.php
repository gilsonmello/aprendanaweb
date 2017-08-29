<?PHP namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\AnalysisExamGroup\CreateAnalysisExamGroupRequest;
use App\Http\Requests\Backend\AnalysisExamGroup\UpdateAnalysisExamGroupRequest;
use App\Repositories\Backend\AnalysisExamGroup\AnalysisExamGroupContract;
use App\Services\UploadService\UploadService;
use Illuminate\Http\Request;

/**
 * Class DashboardController
 * @package App\Http\Controllers\Backend
 */
class AnalysisExamGroupController extends Controller {

    /**
     * @param AnalysisExamGroupContract $analysisexamgroups
     */
    public function __construct(AnalysisExamGroupContract $analysisexamgroups, UploadService $uploadService) {
        $this->analysisexamgroups = $analysisexamgroups;
        $this->uploadService = $uploadService;
    }

    /**
     * @return mixed
     */
    public function index(Request $request) {
        $request->session()->put('lastpage', $request->only('page')['page']);

        $f_submit = $request->input('f_submit', '');

        $f_AnalysisExamGroupController_title = get_parameter_or_session( $request, 'f_AnalysisExamGroupController_title', '', $f_submit, '' );

        return view('backend.analysisexamgroups.index')
            ->withAnalysisexamgroups($this->analysisexamgroups->getAnalysisExamGroupsPaginated(config('access.users.default_per_page'), 'title', 'asc', $f_AnalysisExamGroupController_title))
            ->withAnalysisexamgroupcontrollertitle($f_AnalysisExamGroupController_title);
    }

    /**
     * @return mixed
     */
    public function create() {
        return view('backend.analysisexamgroups.create');
    }

    /**
     * @param CreateAnalysisExamGroupRequest $request
     * @return mixed
     */
    public function store(CreateAnalysisExamGroupRequest $request) {
        $analysisexamgroup = $this->analysisexamgroups->create($request);

        return redirect()->route('admin.analysisexamgroups.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.analysisexamgroups.created"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit($id) {
        $analysisexamgroup = $this->analysisexamgroups->findOrThrowException($id, true);

        return view('backend.analysisexamgroups.edit')->withAnalysisexamgroup($analysisexamgroup);
    }

    /**
     * @param $id
     * @param UpdateAnalysisExamGroupRequest $request
     * @return mixed
     */
    public function update($id, UpdateAnalysisExamGroupRequest $request) {

        $analysisexamgroup = $this->analysisexamgroups->update($id, $request->except(['addimg']));

        return redirect()->route('admin.analysisexamgroups.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.analysisexamgroups.updated"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id) {
        $this->analysisexamgroups->destroy($id);
        return redirect()->back()->withFlashSuccess(trans("alerts.analysisexamgroups.deleted"));
    }

}