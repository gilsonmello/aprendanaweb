<?PHP namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\FaqCategory\CreateFaqCategoryRequest;
use App\Http\Requests\Backend\FaqCategory\UpdateFaqCategoryRequest;
use App\Repositories\Backend\FaqCategory\FaqCategoryContract;
use Illuminate\Http\Request;

/**
 * Class DashboardController
 * @package App\Http\Controllers\Backend
 */
class FaqCategoryController extends Controller {

    /**
     * @param FaqCategoryContract $faqCategory
     */
    public function __construct(FaqCategoryContract $faqCategory) {
        $this->faqcategory = $faqCategory;
    }

    /**
     * @return mixed
     */
    public function index(Request $request) {
        $request->session()->put('lastpage', $request->only('page')['page']);

        return view('backend.faqcategory.index')
            ->withFaqcategories($this->faqcategory->getFaqCategoryPaginated(config('access.users.default_per_page')));
    }

    /**
     * @return mixed
     */
    public function create() {
        return view('backend.faqcategory.create');
    }

    /**
     * @param CreateFaqCategoryRequest $request
     * @return mixed
     */
    public function store(CreateFaqCategoryRequest $request) {
        $this->faqcategory->create($request);
        return redirect()->route('admin.faqcategory.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.faqcategory.created"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit($id) {
        $faqCategory = $this->faqcategory->findOrThrowException($id, true);
        return view('backend.faqcategory.edit')->withFaqcategory($faqCategory);
    }

    /**
     * @param $id
     * @param UpdateFaqCategoryRequest $request
     * @return mixed
     */
    public function update($id, UpdateFaqcategoryRequest $request) {
        $this->faqcategory->update($id, $request->all());
        return redirect()->route('admin.faqcategory.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.faqcategory.updated"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id) {
        $this->faqcategory->destroy($id);
        return redirect()->back()->withFlashSuccess(trans("alerts.faqcategory.deleted"));
    }

}