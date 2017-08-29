<?PHP

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Access\User\CreateUserRepresentativeRequest;
use App\Http\Requests\Backend\Access\User\UpdateUserRepresentativeRequest;
use App\Http\Requests\Backend\Access\User\UpdateUserPasswordRequest;
use App\Repositories\Backend\Coupon\CouponContract;
use App\Repositories\Backend\Order\OrderContract;
use App\Repositories\Backend\User\UserRepresentativeContract;
use App\Repositories\Backend\City\CityContract;
use App\Repositories\Backend\State\StateContract;
use App\Repositories\Backend\Enrollment\EnrollmentContract;
use App\Repositories\Backend\View\ViewContract;
use App\City;
use App\State;
use Carbon\Carbon;
use Illuminate\Http\Request;

/**
 * Class DashboardController
 * @package App\Http\Controllers\Backend
 */
class UserRepresentativeController extends Controller {

    /**
     * @param UserRepresentativeContract $newsletters
     */
    public function __construct(UserRepresentativeContract $userrepresentatives, CityContract $cities, StateContract $states,
                                CouponContract $coupons) {
        $this->userrepresentatives = $userrepresentatives;
        $this->cities = $cities;
        $this->states = $states;
        $this->coupons = $coupons;
    }

    /**
     * @return mixed
     */
    public function index(Request $request) {
        $request->session()->put('lastpage', $request->only('page')['page']);

        $f_UserRepresentativeController_name = $request->input('f_UserRepresentativeController_name', '');
        $f_submit = $request->input('f_submit', '');
        if (($f_submit != '1') && ($f_UserRepresentativeController_name === ''))
            $f_UserRepresentativeController_name = $request->session()->get('f_UserRepresentativeController_name', '');
        $request->session()->put('f_UserRepresentativeController_name', $f_UserRepresentativeController_name);

        return view('backend.userrepresentatives.index')
                        ->withUserrepresentatives($this->userrepresentatives->getUserRepresentativesPaginated(config('access.users.default_per_page'), $f_UserRepresentativeController_name))
                        ->withUserrepresentativecontrollername($f_UserRepresentativeController_name);
    }

    public function listUserRepresentative() {
        return view('backend.userrepresentatives.list')
                        ->withUserrepresentatives($this->userrepresentatives->getAllUserRepresentatives());
    }

    /**
     * @return mixed
     */
    public function create() {
        return view('backend.userrepresentatives.create');
    }

    /**
     * @param CreateUserRepresentativeRequest $request
     * @return mixed
     */
    public function store(CreateUserRepresentativeRequest $request) {
        $this->userrepresentatives->create($request);
        return redirect()->route('admin.userrepresentatives.index')->withFlashSuccess(trans("alerts.userrepresentatives.created"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit($id) {
        $userrepresentative = $this->userrepresentatives->findOrThrowException($id, true);
        $city = City::withTrashed()->find($userrepresentative->city_id);
        $state = new State();
        if ($city != null) {
            $state = State::withTrashed()->find($city->state_id);
        } else {
            $city = new City();
        }
        return view('backend.userrepresentatives.edit')
                        ->withUserrepresentative($userrepresentative)
                        ->withCity($city)
                        ->withState($state);
    }

    public function selectStudent() {

        $userrepresentatives = $this->userrepresentatives->selectStudents($_POST['term']);

        $list = [];

        foreach ($userrepresentatives as $student) {
            $list[] = ['id' => $student->id, 'text' => $student->name];
        }

        return json_encode($list);
    }

    /**
     * @param $id
     * @param UpdateUserRepresentativeRequest $request
     * @return mixed
     */
    public function update($id, UpdateUserRepresentativeRequest $request) {
        $this->userrepresentatives->update($id, $request->all());
        return redirect()->route('admin.userrepresentatives.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.userrepresentative.updated"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id) {
        $this->userrepresentatives->destroy($id);
        return redirect()->back()->withFlashSuccess(trans("alerts.userrepresentative.deleted"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function changePassword($id) {
        return view('backend.userrepresentatives.change-password')
                        ->withUserrepresentative($this->userrepresentatives->findOrThrowException($id));
    }

    /**
     * @param $id
     * @param UpdateUserPasswordRequest $request
     * @return mixed
     */
    public function updatePassword($id, UpdateUserPasswordRequest $request) {
        $this->userrepresentatives->updatePassword($id, $request->all());
        return redirect()->route('admin.userrepresentatives.index')->withFlashSuccess(trans("alerts.users.updated_password"));
    }


    public function coupons(Request $request, $id){
        $coupons = $this->coupons->getCouponsRepresentative( $id);

        return view('backend.userrepresentatives.coupons')
            ->withCoupons($coupons)
            ->withUserrepresentative($this->userrepresentatives->findOrThrowException($id));
    }

    public function addCoupon(Request $request, $id){
        $userrepresentative = $this->userrepresentatives->findOrThrowException($id);

        $coupon = $this->coupons->createCouponsRepresentative( $userrepresentative );

        $coupons = $this->coupons->getCouponsRepresentative( $id);

        return view('backend.userrepresentatives.coupons')
            ->withCoupons($coupons)
            ->withUserrepresentative($userrepresentative);
    }

}
