<?PHP

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Repositories\Frontend\Module\ModuleContract;

/**
 * Class DashboardControllerapp
 * @package App\Http\Controllers\Backend
 */
class ModuleController extends Controller {

    /**
     * @param CourseContract $courses
     */
    public function __construct(ModuleContract $modules) {
        $this->modules = $modules;
    }



    /**
     * @return mixed
     *

      /**
     * @param $id
     * @return mixed
     */
    public function show($id) {
        $module = $this->modules->findOrThrowException($id, true);
        $module->ad_url = parse_video($module->video_ad_url);

        return view('frontend.modules.show')
                        ->withModule($module);
    }

}
