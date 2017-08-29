<?PHP namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\WorkshopActivity\CreateWorkshopActivityRequest;
use App\Http\Requests\Backend\WorkshopActivity\UpdateWorkshopActivityRequest;
use App\Repositories\Backend\WorkshopActivity\WorkshopActivityContract;
use App\Repositories\Backend\Workshop\WorkshopContract;
use App\Services\UploadService\UploadService;
use Illuminate\Http\Request;

/**
 * Class DashboardController
 * @package App\Http\Controllers\Backend
 */
class WorkshopActivityController extends Controller {

    /**
     * @param WorkshopActivityContract $workshopactivitys
     */
    public function __construct(WorkshopActivityContract $workshopactivitys, UploadService $uploadService, WorkshopContract $workshops) {
        $this->workshopactivitys = $workshopactivitys;
        $this->uploadService = $uploadService;
        $this->workshops = $workshops;
    }

    /**
     * @return mixed
     */
    public function index(Request $request) {
        $request->session()->put('lastpage', $request->only('page')['page']);

        $f_submit = $request->input('f_submit', '');

        $f_workshop_edit = get_parameter_or_session( $request, 'f_workshop_id', '', '', '' );

        return view('backend.workshopactivitys.index')
            ->withWorkshopactivitys($this->workshopactivitys->getWorkshopActivitysPaginated(config('access.users.default_per_page'), 'description', 'asc', $f_workshop_edit))
            ->withWorkshop($f_workshop_edit);
    }

    /**
     * @return mixed
     */
    public function create() {
        return view('backend.workshopactivitys.create');
    }

    /**
     * @param CreateWorkshopActivityRequest $request
     * @return mixed
     */
    public function store(CreateWorkshopActivityRequest $request) {
        
        
      
        
        $f_workshop_edit = get_parameter_or_session( $request, 'f_workshop_id', '', '', '' );

        $workshopactivity = $this->workshopactivitys->create($request, $f_workshop_edit);

        if($request->hasFile('url_document')) {
            $upload_result = $this->uploadService->addImg($request->file('url_document'), $workshopactivity->description, $workshopactivity->id, 'workshopactivitydocument');
            if(!isset($upload_result['error'])) $this->workshopactivitys->updateUrlDocument($workshopactivity->id, '/uploads/workshopactivitydocument/' . $workshopactivity->id . '/' . $upload_result['filename']);
        }

        if($request->hasFile('url_response')) {
            $upload_result = $this->uploadService->addImg($request->file('url_response'), $workshopactivity->description, $workshopactivity->id, 'workshopactivityresponse');
            if(!isset($upload_result['error'])) $this->workshopactivitys->updateUrlResponse($workshopactivity->id, '/uploads/workshopactivityresponse/' . $workshopactivity->id . '/' . $upload_result['filename']);
        }

        return redirect()->route('admin.workshopactivitys.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.workshopactivitys.created"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit($id) {
        $workshopactivity = $this->workshopactivitys->findOrThrowException($id, true);

        return view('backend.workshopactivitys.edit')->withWorkshopactivity($workshopactivity);
    }

    /**
     * @param $id
     * @param UpdateWorkshopActivityRequest $request
     * @return mixed
     */
    public function update($id, UpdateWorkshopActivityRequest $request) {

  
         
        $workshopactivity = $this->workshopactivitys->update($id, $request->except(['url_document', 'url_response']));

        if($request->hasFile('url_document')) {
            $upload_result = $this->uploadService->addImg($request->file('url_document'), $workshopactivity->description, $workshopactivity->id, 'workshopactivitydocument');
            if(!isset($upload_result['error'])) $this->workshopactivitys->updateUrlDocument($workshopactivity->id, '/uploads/workshopactivitydocument/' . $workshopactivity->id . '/' .$upload_result['filename']);
        }

        if($request->hasFile('url_response')) {
            $upload_result = $this->uploadService->addImg($request->file('url_response'), $workshopactivity->description, $workshopactivity->id, 'workshopactivityresponse');
            if(!isset($upload_result['error'])) $this->workshopactivitys->updateUrlResponse($workshopactivity->id, '/uploads/workshopactivityresponse/' . $workshopactivity->id . '/' .$upload_result['filename']);
        }

        return redirect()->route('admin.workshopactivitys.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.workshopactivitys.updated"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id) {
        $this->workshopactivitys->destroy($id);
        return redirect()->back()->withFlashSuccess(trans("alerts.workshopactivitys.deleted"));
    }

    public function activitiesReport(Request $request){

        $request->session()->put('lastpage', $request->only('page')['page']);

        $f_submit = $request->input('f_submit', '');

        $f_workshop_activity_report_type = get_parameter_or_session(
            $request,
            'f_Workshop_activities_type_report',
            '',
            $f_submit,
            '0'
        );

        $f_workshop_activities_group_report = get_parameter_or_session(
            $request,
            'f_workshop_activities_group_report',
            '',
            $f_submit,
            'A'
        );

        $f_workshop_activities_workshop_id = get_parameter_or_session(
            $request,
            'f_workshop_activities_workshop_id',
            '',
            $f_submit,
            ''
        );

        //dd();
        //dd($this->myworkshopevaluations->getActivitiesReport($f_evaluation_report_type));
        $view = NULL;
        if($f_workshop_activities_group_report == 'S'){
            $view = 'backend.workshopactivitys.studentsreport';
        }else if($f_workshop_activities_group_report == 'A'){
            $view = 'backend.workshopactivitys.activitiesreport';
        }
        return view($view)
            ->withWorkshopactivityreporttype($f_workshop_activity_report_type)
            ->withWorkshopactivityreportgroup($f_workshop_activities_group_report)
            ->withWorkshopactivityworkshopid($f_workshop_activities_workshop_id)
            ->withWorkshopactivityresults(
                $this->workshopactivitys->getActivityReport(
                        $f_workshop_activities_group_report,
                        $f_workshop_activities_workshop_id
                    )
                )
            ->withWorkshops($this->workshops->getAllWorkshops());
    }
}