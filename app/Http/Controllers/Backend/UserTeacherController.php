<?PHP namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Access\User\CreateUserTeacherRequest;
use App\Http\Requests\Backend\Access\User\UpdateUserTeacherRequest;
use App\Http\Requests\Backend\Access\User\UpdateUserPasswordRequest;
use App\Repositories\Backend\User\UserTeacherContract;
use App\Repositories\Backend\City\CityContract;
use App\Repositories\Backend\State\StateContract;
use App\City;
use App\State;
use Illuminate\Http\Request;
use Matriphe\Imageupload\Imageupload;


/**
 * Class DashboardController
 * @package App\Http\Controllers\Backend
 */
class UserTeacherController extends Controller {

    /**
     * @param UserTeacherContract $newsletters
     */
    public function __construct(UserTeacherContract $userteachers, CityContract $cities, StateContract $states, Imageupload $upload) {
        $this->userteachers = $userteachers;
        $this->cities = $cities;
        $this->states = $states;
        $this->upload = $upload;
    }

    /**
     * @return mixed
     */
    public function index(Request $request)
    {
        $request->session()->put('lastpage', $request->only('page')['page']);
        
        $f_submit = $request->input('f_submit', '');

        $f_UserTeacherController_name = get_parameter_or_session($request, 'f_UserTeacherController_name', '', $f_submit, '');

        $f_UserTeacherController_desactived = get_parameter_or_session($request, 'f_UserTeacherController_desactived', '', $f_submit, '');

        $f_UserTeacherController_export = get_parameter_or_session($request, 'f_UserTeacherController_export', '', $f_submit, '');


        


        /* if (($f_submit != '1') && ($f_UserTeacherController_name === ''))
                $f_UserTeacherController_name = $request->session()->get('f_UserTeacherController_name', '');*/
        

        //$request->session()->put('f_UserTeacherController_name', $f_UserTeacherController_name );

        if($f_UserTeacherController_export == '1'){
            //All results
            $results = $this->userteachers->getUserTeachersPaginated(config('access.users.default_per_page'), $f_UserTeacherController_name, $f_UserTeacherController_desactived, false);
            
            $this->teachers_to_csv_download($results);
        }else{        
            return view('backend.userteachers.index')
                ->withUserteachers($this->userteachers->getUserTeachersPaginated(config('access.users.default_per_page'), $f_UserTeacherController_name, $f_UserTeacherController_desactived, true))
                ->withUserteachercontrollername($f_UserTeacherController_name)
                ->withUserteachercontrollerconfirmed($f_UserTeacherController_desactived);
        }
    }

    public function listUserTeacher() {
        return view('backend.userteachers.list')
            ->withUserteachers($this->userteachers->getAllUserTeachers( ));
    }

    /**
     * @return mixed
     */
    public function create() {
        return view('backend.userteachers.create');
    }

    /**
     * @param CreateUserTeacherRequest $request
     * @return mixed
     */
    public function store(CreateUserTeacherRequest $request) {
        $id_incremented = $this->userteachers->create($request);

        if ($request->hasFile('photo')){
            $new_file_name = $request['name'] . '_' . str_random(4);

            $imgResult = $this->upload->upload($request->file('photo'), $new_file_name, '/users/'.$id_incremented);
            if(!isset($imgResult['error'])) $this->userteachers->updatePhoto($id_incremented, $imgResult['filename']);

        }

        return redirect()->route('admin.userteachers.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.userteachers.created"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit($id) {
        $userteacher = $this->userteachers->findOrThrowException($id, true);
        $city = City::withTrashed()->find($userteacher->city_id);
        $state = new State();
        if ($city != null) {
            $state = State::withTrashed()->find($city->state_id);
        } else {
            $city = new City();
        }

        $photooriginal = imageurl("users/", $id, $userteacher->photo);
        $photoresize = imageurl("users/", $id, $userteacher->photo, 50);

        return view('backend.userteachers.edit')
            ->withUserteacher($userteacher)
            ->withCity($city)
            ->withState($state)
            ->withPhotooriginal($photooriginal)
            ->withPhotoresize($photoresize);
    }

    /**
     * @param $id
     * @param UpdateUserTeacherRequest $request
     * @return mixed
     */
    public function update($id, UpdateUserTeacherRequest $request) {
        $this->userteachers->update($id, $request->all());

        if ($request->hasFile('photo')){
            $new_file_name = $request['name'] . '_' . str_random(4);


            $imgResult = $this->upload->upload($request->file('photo'), $new_file_name, '/users/'.$id);
            if(!isset($imgResult['error'])) $this->userteachers->updatePhoto($id, $imgResult['filename']);
        }

        return redirect()->route('admin.userteachers.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.userteachers.updated"));
    }


    public function selectTeachers() {
        $teachers = $this->userteachers->selectTeachers( $_POST['term'] );

        $list = [];
        foreach ($teachers as $teacher) {
            $list[] = ['id' => $teacher->id, 'text' => $teacher->name];
        }

        return json_encode($list);
    }




    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id) {
        $this->userteachers->destroy($id);
        return redirect()->back()->withFlashSuccess(trans("alerts.userteachers.deleted"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function changePassword($id) {
        return view('backend.userteachers.change-password')
            ->withUserteacher($this->userteachers->findOrThrowException($id));
    }

    /**
     * @param $id
     * @param UpdateUserPasswordRequest $request
     * @return mixed
     */
    public function updatePassword($id, UpdateUserPasswordRequest $request) {
        $this->userteachers->updatePassword($id, $request->all());
        return redirect()->route('admin.userteachers.index')->withFlashSuccess(trans("alerts.users.updated_password"));
    }


    private function teachers_to_csv_download($data, $delimiter=",") {
        //dd($data->first());
        // open raw memory as file so no temp files needed, you might run out of memory though
        $f = fopen('php://output', 'w');
        $filename = "teachers_" . time()  . ".csv";
        fputs($f, $bom =( chr(0xEF) . chr(0xBB) . chr(0xBF) ));
        header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename="'.$filename.'";');

        fputcsv(
            $f,
            [
                trans('strings.student'),
                trans('strings.cel'),
                trans('strings.user_email'),
                trans('strings.birthdate'),
                trans('strings.address'),
            ],
            ','
        );
        foreach($data as $result){
            $line = [
                (isset($result->name))  ? $result->name : "",
                (isset($result->cel)) ? $result->cel : "",
                (isset($result->email)) ? $result->email : "",
                (isset($result->birthdate)) ? implode('/', array_reverse(explode('-', $result->birthdate))) : "",
                (!empty($result->address)) ? $result->address : "",

            ];
            fputcsv($f, $line, $delimiter);
        }
        fpassthru($f);
    }

}