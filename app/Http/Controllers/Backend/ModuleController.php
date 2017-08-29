<?PHP namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Module\CreateModuleRequest;
use App\Http\Requests\Backend\Module\UpdateModuleRequest;
use App\Repositories\Backend\Module\ModuleContract;
use App\Repositories\Backend\Subsection\SubsectionContract;
use App\Services\UploadService\UploadService;

/**
 * Class DashboardController
 * @package App\Http\Controllers\Backend
 */
class ModuleController extends Controller {

    /**
     * @param ModuleContract $modules
     * @param SubsectionContract $subsections
     * @param UploadService $uploadService
     */
    public function __construct(ModuleContract $modules, SubsectionContract $subsections, UploadService $uploadService) {
        $this->modules = $modules;
        $this->subsections = $subsections;
        $this->uploadService = $uploadService;
    }

    /**
     * @return mixed
     */
    public function index() {
        return view('backend.modules.index')
            ->withModules($this->modules->getModulesPaginated(config('access.users.default_per_page')));
    }

    /**
     * @return mixed
     */
    public function create() {
        $subsections = $this->subsections->getSubsectionsSelect();
        return view('backend.modules.create')->withSubsections($subsections);
    }

    /**
     * @param CreateModuleRequest $request
     * @return mixed
     */
    public function store(CreateModuleRequest $request) {

        $module = $this->modules->create($request);

        if($request->hasFile('featured_img')) {
            $upload_result = $this->uploadService->addImg($request->file('featured_img'), $module->name, $module->id, 'modules');
            if(!isset($upload_result['error'])) $this->modules->updateImg($module->id, $upload_result['filename']);
        }
        
        return redirect()->route('admin.modules.index')->withFlashSuccess(trans("alerts.modules.created"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit($id) {
        $module = $this->modules->findOrThrowException($id, true);
        $subsections = $this->subsections->getSubsectionsSelect();
        return view('backend.modules.edit')->withModule($module)->withSubsections($subsections);
    }

    /**
     * @param $id
     * @param UpdateModuleRequest $request
     * @return mixed
     */


    public function selectModule() {


        $modules = $this->modules->selectModules( $_POST['term'] );

        $list = [];

        foreach ($modules as $module) {
            $list[] = ['id' => $module->id, 'text' => $module->name];
        }

        return json_encode($list);
    }


    public function update($id, UpdateModuleRequest $request) {
        $module = $this->modules->update($id, $request->all());

        if($request->hasFile('featured_img')) {
            $upload_result = $this->uploadService->editImg($request->file('featured_img'), $module->title, $module->id, 'modules', $module->featured_img_sizes);
            if(!isset($upload_result['error'])) $this->modules->updateImg($module->id, $upload_result['filename']);
        }
        
        return redirect()->route('admin.modules.index')->withFlashSuccess(trans("alerts.modules.updated"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id) {
        $this->modules->destroy($id);
        return redirect()->back()->withFlashSuccess(trans("alerts.modules.deleted"));
    }

}