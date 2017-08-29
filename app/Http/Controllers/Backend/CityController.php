<?PHP namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\City\CreateCityRequest;
use App\Http\Requests\Backend\City\UpdateCityRequest;
use App\Repositories\Backend\City\CityContract;
use App\Repositories\Backend\State\StateContract;
use App\State;
use Illuminate\Http\Request;

/**
 * Class DashboardController
 * @package App\Http\Controllers\Backend
 */
class CityController extends Controller {

    /**
     * @param CityContract $cities
     */
    public function __construct(CityContract $cities, StateContract $states) {
        $this->cities = $cities;
        $this->states = $states;
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function index(Request $request) {
        $request->session()->put('lastpage', $request->only('page')['page'] );

        $f_CityController_name = $request->input('f_CityController_name', '');
        $f_submit = $request->input('f_submit', '');
        if (($f_submit != '1') && ($f_CityController_name === ''))
            $f_CityController_name = $request->session()->get('f_CityController_name', '');
        $request->session()->put('f_CityController_name', $f_CityController_name );

        return view('backend.cities.index')
            ->withCities($this->cities->getCitiesPaginated(config('access.users.default_per_page'), $f_CityController_name))
            ->withCitycontrollername($f_CityController_name);
    }


    /**
     * @return mixed
     */
    public function listCity() {
        return view('backend.cities.list')
            ->withCities($this->cities->getAllCities( ));
    }

    /**
     * @return string
     */
    public function selectCity() {
        return json_encode(  array('results' => $this->cities->selectCities( $_GET['term'] )));
    }


    /**
     * @return mixed
     */
    public function create() {
        $astates = State::orderBy('name', 'asc')->lists('name', 'id');
        return view('backend.cities.create')->withStates( $astates );
    }

    /**
     * @param CreateCityRequest $request
     * @return mixed
     */
    public function store(CreateCityRequest $request) {
        $this->cities->create($request);
        return redirect()->route('admin.cities.index')->withFlashSuccess(trans("alerts.cities.created"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit($id) {
        $city = $this->cities->findOrThrowException($id, true);
        return view('backend.cities.edit')->withCity($city);
    }

    /**
     * @param $id
     * @param UpdateCityRequest $request
     * @return mixed
     */
    public function update($id, UpdateCityRequest $request) {
        $this->cities->update($id, $request);
        return redirect()->route('admin.cities.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.cities.updated"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id) {
        $this->cities->destroy($id);
        return redirect()->back()->withFlashSuccess(trans("alerts.cities.deleted"));
    }

}