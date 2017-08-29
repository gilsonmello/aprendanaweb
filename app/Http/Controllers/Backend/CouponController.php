<?php
/**
 * Created by PhpStorm.
 * User: geofrey19
 * Date: 22/09/15
 * Time: 16:38
 */

namespace App\Http\Controllers\Backend;


use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Coupon\CreateCouponRequest;
use App\Http\Requests\Backend\Coupon\UpdateCouponRequest;
use App\Repositories\Backend\Coupon\CouponContract;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Commands\importPartnerCommand;
use FPDI;

class CouponController extends Controller {
    
    /**
     * @param CouponContract $coupons
     */
    public function __construct(CouponContract $coupons) {
        $this->coupons = $coupons;

    }

    /**
     * @return mixed
     */
    public function index(Request $request) {
        $request->session()->put('lastpage', $request->only('page')['page']);

        $f_submit = $request->input('f_submit', '');

        $f_CouponController_name = get_parameter_or_session( $request, 'f_CouponController_name', '', $f_submit, '' );

        return view('backend.coupons.index')
            ->withCoupons($this->coupons->getCouponsPaginated(config('access.users.default_per_page'), $f_CouponController_name))
            ->withCouponcontrollername($f_CouponController_name);
    }
    
    /**
     * @return mixed
     */
    public function create() {
        return view('backend.coupons.create');
    }

    /**
     * @param CreateCouponRequest $request
     * @return mixed
     */
    public function store(CreateCouponRequest $request) {
        $this->coupons->create($request);
        return redirect()->route('admin.coupons.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.coupons.created"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit($id) {
        $coupon = $this->coupons->findOrThrowException($id, true);
        return view('backend.coupons.edit')->withCoupon($coupon);
    }


    /**
     * @param $id
     */
    public function send($id){
        $coupon = $this->coupons->findOrThrowException($id,true);
        $user_emails = $coupon->users;

        foreach($user_emails  as $user_email){

            Mail::send('emails.coupon', ['user' => $user_email, 'coupon' => $coupon], function ($message) use ($user_email) {
                $message->to($user_email->email, $user_email->name)->subject(app_name() . ':' . trans("strings.coupons"));
            });

        }
        return redirect()->back()->withFlashSuccess(trans('alerts.coupons.sent'));

    }

    /**
     * @param $id
     * @param UpdateCouponRequest $request
     * @return mixed
     */
    public function update($id, UpdateCouponRequest $request) {
        $this->coupons->update($id, $request->except(['students','courses','modules']), $request->only('students'),
            $request->only('courses'),$request->only('modules'));
        return redirect()->route('admin.coupons.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.coupons.updated"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id) {
        $this->coupons->destroy($id);
        return redirect()->back()->withFlashSuccess(trans("alerts.coupons.deleted"));
    }


    /**
     * @return mixed
     */
    public function import() {
        return view('backend.coupons.import');
    }

    public function importFromPartner(Request $request){
        //$this->coupons->importFromPartner($fileKeyPath, $partner, $percentage, $value, $daysToUse);
        $this->dispatch( new importPartnerCommand(  ) );

        return redirect()->back()->withFlashSuccess(trans("alerts.coupons.toimport"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function generatePdf($id) {

        $coupon = $this->coupons->findOrThrowException($id);
        $coupon_courses = $coupon->courses;
        $coupon_users = $coupon->users;
        $data = [
            'Coupon'    =>  $coupon,
            'Course'    =>  (count($coupon_courses)) > 0 ? $coupon_courses : null,
            'User'      =>  (count($coupon_users)) > 0 ? $coupon_users : null
        ];


        $pdf = new FPDI('P', 'mm', 'A4'); //FPDI extends TCPDF

        // set the source file
        $pdf->setSourceFile("../company_logo.pdf");

        // import a page
        $templateId = $pdf->importPage(1);
        // get the size of the imported page
        $size = $pdf->getTemplateSize($templateId);


        // create a page (landscape or portrait depending on the imported page size)
        $pdf->SetTopMargin(30);
        $pdf->SetFooterMargin(30);
        $pdf->SetLeftMargin(30);
        $pdf->SetRightMargin(30);
        // set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);



        // set margins
        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        //$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->setPrintHeader(false);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

        $pdf->AddPage('P');

        // use the imported page and place it at point 10,10 with a width of 100 mm
        $pdf->useTemplate($templateId, 0, 0, $size['w'], $size['h']);

        $pdf->SetFont('Helvetica', '', 10);
        $pdf->SetTextColor(0, 0, 0);

        $txt = view('backend.coupons.generatepdf')->withCoupon($data)->render();

        $pdf->writeHTMLCell(180, 30, 10, 10, $txt, 0, 0, false, true, 'C', true);

        $pdf->Output('autorizacao'. $coupon->id . '.pdf', 'D');
    }
}