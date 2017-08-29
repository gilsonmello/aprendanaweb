<?PHP namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Faq\CreateFaqRequest;
use App\Http\Requests\Backend\Faq\UpdateFaqRequest;
use App\Repositories\Backend\Faq\FaqContract;
use App\Repositories\Backend\FaqCategory\FaqCategoryContract;
use Illuminate\Http\Request;

/**
 * Class DashboardController
 * @package App\Http\Controllers\Backend
 */
class FaqController extends Controller {

    /**
     * @param FaqContract $faqs
     */
    public function __construct(FaqContract $faqs,FaqCategoryContract $faqcategorys) {
        $this->faqs = $faqs;
        $this->faqcategorys = $faqcategorys;
    }

    /**
     * @return mixed
     */
    public function index(Request $request) {
        $request->session()->put('lastpage', $request->only('page')['page']);

        return view('backend.faqs.index')
            ->withFaqs($this->faqs->getFaqsPaginated(config('access.users.default_per_page')));
    }

    /**
     * @return mixed
     */
    public function create() {
        return view('backend.faqs.create')->withFaqcategorys($this->faqcategorys->getAllFaqCategory());
    }

    /**
     * @param CreateFaqRequest $request
     * @return mixed
     */
    public function store(CreateFaqRequest $request) {
        $this->faqs->create($request);
        return redirect()->route('admin.faqs.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.faqs.created"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit($id) {
        $faq = $this->faqs->findOrThrowException($id, true);
        return view('backend.faqs.edit')->withFaq($faq)->withFaqcategorys($this->faqcategorys->getAllFaqCategory());
    }

    /**
     * @param $id
     * @param UpdateFaqRequest $request
     * @return mixed
     */
    public function update($id, UpdateFaqRequest $request) {
        $this->faqs->update($id, $request->all());
        return redirect()->route('admin.faqs.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.faqs.updated"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id) {
        $this->faqs->destroy($id);
        return redirect()->back()->withFlashSuccess(trans("alerts.faqs.deleted"));
    }

}