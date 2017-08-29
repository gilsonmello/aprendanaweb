<?PHP

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Order\CreateOrderRequest;
use App\Http\Requests\Backend\Order\UpdateOrderRequest;
use App\Repositories\Backend\Order\OrderContract;
use App\Repositories\Backend\OrderCourse\OrderCourseContract;
use App\Repositories\Backend\OrderLesson\OrderLessonContract;
use App\Repositories\Backend\OrderModule\OrderModuleContract;
use App\Repositories\Backend\OrderPackage\OrderPackageContract;
use App\Repositories\Backend\Coupon\CouponContract;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\User;
use App\OrderStatus;
use App\Coupon;
use App\Configuration;
use Illuminate\Support\Facades\Mail;

/**
 * Class DashboardController
 * @package App\Http\Controllers\Backend
 */
class OrderController extends Controller {

    /**
     * @param ArticleContract $articles
     */
    public function __construct(OrderContract $orders, OrderCourseContract $ordercourses, OrderModuleContract $ordermodules, OrderLessonContract $orderlessons, OrderPackageContract $orderpackages, CouponContract $ordercoupon) {
        $this->orders = $orders;
        $this->ordercourses = $ordercourses;
        $this->ordermodules = $ordermodules;
        $this->orderlessons = $orderlessons;
        $this->orderpackages = $orderpackages;
        $this->ordercoupon = $ordercoupon;
    }

    /**
     * @param int $id
     * @param Request $request
     * @return route
     */
    public function cartRecovery($id, Request $request) {
        $order = $this->orders->findOrThrowException($id, true);
        $due_date = date('Y') + 1;
        $due_date = date($due_date . '-m-d 00:00:00');
        $percentage = Configuration::all(['*'])->first()->cart_recovery;
        try {
            $coupon = new Coupon;
            $coupon->name = 'Recuperação de Carrinho -' . $order->id;
            $coupon->code = 'bonus' . $order->student->personal_id;
            $coupon->start_date = date('Y-m-d H:i:s');
            $coupon->due_date = date('Y-m-d H:i:s');
            $coupon->limit = 1;
            $coupon->used = 0;
            $coupon->percentage = $percentage;
            $coupon->value = 0;
            $coupon->description = '<p>Recuperação de Carrinho</p>';
            $coupon->recover_action = 1;
            $coupon->user_id_created_by = \Auth::user()->id;
            if ($coupon->save()) {
                Mail::send('emails.recoverycart', [
                    'student_name' => $order->student->name,
                    'percentage' => number_format($percentage, 1, ',', '.')
                        ], function ($message) use ($order) {
                    $message->to($order->student->email, $order->student->name)
                            ->bcc([
                                'jeferson@brasiljuridico.com.br',
                                'adhemarfontes@gmail.com'
                            ])
                            ->subject("Brasil Jurídico :: Cupom de desconto")
                            ->from("atendimento@brasiljuridico.com.br", app_name());
                });
                return redirect()->route('admin.orders.index')->withFlashSuccess("Enviado com sucesso!");
            }
        } catch (Exception $e) {
            return redirect()->route('admin.orders.index')->withFlashDanger(trans("Erro ao enviar cupom para o aluno"));
        }
    }

    /**
     * @return mixed
     */
    public function index(Request $request) {
        $request->session()->put('lastpage', $request->only('page')['page']);

        $f_submit = $request->input('f_submit', '');

        //Pegando os valores da passados como parâmetros na url via get
        $f_OrderController_id = get_parameter_or_session($request, 'f_OrderController_id', '', $f_submit, '');

        $f_OrderController_date_begin = get_parameter_or_session($request, 'f_OrderController_date_begin', '', $f_submit, format_datebr(Carbon::now()->addDays(-30)));

        $f_OrderController_date_end = get_parameter_or_session($request, 'f_OrderController_date_end', '', $f_submit, format_datebr(Carbon::now()));

        $f_OrderController_status_id = get_parameter_or_session($request, 'f_OrderController_status_id', '', $f_submit, '');

        $f_OrderController_without_enrollment = get_parameter_or_session($request, 'f_OrderController_without_enrollment', '', $f_submit, '');

        $f_OrderController_only_paid = get_parameter_or_session($request, 'f_OrderController_only_paid', '', $f_submit, '');

        $f_OrderController_export_to_csv = get_parameter_or_session($request, 'f_OrderController_export_to_csv', '', '1', '0');


        if ($f_OrderController_id != '') {
            $f_OrderController_date_begin = '';
            $f_OrderController_date_end = '';
            $f_OrderController_status_id = '';
        }

        //Verificando se foi selecionado os liberados sem matrículas
        if ($f_OrderController_without_enrollment == '1' && ($f_OrderController_status_id != '' || $f_OrderController_status_id == '')) {
            $f_OrderController_status_id = '4';
        }

        //Se foi selecionado exportar, se não lista os resultados normal
        if ($f_OrderController_export_to_csv == '1') {
            $orders = $this->orders->getAllOrders($f_OrderController_date_begin, $f_OrderController_date_end, $f_OrderController_id, $f_OrderController_status_id, $f_OrderController_without_enrollment);

            $this->orders_to_csv_download($orders);
        } else {
            $orders = $this->orders->getOrdersPaginated(config('access.users.default_per_page'), $f_OrderController_date_begin, $f_OrderController_date_end, $f_OrderController_id, $f_OrderController_status_id, null, $f_OrderController_without_enrollment, $f_OrderController_only_paid);

            $total = 0;
            foreach ($orders as $order) {
                $total = $total + $order->discount_price;
            }

            $orderStatus = OrderStatus::orderBy('id', 'asc')->get();

            return view('backend.orders.index')
                            ->withOrders($orders)
                            ->withOrdercontrollerdatebegin($f_OrderController_date_begin)
                            ->withOrdercontrollerdateend($f_OrderController_date_end)
                            ->withOrderstotal($total)
                            ->withOrdercontrollerstatusid($f_OrderController_status_id)
                            ->withOrdercontrollerid($f_OrderController_id)
                            ->withOrderstatus($orderStatus)
                            ->withOrderwithoutenrollment($f_OrderController_without_enrollment)
                            ->withOrderonlypaid($f_OrderController_only_paid);
        }
    }

    function orders_to_csv_download($orders, $delimiter = ",") {
        // open raw memory as file so no temp files needed, you might run out of memory though
        $f = fopen('php://output', 'w');

        $filename = "exportacao_pedidos_" . time() . ".csv";

        fputs($f, $bom = ( chr(0xEF) . chr(0xBB) . chr(0xBF) ));

        header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '";');

        fputcsv($f, array('Identificador do Pedido', 'Aluno', 'E-mail', 'Código do Cupom', 'Data Nasc.', 'CPF', 'CEP', 'Status', 'Date Registro', utf8_encode('Data Confirmação'), utf8_encode('Preço'), utf8_encode('Valor Líquido')), ',');

        foreach ($orders as $order) {
            // generate csv lines from the inner arrays
            $line = array(
                $order->id,
                ( $order->student != null ? $order->student->name : ""),
                ( $order->student != null ? $order->student->email : ""),
                ( $order->coupon['code'] != null ? $order->coupon['code'] : ""),
                ( $order->student != null ? $order->student->birthdate : ""),
                ( $order->student != null ? $order->student->personal_id : ""),
                ( $order->student != null ? $order->student->zip : ""),
                ( $order->status != null ? $order->status->name : ""),
                format_datebr($order->date_registration),
                ($order->date_confirmation != null ? format_datebr($order->date_confirmation) : ""),
                number_format($order->price, 2, ',', '.'),
                number_format($order->discount_price, 2, ',', '.'));
            fputcsv($f, $line, $delimiter);
        }
        fpassthru($f);
    }

    /**
     * @return mixed
     */
    public function create() {
        return view('backend.orders.create');
    }

    /**
     * @param CreateArticleRequest $request
     * @return mixed
     */
    public function store(CreateOrderRequest $request) {
        $f_OrderController_status_id = $request->session()->get('f_OrderController_status_id', '');

        $this->orders->create($request, $f_OrderController_status_id);

        return redirect()->route('admin.orders.index')->withFlashSuccess(trans("alerts.orders.created"));
    }

    /**
     * Seleciona o pedido e seus itens
     * @param type $id
     * @return type
     */
    public function selectOrder($id) {
        $order = $this->orders->findOrThrowException($id, true);
        $student = getStudentData_helper($order->student_id);

        $orderGoogle = [];
        $orderGoogle["id"] = $order->id;
        $orderGoogle["affiliation"] = $student->name;
        $orderGoogle["revenue"] = ($order->discount_price);
        $orderGoogle["shipping"] = 0;
        $orderGoogle["tax"] = 0;

        $ordercourses = $this->ordercourses->getAllOrderCourses($order->id);

        $itemGoogle = [];
        $i = 0;

        foreach ($ordercourses as $item) {
            $dataCourse = get_course_helper($item->course_id);
            $itemGoogle[$i]["id"] = $order->id;
            $itemGoogle[$i]["name"] = $dataCourse->title;
            $itemGoogle[$i]["sku"] = $item->course_id;
            $itemGoogle[$i]["category"] = 'ecommerce';

            if ($item->discount_price > 0) {
                $price = $item->discount_price;
            } else {
                $price = $item->price;
            }

            //O valor precisa ser normal
            $itemGoogle[$i]["price"] = number_format($price, 2, ',', '.');
            // A quantidade do produto para exclusão precisa ser negativa

            $itemGoogle[$i]["quantity"] = get_total_itens_order_helper($order->id, $item->course_id) * -1;
            $i++;
        }

        return [json_encode($orderGoogle), json_encode($itemGoogle)];
    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit($id) {
        $order = $this->orders->findOrThrowException($id, true);

        $ordercourses = $this->ordercourses->getAllOrderCourses($order->id);
        $ordermodules = $this->ordermodules->getAllOrderModules($order->id);
        $orderlessons = $this->orderlessons->getAllOrderLessons($order->id);
        $orderpackages = $this->orderpackages->getAllOrderPackages($order->id);
        $ordercoupon = $this->ordercoupon->getCoupon($order->coupon_id);

        if ($order->coupon_id > 0) {
            $ordercoupon->description = strip_tags($ordercoupon->description);
        }

        return view('backend.orders.edit')
                        ->withOrder($order)
                        ->withOrdercourses($ordercourses)
                        ->withOrdermodules($ordermodules)
                        ->withOrderlessons($orderlessons)
                        ->withOrderpackages($orderpackages)
                        ->withOrdercoupon($ordercoupon);
    }

    /**
     * @param $id
     * @param UpdateArticleRequest $request
     * @return mixed
     */
    public function update($id, UpdateOrderRequest $request) {
        $this->orders->update($id, $request->all());
        return redirect()->route('admin.orders.index')->withFlashSuccess(trans("alerts.orders.updated"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id) {
        $this->orders->destroy($id);
        return redirect()->back()->withFlashSuccess(trans("alerts.orders.deleted"));
    }

    public function deactivated($id) {
        $this->orders->deactivated($id);
        return redirect()->back()->withFlashSuccess(trans("alerts.orders.deactivated"));
    }

    public function activated($id) {
        $this->orders->activated($id);
        return redirect()->back()->withFlashSuccess(trans("alerts.orders.activated"));
    }


}
