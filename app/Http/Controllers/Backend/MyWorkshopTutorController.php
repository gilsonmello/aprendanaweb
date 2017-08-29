<?PHP namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\MyWorkshopTutor\CreateMyWorkshopTutorRequest;
use App\Http\Requests\Backend\MyWorkshopTutor\UpdateMyWorkshopTutorRequest;
use App\Repositories\Backend\MyWorkshopTutor\MyWorkshopTutorContract;
use App\Services\UploadService\UploadService;
use Illuminate\Http\Request;

/**
 * Class DashboardController
 * @package App\Http\Controllers\Backend
 */
class MyWorkshopTutorController extends Controller {

    /**
     * @param MyWorkshopTutorContract $myworkshoptutors
     */
    public function __construct(MyWorkshopTutorContract $myworkshoptutors, UploadService $uploadService) {
        $this->myworkshoptutors = $myworkshoptutors;
        $this->uploadService = $uploadService;
    }

    /**
     * Função para retornar todos os tutores
     * 
     * @return json mixed
     *
     */
    public function selectTutor(){
        $users = $this->myworkshoptutors->getAllTutors($_POST['term']);
        $list = [];
        foreach ($users as $user) {
            $list[] = ['id' => $user->id, 'text' => $user->name];
        }
        return json_encode($list);
    }

    /**
     * Função para retornar critério do workshop selecionado
     * 
     * @return json mixed
     *
     */
    public function selectCriteria(){
        $criterias = $this->myworkshoptutors->getAllCriterias($_POST);
        $list = [];
        foreach ($criterias as $criteria) {
            $list[] = ['id' => $criteria->id, 'text' => $criteria->description];
        }
        return die(json_encode($list));
    }


    /**
     * Função para retornar atividades do workshop selecionado
     *
     * @return json mixed
     *
     */
    public function selectActivity(){
        $activities = $this->myworkshoptutors->getAllActivities($_POST);
        $list = [];
        foreach ($activities as $activity) {
            $list[] = ['id' => $activity->id, 'text' => $activity->description];
        }
        return die(json_encode($list));
    }

    /**
     * @return mixed
     */
    public function tutorsTheStudents(Request $request) {
        
        $request->session()->put('lastpage', $request->only('page')['page']);

        $f_submit = $request->input('f_submit', '');

        $f_MyWorkshopTutorController_name = get_parameter_or_session( $request, 'f_MyWorkshopTutorController_name', '', $f_submit, '' );
        
        $f_MyWorkshopTutorController_has_tutor = get_parameter_or_session( $request, 'f_MyWorkshopTutorController_has_tutor', '', $f_submit, '1' );

        $f_MyWorkshopTutorController_workshop = get_parameter_or_session( $request, 'f_MyWorkshopTutorController_workshop', '', $f_submit, '' );
        
        $result = $this->myworkshoptutors->getMyWorkshopTutorsPaginated(config('access.users.default_per_page'), 'id', 'asc', $f_MyWorkshopTutorController_name, $f_MyWorkshopTutorController_has_tutor, $f_MyWorkshopTutorController_workshop);
    
        return view('backend.myworkshoptutors.tutorsthestudents')
            ->withMyworkshoptutors($result)
            ->withMyworkshoptutorcontrollername($f_MyWorkshopTutorController_name)
            ->withHastutor($f_MyWorkshopTutorController_has_tutor)
            ->withMyworkshoptutorcontrollerworkshop($f_MyWorkshopTutorController_workshop)
            ->withCriterias($this->myworkshoptutors->getAllCriterias())
            ->withActivities($this->myworkshoptutors->getAllActivities())
            ->withTutors($this->myworkshoptutors->getAllTutors())
            ->withActivities($this->myworkshoptutors->getAllActivities())
            ->withWorkshops($this->myworkshoptutors->getAllWorkshops());
    }

    /**
     * @return mixed
     */
    public function index(Request $request) {
        $request->session()->put('lastpage', $request->only('page')['page']);

        $f_submit = $request->input('f_submit', '');

        $f_MyWorkshopTutorController_name = get_parameter_or_session( $request, 'f_MyWorkshopTutorController_name', '', $f_submit, '' );

        return view('backend.myworkshoptutors.index')
            ->withMyWorkshopTutors($this->myworkshoptutors->getMyWorkshopTutorsPaginated(config('access.users.default_per_page'), 'name', 'asc', $f_MyWorkshopTutorController_name))
            ->withMyWorkshoptutorcontrollername($f_MyWorkshopTutorController_name);
    }

    /**
     * @return mixed
     */
    public function create() {
        return view('backend.myworkshoptutors.create');
    }

    /**
     * @param CreateMyWorkshopTutorRequest $request
     * @return mixed
     */
    public function store(CreateMyWorkshopTutorRequest $request) {

        $myworkshoptutor = $this->myworkshoptutors->create($request);

        /*if($request->hasFile('addimg')) {
            $upload_result = $this->uploadService->addImg($request->file('addimg'), $myworkshoptutor->name, $myworkshoptutor->id, 'myworkshoptutors');
            if(!isset($upload_result['error'])) $this->myworkshoptutors->updateImg($myworkshoptutor->id, $upload_result['filename']);
        }

        return redirect()->route('admin.myworkshoptutors.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.myworkshoptutors.created"));*/

        return die(json_encode($myworkshoptutor));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit($id) {
        $myworkshoptutor = $this->myworkshoptutors->findOrThrowException($id, true);


        $photooriginal = imageurl("myworkshoptutors/", $id, $myworkshoptutor->addimg);
        $photoresize = imageurl("myworkshoptutors/", $id, $myworkshoptutor->addimg, 100);

        return view('backend.myworkshoptutors.edit')->withMyworkshoptutor($myworkshoptutor)
            ->withphotooriginal($photooriginal)
            ->withphotoresize($photoresize)
            ->withTutors($this->myworkshoptutors->getAllTutors());
    }

    /**
     * @param $id
     * @param UpdateMyWorkshopTutorRequest $request
     * @return mixed
     */
    public function update($id, UpdateMyWorkshopTutorRequest $request) {

        $myworkshoptutor = $this->myworkshoptutors->update($id, $request->except(['addimg']));

        if($request->hasFile('addimg')) {
            $upload_result = $this->uploadService->editImg($request->file('addimg'), $myworkshoptutor->name, $myworkshoptutor->id, 'myworkshoptutors', $myworkshoptutor->img_sizes);
            if(!isset($upload_result['error'])) $this->myworkshoptutors->updateImg($myworkshoptutor->id, $upload_result['filename']);
        }

        return redirect()->route('admin.myworkshoptutors.tutorsthestudents', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.myworkshoptutors.updated"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id) {
        $this->myworkshoptutors->destroy($id);
        return redirect()->back()->withFlashSuccess(trans("alerts.myworkshoptutors.deleted"));
    }

}