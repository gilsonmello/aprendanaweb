<?PHP namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Analysis\CreateAnalysisRequest;
use App\Http\Requests\Backend\Analysis\UpdateAnalysisRequest;
use App\Repositories\Backend\Analysis\AnalysisContract;
use App\Repositories\Backend\AnalysisExamGroup\AnalysisExamGroupContract;
use App\Repositories\Backend\Subject\SubjectContract;
use App\Services\UploadService\UploadService;
use Illuminate\Http\Request;

/**
 * Class DashboardController
 * @package App\Http\Controllers\Backend
 */
class AnalysisController extends Controller {

    /**
     * @param AnalysisContract $analysiss
     */
    public function __construct(AnalysisContract $analysiss, UploadService $uploadService, SubjectContract $subjects, AnalysisExamGroupContract $analysisexemgroup) {
        $this->analysiss = $analysiss;
        $this->uploadService = $uploadService;
        $this->subjects = $subjects;
        $this->analysisexemgroup = $analysisexemgroup;
    }

    /**
     * @return mixed
     */
    public function index(Request $request) {
        $request->session()->put('lastpage', $request->only('page')['page']);

        $f_submit = $request->input('f_submit', '');

        $f_AnalysisController_title = get_parameter_or_session( $request, 'f_AnalysisController_title', '', $f_submit, '' );

        return view('backend.analysiss.index')
            ->withAnalysiss($this->analysiss->getAnalysissPaginated(config('access.users.default_per_page'), 'title', 'asc', $f_AnalysisController_title))
            ->withAnalysiscontrollertitle($f_AnalysisController_title);
    }

    /**
     * @return mixed
     */
    public function create() {
        return view('backend.analysiss.create')
            ->withSubjects($this->subjects->getSubjectsLevel1('name', 'asc'))
            ->withAnalysisexamgroups( $this->analysisexemgroup->getAllAnalysisExamGroups('title', 'asc')) ;
    }

    /**
     * @param CreateAnalysisRequest $request
     * @return mixed
     */
    public function store(CreateAnalysisRequest $request) {
        $analysis = $this->analysiss->create($request);

        return redirect()->route('admin.analysiss.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.analysiss.created"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit($id) {
        $analysis = $this->analysiss->findOrThrowException($id, true);

        $photooriginal = imageurl("analysiss/", $id, $analysis->addimg);
        $photoresize = imageurl("analysiss/", $id, $analysis->addimg, 100);

        return view('backend.analysiss.edit')->withAnalysis($analysis)
            ->withPhotooriginal($photooriginal)
            ->withPhotoresize($photoresize);
    }

    /**
     * @param $id
     * @param UpdateAnalysisRequest $request
     * @return mixed
     */
    public function update($id, UpdateAnalysisRequest $request) {

        $analysis = $this->analysiss->update($id, $request->except(['addimg']));

        return redirect()->route('admin.analysiss.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.analysiss.updated"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id) {
        $this->analysiss->destroy($id);
        return redirect()->back()->withFlashSuccess(trans("alerts.analysiss.deleted"));
    }

}