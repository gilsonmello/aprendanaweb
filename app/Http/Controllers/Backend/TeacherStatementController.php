<?PHP namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\TeacherStatement\CreateTeacherStatementRequest;
use App\Http\Requests\Backend\TeacherStatement\UpdateTeacherStatementRequest;
use App\Repositories\Backend\OrderPackage\OrderPackageContract;
use App\Repositories\Backend\PartnerorderPayment\PartnerorderPaymentContract;
use App\Repositories\Backend\TeacherStatement\TeacherStatementContract;
use App\Repositories\Backend\Order\OrderContract;
use App\Repositories\Backend\OrderCourse\OrderCourseContract;
use App\Repositories\Backend\OrderLesson\OrderLessonContract;
use App\Repositories\Backend\OrderModule\OrderModuleContract;
use App\Repositories\Backend\CourseTeacher\CourseTeacherContract;
use App\Repositories\Backend\PackageTeacher\PackageTeacherContract;
use App\Repositories\Backend\Configuration\ConfigurationContract;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\User;
use App\TeacherStatement;
use App\CourseTeacher;


/**
 * Class DashboardController
 * @package App\Http\Controllers\Backend
 */
class TeacherStatementController extends Controller {


    /**
     * @param ArticleContract $articles
     */
    public function __construct(TeacherStatementContract $teacherStatements, OrderContract $orders,
                                OrderCourseContract $ordercourses, OrderModuleContract $ordermodules, OrderLessonContract $orderlessons,
                                CourseTeacherContract $courseteachers, ConfigurationContract $configuration,
                                OrderPackageContract $orderpackages, PackageTeacherContract $packageteachers,
                                PartnerorderPaymentContract $partnerorderpayments) {
        $this->teacherStatements = $teacherStatements;
        $this->orders = $orders;
        $this->ordercourses = $ordercourses;
        $this->ordermodules = $ordermodules;
        $this->orderlessons = $orderlessons;
        $this->courseteachers = $courseteachers;
        $this->configuration = $configuration;
        $this->orderpackages = $orderpackages;
        $this->packageteachers = $packageteachers;
        $this->partnerorderpayments = $partnerorderpayments;
    }

    /**
     * @return mixed
     */
    public function index(Request $request)
    {

        $request->session()->put('lastpage', $request->only('page')['page']);

        $f_submit = $request->input('f_submit', '');

        $f_TeacherStatementController_date_begin = $request->input('f_TeacherStatementController_date_begin', '');
        if (($f_submit != '1') && ($f_TeacherStatementController_date_begin === '')) {
            $f_TeacherStatementController_date_begin = $request->session()->get('f_TeacherStatementController_date_begin', '');
        }
        if ($f_TeacherStatementController_date_begin === '') {
            $f_TeacherStatementController_date_begin = format_datebr(Carbon::now()->addDays(-30));
        }
        $request->session()->put('f_TeacherStatementController_date_begin', $f_TeacherStatementController_date_begin);

        $f_TeacherStatementController_date_end = $request->input('f_TeacherStatementController_date_end', '');
        if (($f_submit != '1') && ($f_TeacherStatementController_date_end === '')) {
            $f_TeacherStatementController_date_end = $request->session()->get('f_TeacherStatementController_date_end', '');
        }
        if ($f_TeacherStatementController_date_end === '') {
            $f_TeacherStatementController_date_end = format_datebr(Carbon::now());
        }
        $request->session()->put('f_TeacherStatementController_date_end', $f_TeacherStatementController_date_end);

        $teachers = [];
        if (access()->hasRoles(['Professor'])) {
            $f_TeacherStatementController_user_id = auth()->user()->id;
        } else {
            $f_TeacherStatementController_user_id = $request->input('f_TeacherStatementController_user_id', '');
            //dd($f_TeacherStatementController_user_id);
            if (($f_submit != '1') && ($f_TeacherStatementController_user_id === '')) {
                $f_TeacherStatementController_user_id = $request->session()->get('f_TeacherStatementController_user_id', '');
            }
            if ($f_TeacherStatementController_user_id === '') {
                $f_TeacherStatementController_user_id = 1; //for�a buscar registros de um user, neste caso 1
            }
            $request->session()->put('f_TeacherStatementController_user_id', $f_TeacherStatementController_user_id);
            $teachers = User::teachers()->orderBy('name', 'asc');
        }

        $teacherStatements = $this->teacherStatements->getTeacherStatementsWithBalance( $f_TeacherStatementController_date_begin, $f_TeacherStatementController_date_end, $f_TeacherStatementController_user_id );
        $ordersValue = 0;
        $paymentsValue = 0;
        $anticipationsValue = 0;
        $ordersCount = 0;
        $paymentsCount = 0;
        $anticipationsCount = 0;
        foreach ($teacherStatements as $teacherstatement){
            if ($teacherstatement->order_id != null || $teacherstatement->partnerorder_id != null){
                $ordersValue = $ordersValue + $teacherstatement->value;
                $ordersCount++;
            } else {
                if ($teacherstatement->anticipation === 1 ){
                    $anticipationsValue = $anticipationsValue + ($teacherstatement->value * -1);
                    $anticipationsCount++;
                } else {
                    $paymentsValue = $paymentsValue + ($teacherstatement->value * -1);
                    $paymentsCount++;
                }
            }
        }

        return view('backend.teacherstatements.index')
            ->withTeacherstatements( $teacherStatements )
            ->withTeacherstatementcontrollerdatebegin( $f_TeacherStatementController_date_begin )
            ->withTeacherstatementcontrollerdateend( $f_TeacherStatementController_date_end )
            ->withTeacherstatementcontrolleruserid( $f_TeacherStatementController_user_id )
            ->withOrdersvalue( $ordersValue )
            ->withPaymentsvalue( $paymentsValue )
            ->withAnticipationsvalue( $anticipationsValue )
            ->withOrderscount( $ordersCount )
            ->withPaymentscount( $paymentsCount )
            ->withAnticipationscount( $anticipationsCount )
            ->withTeachers( $teachers );

    }

    /**
     * @return mixed
     */
    public function create() {
        return view('backend.teacherstatements.create');
    }

    /**
     * @param CreateArticleRequest $request
     * @return mixed
     */
    public function store(CreateTeacherStatementRequest $request) {
        $f_TeacherStatementController_user_id = $request->session()->get('f_TeacherStatementController_user_id', '');

        $this->teacherStatements->create($request, $f_TeacherStatementController_user_id);

        return redirect()->route('admin.teacherstatements.index')->withFlashSuccess(trans("alerts.teacherstatements.created"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit($id) {
        $teacherStatement = $this->teacherStatements->findOrThrowException($id, true);
        return view('backend.teacherstatements.edit')->withTeacherstatement($teacherStatement);
    }

    /**
     * @param $id
     * @param UpdateArticleRequest $request
     * @return mixed
     */
    public function update($id, UpdateTeacherStatementRequest $request) {
        $this->teacherStatements->update($id, $request->all());
        return redirect()->route('admin.teacherstatements.index')->withFlashSuccess(trans("alerts.teacherstatements.updated"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id) {
        $this->teacherStatements->destroy($id);
        return redirect()->back()->withFlashSuccess(trans("alerts.teacherstatements.deleted"));
    }

    public function deactivated($id) {
        $this->teacherStatements->deactivated($id);
        return redirect()->back()->withFlashSuccess(trans("alerts.teacherstatements.deactivated"));
    }

    public function activated($id) {
        $this->teacherStatements->activated($id);
        return redirect()->back()->withFlashSuccess(trans("alerts.teacherstatements.activated"));
    }

    public function processToday(){
        $today = Carbon::now();
        $today = $today->day . '-' . $today->month . '-' . $today->year;
        $this->process( $today );

//        Mail::raw('Brasil Jurídico :: pagamento dos professores processado para ' . $today,
//            function($message, $today)
//            {
//                $message->from('us@example.com', 'Laravel');
//                $message->to('foo@example.com');
//                $message->subject('Brasil Jurídico :: pagamento dos professores processado para ' . $today);
//            });
    }

    public function processAll(){
//        $date = parsebr(format_datebr(Carbon::now()));
//        for ($i = 1; $i < 300; $i++){
//            $this->process(str_replace('/', '-', format_datebr($date)));
//            $date->addDay(-1);
//        }
    }

    public function process($datebegin, $dateend){

        try {
            \DB::beginTransaction();

            $configuration = $this->configuration->findOrThrowException();

            $datebegin = parsebr(str_replace('-', '/', $datebegin));
            $dateOrdersBegin = Carbon::parse($datebegin);

            $dateend = parsebr(str_replace('-', '/', $dateend));
            $dateOrdersEnd = Carbon::parse($dateend);

            $this->teacherStatements->deleteTeacherStatementsFromOrder(format_datebr($datebegin), format_datebr($dateend));

            $orders = $this->orders->getOrdersForPayment(format_datebr($dateOrdersBegin), format_datebr($dateOrdersEnd));
            foreach ($orders as $order) {
                $ordercourses = $this->ordercourses->getAllOrderCourses($order->id);
                //$ordermodules = $this->ordermodules->getAllOrderModules($order->id);
                //$orderlessons = $this->orderlessons->getAllOrderLessons($order->id);
                $orderpackages = $this->orderpackages->getAllOrderPackages($order->id);

                if ($order->discount_price != 0) {

                    foreach ($ordercourses as $ordercourse) {
                        if (($order->student != null) && ($ordercourse->course != null) && ($ordercourse->course->teachers_percentage != 0)) {
                            $courseteachers = $this->courseteachers->getAllCourseTeachersPerCourse($ordercourse->course->id);
                            foreach ($courseteachers as $courseteacher) {
                                $teacherStatement = new TeacherStatement;
                                $teacherStatement->user_teacher_id = $courseteacher->teacher->id;
                                $teacherStatement->order_id = $order->id;
                                $teacherStatement->buyer_name = $order->student->name;
                                $teacherStatement->product_name = $ordercourse->course->title;
                                $teacherStatement->date_order = $order->date_confirmation;
                                $teacherStatement->value_order = $ordercourse->price;
                                $teacherStatement->value_discount = $ordercourse->price - $ordercourse->discount_price;
                                $teacherStatement->value_order_final = $ordercourse->discount_price;
                                $teacherStatement->value_payment_tax = $ordercourse->discount_price * $configuration->payment_fee / 100;
                                $teacherStatement->value_taxes = $ordercourse->discount_price * $configuration->taxes / 100;
                                $teacherStatement->value_costs = $ordercourse->discount_price * $configuration->operational_cost / 100;
                                $teacherStatement->value_net = $teacherStatement->value_order_final -
                                    $teacherStatement->value_payment_tax -
                                    $teacherStatement->value_taxes -
                                    $teacherStatement->value_costs;
                                $teacherStatement->percentage_distribute = $ordercourse->course->teachers_percentage;
                                $teacherStatement->value_distribute = $teacherStatement->value_net * $ordercourse->course->teachers_percentage / 100;
                                $teacherStatement->percentage = $courseteacher->percentage;
                                $teacherStatement->value = $teacherStatement->value_distribute * $courseteacher->percentage / 100;
                                $teacherStatement->date = parsebr(format_datebr($order->date_confirmation))->addDay(30);
                                $teacherStatement->anticipation = 0;
                                $teacherStatement->save();
                            }
                        }
                    }

                    foreach ($orderpackages as $orderpackage) {
                        if (($order->student != null) && ($orderpackage->package != null) && ($orderpackage->package->teachers_percentage != 0)) {
                            $packageteachers = $this->packageteachers->getAllPackageTeachersPerPackage($orderpackage->package->id);
                            foreach ($packageteachers as $packageteacher) {
                                $teacherStatement = new TeacherStatement;
                                $teacherStatement->user_teacher_id = $packageteacher->teacher->id;
                                $teacherStatement->order_id = $order->id;
                                $teacherStatement->buyer_name = $order->student->name;
                                $teacherStatement->product_name = $orderpackage->package->title;
                                $teacherStatement->date_order = $order->date_confirmation;
                                $teacherStatement->value_order = $orderpackage->price;
                                $teacherStatement->value_discount = $orderpackage->price - $orderpackage->discount_price;
                                $teacherStatement->value_order_final = $orderpackage->discount_price;
                                $teacherStatement->value_payment_tax = $orderpackage->discount_price * $configuration->payment_fee / 100;
                                $teacherStatement->value_taxes = $orderpackage->discount_price * $configuration->taxes / 100;
                                $teacherStatement->value_costs = $orderpackage->discount_price * $configuration->operational_cost / 100;
                                $teacherStatement->value_net = $teacherStatement->value_order_final -
                                    $teacherStatement->value_payment_tax -
                                    $teacherStatement->value_taxes -
                                    $teacherStatement->value_costs;
                                $teacherStatement->percentage_distribute = $orderpackage->package->teachers_percentage;
                                $teacherStatement->value_distribute = $teacherStatement->value_net * $orderpackage->package->teachers_percentage / 100;
                                $teacherStatement->percentage = $packageteacher->percentage;
                                $teacherStatement->value = $teacherStatement->value_distribute * $packageteacher->percentage / 100;
                                $teacherStatement->date = parsebr(format_datebr($order->date_confirmation))->addDay(30);
                                $teacherStatement->anticipation = 0;
                                $teacherStatement->save();
                            }
                        }
                    }
                }
            }

            $partnerorders = $this->partnerorderpayments->getPartnerOrdersForPayment(format_datebr($dateOrdersBegin), format_datebr($dateOrdersEnd));
            foreach ($partnerorders as $partnerorderpayment) {
                if (($partnerorderpayment->paid_date != null) && ($partnerorderpayment->paid_value != null) && ($partnerorderpayment->paid_value != 0)) {

                    if (($partnerorderpayment->partnerOrder->partner != null) && ($partnerorderpayment->partnerOrder->course != null) && ($partnerorderpayment->partnerOrder->course->teachers_percentage != 0)) {

                        $courseteachers = $this->courseteachers->getAllCourseTeachersPerCourse($partnerorderpayment->partnerOrder->course->id);
                        foreach ($courseteachers as $courseteacher) {
                            $teacherStatement = new TeacherStatement;
                            $teacherStatement->user_teacher_id = $courseteacher->teacher->id;

                            $teacherStatement->partnerorder_id = $partnerorderpayment->partnerOrder->id;
                            $teacherStatement->partnerorderpayment_id = $partnerorderpayment->id;

                            $teacherStatement->buyer_name = $partnerorderpayment->partnerOrder->partner->name;
                            $teacherStatement->product_name = $partnerorderpayment->partnerOrder->course->title;
                            $teacherStatement->date_order = $partnerorderpayment->paid_date;

                            $teacherStatement->value_order = $partnerorderpayment->paid_value;
                            $teacherStatement->value_discount = 0.00;
                            $teacherStatement->value_order_final = $partnerorderpayment->paid_value;
                            $teacherStatement->value_payment_tax = $partnerorderpayment->paid_value * $configuration->payment_fee / 100;
                            $teacherStatement->value_taxes = $partnerorderpayment->paid_value * $configuration->taxes / 100;
                            $teacherStatement->value_costs = $partnerorderpayment->paid_value * $configuration->operational_cost / 100;
                            $teacherStatement->value_net = $teacherStatement->value_order_final -
                                $teacherStatement->value_payment_tax -
                                $teacherStatement->value_taxes -
                                $teacherStatement->value_costs;
                            $teacherStatement->percentage_distribute = $partnerorderpayment->partnerOrder->course->teachers_percentage;
                            $teacherStatement->value_distribute = $teacherStatement->value_net * $partnerorderpayment->partnerOrder->course->teachers_percentage / 100;
                            $teacherStatement->percentage = $courseteacher->percentage;
                            $teacherStatement->value = $teacherStatement->value_distribute * $courseteacher->percentage / 100;
                            $teacherStatement->date = parsebr(format_datebr($partnerorderpayment->paid_date))->addDay(5);
                            $teacherStatement->anticipation = 0;
                            $teacherStatement->save();

                            $partnerorderpayment->processed = 1;
                            $partnerorderpayment->save();

                        }
                    }
                }
            }

            \DB::commit();
        } catch (Exception $e) {
            \DB::rollback();
        }
   }

}