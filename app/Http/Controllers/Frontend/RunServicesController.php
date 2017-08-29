<?PHP namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Repositories\Frontend\Article\ArticleContract;
use App\Services\Utils\Crud;
use App\Services\Utils\Trans;
use Illuminate\Support\Collection;

/**
 * Class DashboardControllerapp/Http/Controllers/Backend/ArticleController.php:7
 * @package App\Http\Controllers\Backend
 */
class RunServicesController extends Controller {

    public function __construct() {
    }

    /**
     * @return mixed
     */
    public function crud() {
        //(new Crud())->generateCrud();
    }

    public function trans() {
       //return (new Trans())->pendingTrans();
    }


}