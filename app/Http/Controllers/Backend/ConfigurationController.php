<?PHP namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Configuration\UpdateConfigurationRequest;
use App\Repositories\Backend\Configuration\ConfigurationContract;
use App\Repositories\Backend\User\UserContract;
use Illuminate\Http\Request;

/**
 * Class DashboardController
 * @package App\Http\Controllers\Backend
 */
class ConfigurationController extends Controller {

    /**
     * @param ConfigurationContract $configurations
     */
    public function __construct(ConfigurationContract $configurations, UserContract $users) {
        $this->configurations = $configurations;
        $this->users = $users;
    }

    /**
     * @return mixed
     */
    public function index(Request $request) {
//        $request->session()->put('lastpage', $request->only('page')['page'] );
//
//        return view('backend.configurations.index')
//            ->withConfigurations($this->configurations->getConfigurationsPaginated(config('access.users.default_per_page')));
    }

    public function listConfiguration() {
//        return view('backend.configurations.list')
//            ->withConfigurations($this->configurations->getAllConfigurations( ))
//            ->withUsers($this->users->getUsersConfigurations( ));
    }

    /**
     * @return mixed
     */
    public function create() {
        return view('backend.configurations.create');
    }

    /**
     * @param CreateConfigurationRequest $request
     * @return mixed
     */
    public function store(CreateConfigurationRequest $request) {
        $this->configurations->create($request);
        return redirect()->route('admin.configurations.index')->withFlashSuccess(trans("alerts.configurations.created"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit($id) {
        $configuration = $this->configurations->findOrThrowException(1, true); //added code 1, as must only exists one row in configuration table
        return view('backend.configurations.edit')->withConfiguration($configuration);
    }

    /**
     * @param $id
     * @param UpdateConfigurationRequest $request
     * @return mixed
     */
    public function update($id, UpdateConfigurationRequest $request) {
        $this->configurations->update($request->all());
        $configuration = $this->configurations->findOrThrowException(1, true);
        return redirect()->route('admin.configurations.edit')->withFlashSuccess(trans("alerts.configurations.updated"))->withConfiguration($configuration);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id) {
        $this->configurations->destroy($id);
        return redirect()->back()->withFlashSuccess(trans("alerts.configurations.deleted"));
    }

}