<?PHP

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Question;
use App\Repositories\Frontend\Package\PackageContract;
use App\Repositories\Frontend\Section\SectionContract;
use App\Repositories\Frontend\Module\ModuleContract;
use App\Repositories\Frontend\Course\CourseContract;

/**
 * Class DashboardControllerapp
 * @package App\Http\Controllers\Backend
 */
class PackageController extends Controller {

    /**
     * @param PackageContract $packages
     * @param SectionContract $sections
     */
    public function __construct(PackageContract $packages, SectionContract $sections, ModuleContract $module, CourseContract $courses) {
        $this->packages = $packages;
        $this->sections = $sections;
        $this->module = $module;
        $this->courses = $courses;
    }

    /**
     * @return mixed
     */
    public function index() {
        $packages = $this->packages->getPackagesPaginated(20);
        $tags = [];
        return view('frontend.packages.index')
                        ->withPackages($packages)
                        ->withSections($this->sections->getAllSections())
                        ->withTitle('SAAPs')
                        ->withTags($tags);
    }

    /**
     * @param $slug
     * @return mixed
     */
    public function show($slug) {
        $package = $this->packages->findBySlug($slug);


        if ($package === null) {
            //Caso o package retorne vazio o acesso serÃ¡ redirecionado para a pÃ¡gina principal
            return redirect('/');
        } else {
            $package->video_frag = parse_video($package->video_ad_url);

            //Caso seja o Pacote de 80 Questões ele vai recomendar os cursos
            if (!is_null($package->tags) && $package->id == 56) { //Caso não seja nulo
                $related = $this->courses->getCourseByTags($package->tags, 4);
            } else {
                $related = $this->packages->getRelatedPackages($package);
            }


            //$exam_ids = $package->exams->questions;
            return view('frontend.packages.show')
                            ->withPackage($package)
                            ->withRelated($related);
        }
    }

    public function about() {
        $packages = $this->packages->getAllPackages()->shuffle()->take(6);

        return view('frontend.packages.about')->withPackages($packages);
    }

    public function oabSemParar() {
        return view('frontend.packages.oab-sem-parar');
    }

}
