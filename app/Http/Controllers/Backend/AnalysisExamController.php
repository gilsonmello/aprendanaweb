<?PHP namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\AnalysisExam\CreateAnalysisExamRequest;
use App\Http\Requests\Backend\AnalysisExam\UpdateAnalysisExamRequest;
use App\Repositories\Backend\AnalysisExam\AnalysisExamContract;
use App\Repositories\Backend\AnalysisExamExamGroup\AnalysisExamExamGroupContract;
use App\Repositories\Backend\Institution\InstitutionContract;
use App\Repositories\Backend\Office\OfficeContract;
use App\Repositories\Backend\Source\SourceContract;
use App\Repositories\Backend\Subject\SubjectContract;
use App\Services\UploadService\UploadService;
use Illuminate\Http\Request;

/**
 * Class DashboardController
 * @package App\Http\Controllers\Backend
 */
class AnalysisExamController extends Controller {

    /**
     * @param AnalysisExamContract $analysisexams
     */
    public function __construct(AnalysisExamContract $analysisexams, UploadService $uploadService, OfficeContract $offices, InstitutionContract $institutions, SourceContract $sources) {
        $this->analysisexams = $analysisexams;
        $this->uploadService = $uploadService;
        $this->offices = $offices;
        $this->institutions = $institutions;
        $this->sources = $sources;
    }

    /**
     * @return mixed
     */
    public function index(Request $request) {
        $request->session()->put('lastpage', $request->only('page')['page']);

        $f_submit = $request->input('f_submit', '');

        $f_AnalysisExamController_title = get_parameter_or_session( $request, 'f_AnalysisExamController_title', '', $f_submit, '' );

        return view('backend.analysisexams.index')
            ->withAnalysisexams($this->analysisexams->getAnalysisExamsPaginated(config('access.users.default_per_page'), 'title', 'asc', $f_AnalysisExamController_title))
            ->withAnalysisexamcontrollertitle($f_AnalysisExamController_title);
    }

    /**
     * @return mixed
     */
    public function create() {
        return view('backend.analysisexams.create')
            ->withOffices( $this->offices->getAllOffices('name', 'asc'))
            ->withInstitutions( $this->institutions->getAllInstitutions('name', 'asc'))
            ->withSources( $this->sources->getAllSources('name', 'asc'))  ;
    }

    /**
     * @param CreateAnalysisExamRequest $request
     * @return mixed
     */
    public function store(CreateAnalysisExamRequest $request) {
        $analysisexam = $this->analysisexams->create($request);

        return redirect()->route('admin.analysisexams.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.analysisexams.created"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit($id) {
        $analysisexam = $this->analysisexams->findOrThrowException($id, true);

        return view('backend.analysisexams.edit')->withAnalysisexam($analysisexam)
            ->withOffices( $this->offices->getAllOffices('name', 'asc'))
            ->withInstitutions( $this->institutions->getAllInstitutions('name', 'asc'))
            ->withSources( $this->sources->getAllSources('name', 'asc'))  ;
    }

    /**
     * @param $id
     * @param UpdateAnalysisExamRequest $request
     * @return mixed
     */
    public function update($id, UpdateAnalysisExamRequest $request) {

        $analysisexam = $this->analysisexams->update($id, $request->except(['addimg']));

        return redirect()->route('admin.analysisexams.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.analysisexams.updated"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id) {
        $this->analysisexams->destroy($id);
        return redirect()->back()->withFlashSuccess(trans("alerts.analysisexams.deleted"));
    }

}