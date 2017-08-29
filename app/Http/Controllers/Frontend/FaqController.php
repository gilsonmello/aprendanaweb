<?PHP namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Repositories\Backend\FaqCategory\FaqCategoryContract;

/**
 * Class DashboardControllerapp/Http/Controllers/Backend/FaqController.php:7
 * @package App\Http\Controllers\Backend
 */
class FaqController extends Controller {

    /**
     * @param FaqContract $faqs
     */
    public function __construct(FaqCategoryContract $faqcategories) {
        $this->faqcategories = $faqcategories;
    }

    /**
     * @return mixed
     */
    public function index()
    {

        $faqcategories = config('faqcategories');
        if ($faqcategories == null) {
            $faqcategories = $this->faqcategories->getFaqCategoryForHome();
            config(['faqcategories' => $faqcategories]);
        }
        
        return view('frontend.faqs.index')
            ->withFaqcategories( $faqcategories );
    }



}