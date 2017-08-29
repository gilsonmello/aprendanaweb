<?PHP

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Repositories\Backend\PackageTeacher\PackageTeacherContract;
use Illuminate\Http\Request;
use App\Repositories\Backend\Source\SourceContract;
use App\Repositories\Backend\Subject\SubjectContract;
use App\Repositories\Backend\Institution\InstitutionContract;
use App\Repositories\Backend\Office\OfficeContract;
use App\User;

/**
 * Class DashboardController
 * @package App\Http\Controllers\Backend
 */
class PackageTeacherController extends Controller {

    /**
     * @param TeacherContract $teachers
     */
    public function __construct(PackageTeacherContract $packageteachers) {
        $this->packageteachers = $packageteachers;
    }

    /**
     * @return mixed
     */
    public function index(Request $request) {
        $request->session()->put('lastpage', $request->only('page')['page']);

        $f_package_edit = get_parameter_or_session($request, 'f_package_id', '', '1', '');
 
        return view('backend.packages.packageteacher-index')
                        ->withPackageteachers($this->packageteachers->getAllPackageTeachersPerPackage($f_package_edit, 'id', 'asc'));
    }

    /**
     * @return mixed
     */
    public function create(Request $request) {
        
    }

    /**
     * @param CreateTeacherRequest $request
     * @return mixed
     */
    public function store(Request $request) {
        
    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit($id) {
        
    }

    /**
     * @param $id
     * @param UpdateTeacherRequest $request
     * @return mixed
     */
    public function update($id, Request $request) {
        
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id) {
        $this->packageteachers->destroy($id);
        return redirect()->back()->withFlashSuccess(trans("alerts.teachers.deleted"));
    }

    public function addIndex(Request $request) {
        return view('backend.packages.teacher-add')
                        ->withTeachers(User::teachers()->orderBy('name', 'asc'));
    }

    public function add(Request $request) {
        $f_package_edit = get_parameter_or_session($request, 'f_package_id', '', '', '');

        $this->packageteachers->add($request['teachers'][0], $f_package_edit, $request['percentage']);

        return redirect()->route('admin.packageteachers.index', ['f_package_id' => $f_package_edit, 'page' => $request->session()->get('lastpage', '1')])
                        ->withFlashSuccess(trans("alerts.packageteachers.addsuccess"));
    }

}
