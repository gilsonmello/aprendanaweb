<?PHP namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\MyWorkshopEvaluation\CreateMyWorkshopEvaluationRequest;
use App\Http\Requests\Backend\MyWorkshopEvaluation\UpdateMyWorkshopEvaluationRequest;
use App\Repositories\Backend\MyWorkshopEvaluation\MyWorkshopEvaluationContract;
use App\Repositories\Backend\Workshop\WorkshopContract;
use App\Services\UploadService\UploadService;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

/**
 * Class DashboardController
 * @package App\Http\Controllers\Backend
 */
class MyWorkshopEvaluationController extends Controller {

    /**
     * @param MyWorkshopEvaluationContract $myworkshopevaluations
     */
    public function __construct(MyWorkshopEvaluationContract $myworkshopevaluations, UploadService $uploadService, WorkshopContract $workshops) {
        $this->myworkshopevaluations = $myworkshopevaluations;
        $this->uploadService = $uploadService;
        $this->workshops = $workshops;
    }

    /**
     * Função para retornar todos os tutores
     * 
     * @return json mixed
     *
     */
    public function selectTutor(){
        $users = $this->myworkshopevaluations->getAllTutors($_POST['term']);
        $list = [];
        foreach ($users as $user) {
            $list[] = ['id' => $user->id, 'text' => $user->name];
        }
        return json_encode($list);
    }

    /**
     * @return mixed
     */
    public function index(Request $request) {


        $request->session()->put('lastpage', $request->only('page')['page']);

        $f_submit = $request->input('f_submit', '');

        $f_evaluation_deadline_begin = get_parameter_or_session( 
            $request, 
            'f_MyWorkshopEvaluationController_date_begin', 
            '', 
            $f_submit, 
            '' 
        );

        $f_evaluation_deadline_end = get_parameter_or_session($request, 
            'f_MyWorkshopEvaluationController_date_end', 
            '', 
            $f_submit, 
            '' 
        );

        $f_MyWorkshopEvaluationController_evaluated = get_parameter_or_session( 
            $request, 
            'f_MyWorkshopEvaluationController_evaluated', 
            '', 
            $f_submit, 
            '0' 
        );

        $f_evaluation_workshop_id = get_parameter_or_session(
            $request, 
            'f_MyWorkshopEvaluationController_workshop_id', 
            $f_submit, 
            $f_submit, 
            ''
        );
        
        $f_evaluation_student_name = get_parameter_or_session(
            $request, 
            'f_MyWorkshopEvaluationController_student_name', 
            '', 
            $f_submit, 
            ''
        );

        $f_MyWorkshopEvaluationController_question = get_parameter_or_session(
            $request, 
            'f_MyWorkshopEvaluationController_question', 
            '', 
            $f_submit, 
            ''
        );

        $f_MyWorkshopEvaluationController_order_by = get_parameter_or_session(
            $request, 
            'f_MyWorkshopEvaluationController_order_by', 
            '', 
            $f_submit, 
            '0'
        );

        $f_MyWorkshopEvaluationController_export_to_csv = get_parameter_or_session(
            $request, 
            'f_MyWorkshopEvaluationController_export_to_csv', 
            '', 
            $f_submit, 
            '0'
        );


        if($f_MyWorkshopEvaluationController_export_to_csv == '1'){
            $results = $this->myworkshopevaluations->getMyWorkshopEvaluationsPaginated(
                NULL, 
                $f_evaluation_deadline_begin, $f_evaluation_deadline_end, 
                $f_MyWorkshopEvaluationController_evaluated, 
                $f_evaluation_workshop_id, 
                $f_evaluation_student_name, 
                $f_MyWorkshopEvaluationController_question, 
                $f_MyWorkshopEvaluationController_order_by, 
                $f_MyWorkshopEvaluationController_export_to_csv, 
                'asc');
            $this->evaluations_to_csv_download($results);
        }else{

            $workshops = $this->workshops->getAllWorkshops();

            return view('backend.myworkshopevaluations.index')
                ->withMyworkshopevaluations($this->myworkshopevaluations->getMyWorkshopEvaluationsPaginated(
                    config('access.users.default_per_page'), $f_evaluation_deadline_begin, $f_evaluation_deadline_end, $f_MyWorkshopEvaluationController_evaluated, $f_evaluation_workshop_id, $f_evaluation_student_name, $f_MyWorkshopEvaluationController_question, $f_MyWorkshopEvaluationController_order_by, $f_MyWorkshopEvaluationController_export_to_csv, 'asc')
                )
                ->withEvaluationdeadlinebegin( $f_evaluation_deadline_begin )
                ->withEvaluationdeadlineend( $f_evaluation_deadline_end )
                ->withEvaluationevaluated( $f_MyWorkshopEvaluationController_evaluated )
                ->withEvaluationworkshopid( $f_evaluation_workshop_id )
                ->withEvaluationstudentname( $f_evaluation_student_name )
                ->withEvaluationactivity( $f_MyWorkshopEvaluationController_question )
                ->withMyworkshopevaluationorderby( $f_MyWorkshopEvaluationController_order_by )
                ->withMyworkshopevaluationworkshops( $workshops )
                ->withTutors($this->myworkshopevaluations->getAllTutors());
        }
    }

    /**
     * @return mixed
     */
    public function create() {
        //return view('backend.myworkshopevaluations.create');
    }

    /**
     * @param CreateMyWorkshopEvaluationRequest $request
     * @return mixed
     */
    public function store(CreateMyWorkshopEvaluationRequest $request) {
//        $f_workshop_edit = get_parameter_or_session( $request, 'f_workshop_id', '', '', '' );
//
//        $myworkshopevaluation = $this->myworkshopevaluations->create($request, $f_workshop_edit);
//
//        if($request->hasFile('url_evaluation')) {
//            $upload_result = $this->uploadService->addImg($request->file('url_evaluation'), $myworkshopevaluation->description, $myworkshopevaluation->id, 'myworkshopevaluationdocument');
//            if(!isset($upload_result['error'])) $this->myworkshopevaluations->updateUrlEvaluation($myworkshopevaluation->id, '/uploads/myworkshopevaluationdocument/' . $myworkshopevaluation->id . '/' . $upload_result['filename']);
//        }
//
//        return redirect()->route('admin.myworkshopevaluations.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.myworkshopevaluations.created"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit($id) {
        $myworkshopevaluation = $this->myworkshopevaluations->findOrThrowException($id);

//        if (Carbon::today()->gt( parsebr($myworkshopevaluation->date_deadline) ) && $myworkshopevaluation->grade <> null) return redirect()->back();

        return view('backend.myworkshopevaluations.edit')->withMyworkshopevaluation($myworkshopevaluation);
    }

    /**
     * @param $id
     * @param UpdateMyWorkshopEvaluationRequest $request
     * @return mixed
     */
    public function update($id, UpdateMyWorkshopEvaluationRequest $request) {

        $myworkshopevaluation = $this->myworkshopevaluations->update($id, $request->except(['url_evaluation']));

        if ($myworkshopevaluation == null){
            return redirect()->route('admin.myworkshopevaluations.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashDanger(trans("alerts.myworkshopevaluations.not_updated"));
        }

        if($request->hasFile('url_evaluation')) {
            $upload_result = $this->uploadService->addImg($request->file('url_evaluation'),  $myworkshopevaluation->myActivity->enrollment->student->name . '_' . $myworkshopevaluation->myActivity->workshop->description . '_' . $myworkshopevaluation->myActivity->activity->description, $myworkshopevaluation->id, 'myworkshopevaluationdocument');
            if(!isset($upload_result['error'])) $this->myworkshopevaluations->updateUrlEvaluation($myworkshopevaluation->id, '/uploads/myworkshopevaluationdocument/' . $myworkshopevaluation->id . '/' . $upload_result['filename']);
        }

        return redirect()->route('admin.myworkshopevaluations.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.myworkshopevaluations.updated"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id) {
        $this->myworkshopevaluations->destroy($id);
        return redirect()->back()->withFlashSuccess(trans("alerts.myworkshopevaluations.deleted"));
    }

    /**
     * @param $id
     * @param UpdateMyWorkshopEvaluationRequest $request
     * @return mixed
     */
    public function updateTutor($id, UpdateMyWorkshopEvaluationRequest $request) {
        $myworkshopevaluation = $this->myworkshopevaluations->updateTutor($id, $request->except(['addimg']));
        if($myworkshopevaluation == true){
            return die(json_encode($myworkshopevaluation));
        }
        return die(json_encode(false));
    }
	
	public function activitiesReport(Request $request){
		
        $request->session()->put('lastpage', $request->only('page')['page']);

        $f_submit = $request->input('f_submit', '');

        $f_evaluation_report_type = get_parameter_or_session( 
            $request, 
            'f_MyWorkshopEvaluationController_type_report', 
            '', 
            $f_submit, 
            '0' 
        );

        //dd($this->myworkshopevaluations->getActivitiesReport($f_evaluation_report_type));
        return view('backend.myworkshopevaluations.activitiesreport')
        ->withEvaluationreporttype($f_evaluation_report_type)
        ->withMyworkshopevaluations($this->myworkshopevaluations->getActivitiesReport($f_evaluation_report_type));
	}

    private function evaluations_to_csv_download($data, $delimiter=",") {
        //dd($data->first());
        // open raw memory as file so no temp files needed, you might run out of memory though
        $f = fopen('php://output', 'w');
        $filename = "relatorio_de_atividades" . time()  . ".csv";
        fputs($f, $bom =( chr(0xEF) . chr(0xBB) . chr(0xBF) ));
        header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename="'.$filename.'";');

        fputcsv(
            $f,
            [
                trans('strings.student'),
                trans('strings.tutor'),
                trans('strings.activity'),
                trans('strings.criteria'),
                trans('strings.deadline'),
                trans('strings.evaluation'),
                trans('strings.grade')
            ],
            ','
        );
        foreach($data as $result){
            $line = [
                (isset($result->myActivity->enrollment->student->name))  ? $result->myActivity->enrollment->student->name : "",
                (isset($result->tutor->name)) ? $result->tutor->name : "",
                (isset($result->myActivity->activity->workshop->description)) ? $result->myActivity->activity->workshop->description.' - '. $result->myActivity->activity->description : "",
                /*(isset($result->birthdate)) ? implode('/', array_reverse(explode('-', $result->birthdate))) : "",*/
                (!empty($result->criteria->description )) ? $result->criteria->description  : "",
                (isset($result->date_deadline)) ? implode('/', array_reverse(explode('-', $result->date_deadline))) : "",
                (isset($result->date_evaluation)) ? implode('/', array_reverse(explode('-', $result->date_evaluation))) : "",
                (isset($result->grade)) ? str_replace('.', ',', $result->grade) : ""
            ];
            fputcsv($f, $line, $delimiter);
        }
        fpassthru($f);
    }

}