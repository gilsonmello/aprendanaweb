<?PHP namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\PartnerorderPayment\CreatePartnerorderPaymentRequest;
use App\Http\Requests\Backend\PartnerorderPayment\UpdatePartnerorderPaymentRequest;
use App\Repositories\Backend\Exam\ExamContract;
use App\Repositories\Backend\PartnerorderPayment\PartnerorderPaymentContract;
use Illuminate\Http\Request;

/**
 * Class DashboardController
 * @package App\Http\Controllers\Backend
 */
class PartnerorderPaymentController extends Controller {

    /**
     * @param ExamContract $partnerorders
     */
    public function __construct(PartnerorderPaymentContract $partnerorderPayments) {
        $this->partnerorderPayments = $partnerorderPayments;
    }


    /**
     * @return mixed
     */
    public function index(Request $request) {
        $request->session()->put('lastpage', $request->only('page')['page']);

        $f_submit = $request->input('f_submit', '');

        $f_partnerorder_edit = get_parameter_or_session( $request, 'f_partnerorder_id', '', $f_submit, '' );

        return view('backend.partnerorders.partnerorderpayment-index')
            ->withPartnerorder( $f_partnerorder_edit )
            ->withPartnerorderpayments($this->partnerorderPayments->getPartnerorderPaymentsPaginated(config('access.users.default_per_page'), 'id', 'asc', $f_partnerorder_edit));
    }

    /**
     * @return mixed
     */
    public function create(Request $request) {
        return view('backend.partnerorders.partnerorderpayment-create');
    }

    /**
     * @param CreateExamRequest $request
     * @return mixed
     */
    public function store(CreatePartnerorderPaymentRequest $request) {
        $f_partnerorder_edit = get_parameter_or_session( $request, 'f_partnerorder_id', '', '', '' );

        $partnerorderPayment = $this->partnerorderPayments->create($request, $f_partnerorder_edit );

        return redirect()->route('admin.partnerorderpayments.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.partnerorders.partnerorderpayment.created"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit($id) {
        $partnerorderPayment = $this->partnerorderPayments->findOrThrowException($id, true);

        return view('backend.partnerorders.partnerorderpayment-edit')->withPartnerorderpayment($partnerorderPayment);
    }

    /**
     * @param $id
     * @param UpdateExamRequest $request
     * @return mixed
     */
    public function update($id, UpdatePartnerorderPaymentRequest $request) {
        $partnerorder = $this->partnerorderPayments->update($id, $request->all());

        return redirect()->route('admin.partnerorderpayments.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.partnerorders.updated"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id) {
        $this->partnerorderPayments->destroy($id);
        return redirect()->back()->withFlashSuccess(trans("alerts.partnerorders.deleted"));
    }


}