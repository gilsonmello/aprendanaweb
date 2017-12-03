<?PHP

namespace App\Http\Controllers\Frontend;

use App\Order;
use App\Coupon;
use App\Exceptions\GeneralException;
use App\Enrollment;
use App\Http\Controllers\Controller;
use App\Repositories\Backend\Order\OrderContract;
use App\Repositories\Frontend\Coupon\CouponContract;
use App\Repositories\Frontend\Course\CourseContract;
use App\Services\Cart\CartService;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use laravel\pagseguro\Facades\PagSeguro;
use Illuminate\Support\Facades\DB;

/**
 * Class CartController app/Http/Controllers/Frontend/CartController.php
 * @package App\Http\Controllers\Frontend
 */
class CartController extends Controller {

    public function __construct(CourseContract $courses, CartService $cartService, OrderContract $order, CouponContract $coupon) {
        $this->courses = $courses;
        $this->cart = $cartService;
        $this->order = $order;
        $this->coupon = $coupon;
    }

    public function add_only() {
        $item_id = $_POST['item'];
        $type = $_POST['type'];
        $item = $this->cart->getItemByType($item_id, $type);

        $item->course_from_exam = 1;

        if (!$this->cart->getById($item_id, $type)) {
            $this->cart->addItem($item, $type);
            $order = $this->order->findOrThrowException($this->cart->orderInSession);
            $this->cart->setDiscountInSession(0);
            if (isset($order->coupon->code)) {
                $this->buildDiscountFromCoupon($order->coupon->code);
            } else if ($this->cart->getPartnerInSession() != null) {
                $this->buildDiscountFromPartner($this->cart->getPartnerInSession()->id, $this->cart->getPartnerInSession()->key);
            } else {
                $this->cart->calculateDiscountFromPackages();
                $this->cart->calculateDiscountFromCourses();
            }
        }
        return ["count" => Cart::count(), "total" => number_format($this->cart->getFullCart()->total, 2, ',', '.'), "discount" => number_format($this->cart->getFullCart()->discount, 2, ',', '.')];
    }

    /**
     * @param $item_id
     * @param $type
     * @return \Illuminate\Http\RedirectResponse
     * @throws \App\Exceptions\GeneralException
     */
    public function fast_purchase($item_id, $type) {
        $item = $this->cart->getItemByType($item_id, $type);

        if (!$this->cart->getById($item_id, $type))
            $this->cart->addItem($item, $type);

        return redirect()->route('cart.auth');
    }

    /**
     * Add item to cart
     *
     * @param $item_id
     * @param $type
     * @return mixed
     */
    public function add($item_id, $type) {

        $item = $this->cart->getItemByType($item_id, $type);

        if (!$this->cart->getById($item_id, $type)) {
            $this->cart->addItem($item, $type);

            $order = $this->order->findOrThrowException($this->cart->orderInSession);

            $this->cart->setDiscountInSession(0);
            if (isset($order->coupon->code)) {
                $this->buildDiscountFromCoupon($order->coupon->code);
            } else if ($this->cart->getPartnerInSession() != null) {
                $this->buildDiscountFromPartner($this->cart->getPartnerInSession()->id, $this->cart->getPartnerInSession()->key);
            } else {
                $this->cart->calculateDiscountFromPackages();
                $this->cart->calculateDiscountFromCourses();
            }

            //Comprando apenas um item gratuito
            $items = $this->cart->getFullCart();
            if (($items->total <= 0) && (Cart::count() == 1)) {
                return redirect()->route('cart.payment');
            }
        }

        //$request['added'] = '1'; Adhemar code
        return redirect()->route('cart.items');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function items(Request $request) {



        if (session('compliance.cart') === TRUE) {
            return redirect()->route('cart.auth');
        }

        $items = $this->cart->getFullCart();

        $max_installments = $items->pluck('options.max_installments')->max();

        //Pegando a quantidade máxima de parcelas sem juros
        if ($items->total != 0) {
            $parcel = [];
            for ($i = 1; $i <= 12; $i++) {
                $parcel[$i] = $items->total / $i;
            }
            $countParcel = [];
            for ($i = 1; $i <= 12; $i++) {
                if ($parcel[$i] > 20 && (!isset($max_installments) || $i <= $max_installments) || $i == 1) {
                    $countParcel = $i;
                }
            }
        }
        return view('frontend.cart.items', compact('items', 'countParcel'))->withAdded($request['added']);
    }

    /**
     * @return view
     */
    public function auth() {

        //Condicional para saber se o usuário veio da rota /compliance
        if (isset($_SERVER['HTTP_REFERER']) && strpos($_SERVER['HTTP_REFERER'], 'compliance') > 0) {
            session(['compliance.cart' => true]);
        }

        //Variável que guarda se o usuário é do compliance
        $complianceUser = session('compliance.cart');

        //Se sim, verifico se há algum item no carrinho
        if ($complianceUser === TRUE) {

            //Recupero os itens do carrinho
            $items = $this->cart->getFullCart();

            //Se sim, verifico se já possui o curso do compliance no carrinho, 
            //Se não adiciono o compliance no carrinho
            if (count($items) > 0) {
                foreach ($items as $value) {
                    if ($value->id == 566 && $value->qty == 1) {
                        break;
                    }
                }
            } else if (count($items) == 0) {
                $item = $this->cart->getItemByType(566, 'course');
                $this->cart->addItem($item, 'course');
            }



            //$this->cart->destroy();
            //Se o usuário estiver logado, redireciono-o para o pagamento
            if (auth()->user()) {

                return redirect()->route('cart.payment');
            }
            //Se o usuário não estiver logado, redenrizo a view auth, para o cadastro
            if (!auth()->user()) {
                return view('frontend.compliance.cart.auth');
            }
        }

        //Fim da condicional se o usuário é veio do compliance
        //Usuário normal
        if (auth()->user())
            return redirect()->route('cart.payment');
        if (!auth()->user()) {



            if ($this->cart->getFullCart()->total > 0) {
                return view('frontend.cart.auth');
            } else {
                return view('frontend.cart.auth')->withFree('free');
            }
        }
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function payment() {
        $items = $this->cart->getFullCart();
        if (!isset(auth()->user()->id)) {
            if ($items->total > 0) {
                return redirect()->route('cart.auth');
            } else {
                return redirect()->route('cart.auth')->withFree('free');
            }
        }

        if ($items->total > 0) {
            if (auth()->user()->zip == null || auth()->user()->personal_id == null || auth()->user()->birthdate == null) {
                return redirect()->route('cart.complete_profile');
            }
        }

        if (!$this->cart->hasOrderInSession()) {
            return redirect()->route('cart.items');
        }

        if ($this->cart->getPartnerInSession() != null) {
            if ($this->cart->getPartnerInSession()->key != auth()->user()->personal_id) {
                return redirect()->route('cart.items')->withFlashDanger('CPF do beneficiário do desconto diferente do CPF do aluno!');
            }
        }

        //Se a compra for gratuita não valida o CPF
        if ($items->total > 0) {
            //Validação do CPF
            if (!validateCPF_helper(auth()->user()->personal_id)) {
                return redirect()->route('cart.complete_profile')
                                ->withFlashDanger('CPF inválido. Favor atualizar o seu cadastro.');
            }
        }

        $this->cart->assignStudent($this->cart->orderInSession, auth()->user()->id);


        if ($items->total > 0) {

            $checkout_code = $this->cart->getCheckoutCode($items);
        } else {
            $checkout_code = false;
        }
        if ($items->total <= 0) {
            //Mocking pagseguro feedback
            $items = $this->cart->createOrGetLastCart();

            $feedbackMocked = new \stdClass();
            $feedbackMocked->reference = $this->cart->orderInSession;
            $feedbackMocked->status = 3;

            //dd($this->cart->createOrGetLastCart(), $this->cart->orderInSession, $feedbackMocked);
            $this->order->updateFromPagseguroFeedback($feedbackMocked);
            return redirect()->route('frontend.dashboard');
        }


        // if (array_search(Auth::user()->email, $emailPagamentoTransparente) !== false || Auth::user()->id == 1 || Auth::user()->id == 354 || Auth::user()->id == 115) {
        $sessionId = $this->getSessionId();
        $max_installments = $items->pluck('options.max_installments')->max();
        return view('frontend.cart.direct', compact('checkout_code', 'items', 'sessionId', 'max_installments'));
        /* } else {
          return view('frontend.cart.payment', compact('checkout_code', 'items'));
          } */
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function conclusion($interest = 0) {
        $items = $this->cart->createOrGetLastCart();

        //Pedido Cancelado se o valor for <= 0
        if ($items->total <= 0) { //É uma compra gratuita
            //Mocking pagseguro feedback
            $feedbackMocked = new \stdClass();
            $feedbackMocked->reference = $this->cart->orderInSession;
            $feedbackMocked->status = 3;
            $this->order->updateFromPagseguroFeedback($feedbackMocked);
        } else {
            $orderGoogle = [];
            $orderGoogle["id"] = str_pad(session('order_id_in_session'), 6, '0', STR_PAD_LEFT);
            $orderGoogle["affiliation"] = auth()->user()->name;
            $orderGoogle["revenue"] = ($items->total - $items->discount);
            $orderGoogle["shipping"] = 0;
            $orderGoogle["tax"] = 0;
        }

        $itemGoogle = [];
        $i = 0;

        foreach ($items as $item) {
            $itemGoogle[$i]["id"] = str_pad(session('order_id_in_session'), 6, '0', STR_PAD_LEFT);
            $itemGoogle[$i]["name"] = $item->name;
            $itemGoogle[$i]["sku"] = $item->id;
            $itemGoogle[$i]["category"] = 'ecommerce';

            if ($item->discount_price > 0) {
                $price = $item->discount_price;
            } else {
                $price = $item->price;
            }

            $itemGoogle[$i]["price"] = number_format($price, 2, ',', '.');
            $itemGoogle[$i]["quantity"] = $item->qty;
            $i++;
        }

//        $this->cart->markCouponAsUsed(); //Ao concluir o sistema marca o cupom como utilizado
        return view('frontend.cart.conclusion', compact('items', 'interest'))
                        ->withItemgoogle(json_encode($itemGoogle))
                        ->withOrdergoogle(json_encode($orderGoogle));
    }

    /**
     * Exibe tela informando que o boleto foi emitido e que a compra será concretizada após confirmação do pagamento
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function billet_sent(Request $post_form) {
        $items = $this->cart->createOrGetLastCart();
        $interest = null;
        $form = $post_form;

        $orderGoogle = [];
        $orderGoogle["id"] = str_pad(session('order_id_in_session'), 6, '0', STR_PAD_LEFT);
        $orderGoogle["affiliation"] = auth()->user()->name;
        $orderGoogle["revenue"] = ($items->total - $items->discount); //Valor com desconto
        $orderGoogle["shipping"] = 0;
        $orderGoogle["tax"] = 0;

        $i = 0;
        foreach ($items as $item) {
            $itemGoogle[$i]["id"] = str_pad(session('order_id_in_session'), 6, '0', STR_PAD_LEFT);
            $itemGoogle[$i]["name"] = $item->name;
            $itemGoogle[$i]["sku"] = $item->id;
            $itemGoogle[$i]["category"] = 'ecommerce';

            if ($item->discount_price > 0) {
                $price = $item->discount_price;
            } else {
                $price = $item->price;
            }

            $itemGoogle[$i]["price"] = number_format($price, 2, ',', '.');
            $itemGoogle[$i]["quantity"] = $item->qty;
            $i++;
        }
//        $this->cart->markCouponAsUsed(); //Ao concluir o sistema marca o cupom como utilizado
        return view('frontend.cart.billet_sent', compact('items', 'interest', 'form'))
                        ->withItemgoogle(json_encode($itemGoogle))
                        ->withOrdergoogle(json_encode($orderGoogle));
    }

    /**
     * Get and handle with pagseguro returns
     * POST - pagseguro/feedback
     *
     * @return mixed
     */
    public function pagseguroFeedback() {

        /**
         * REFATORAR REFATORAR REFATORAR REFATORAR REFATORAR
         * REFATORAR           REFATORAR           REFATORAR
         * REFATORAR REFATORAR REFATORAR REFATORAR REFATORAR
         */
        ////////////// To tests //////////////
        $data = print_r($_POST, true);

        //file_put_contents(public_path() . '/teste/'.date('d_m_Y__H_i_s'), $data);
        ////////////// To tests //////////////

        Log::info($_POST);
        $code = $_POST['notificationCode'];

        ////////////// To tests //////////////
        //$code = '7F7AA96F474A474A222664BC9F8EFA8680C4';

        $environment = config('laravelpagseguro.use-sandbox');

        $host = ($environment == 'local') ? config('laravelpagseguro.host.sandbox') : config('laravelpagseguro.host.production');

        $request = [
            'url' => $host.'/v2/transactions/notifications/' . $code,
            'params' => [
                'email' => config('laravelpagseguro.credentials.email'),
                'token' => config('laravelpagseguro.credentials.token')
            ]
        ];

        $response = \HttpClient::get($request);

        $dataXml = $response->xml();

        $this->order->updateFromPagseguroFeedback($dataXml);

        file_put_contents(public_path() . '/log_pagseguro/' . date('d_m_Y__H_i_s') . '.xml', $response->content());


        /* Novo código do pagseguro */

        /* try{
          $request = [
          'url' => 'https://ws.pagseguro.uol.com.br/v2/transactions/notifications/' . $code,
          'params' => [
          'email' => config('laravelpagseguro.credentials.email'),
          'token' => config('laravelpagseguro.credentials.token')
          ]
          ];

          $response = \HttpClient::get($request);
          $dataXml = $response->xml();
          $this->order->updateFromPagseguroFeedback($dataXml);
          file_put_contents(public_path() . '/log_pagseguro/' . date('d_m_Y__H_i_s') . '.xml', $response->content());
          }catch(Exception $e){
          try{
          $request = [
          'url' => 'https://ws.pagseguro.uol.com.br/v2/transactions/notifications/' . $code,
          'params' => [
          'email' => config('laravelpagseguro.compliance.credentials.email'),
          'token' => config('laravelpagseguro.compliance.credentials.token')
          ]
          ];
          $response = \HttpClient::get($request);
          $dataXml = $response->xml();
          $this->order->updateFromPagseguroFeedback($dataXml);
          file_put_contents(public_path() . '/log_pagseguro/' . date('d_m_Y__H_i_s') . '.xml', $response->content());
          }catch(Exception $e){
          file_put_contents(public_path() . '/log_compliance/' . date('d_m_Y__H_i_s') . '.log', $response->content());
          }
          }
         */
    }

    /**
     * Discount coupon use
     *
     * @param Request $request
     * @return mixed
     */
    public function discount(Request $request) {
        $coupon_code = $request->get('coupon_code');
        $this->buildDiscountFromCoupon($coupon_code);
        return redirect()->route('cart.items');
    }

    /**
     * Build discounts processes
     *
     * @param $coupon_code
     * @return mixed
     */
    private function buildDiscountFromCoupon($coupon_code) {
        $this->cart->destroyDiscount();
        
        $availability = $this->cart->couponIsAvailableToUse($coupon_code);

        if ($availability['available'] == false) {            
            return redirect()->route('cart.items')->withFlashDanger($availability['message']);
        }

        $this->order->assignCouponToOrder($coupon_code, $this->cart->orderInSession);

        $discountMontanteCourse = $this->cart->applyDiscountsCourseItems($coupon_code);
        $discountMontantePackage = $this->cart->applyDiscountsPackageItems($coupon_code);

        $discountTotal = $discountMontanteCourse + $discountMontantePackage;
        session(['discount' => $discountTotal]);

        //Atualizando o valor Líquido
        $Order = Order::where('id', '=', $this->cart->orderInSession)->first();
        $Order->discount_price = $Order->price - $discountTotal;
        $Order->save();
        
        $this->cart->markCouponAsUsed();  
    }

    /**
     * Remove coupon discount
     *
     * @return mixed
     */
    public function remove_discount() {
        $this->cart->destroyDiscount();
        return redirect()->route('cart.items');
    }

    /**
     * Remove item from cart
     *
     * @param $id
     * @return mixed
     */
    public function remove($id) {
        $this->cart->removeItem($id);
        try {
            $order = $this->order->findOrThrowException($this->cart->orderInSession);
        } catch (\Exception $ex) {
            $order = null;
        }

        if ($order != null) {
            $items = $this->cart->getFullCart();
            $order->price = $items->total;
            $order->discount_price = (!is_null($items->discount)) ? $items->discount : $items->total;
            $order->update();
            $this->cart->setDiscountInSession(0);
            
            if (isset($order->coupon->code)) {
                $this->buildDiscountFromCoupon($order->coupon->code);
            } else if ($this->cart->getPartnerInSession() != null) {
                $this->buildDiscountFromPartner(
                        $this->cart->getPartnerInSession()->id, $this->cart->getPartnerInSession()->key
                );
            } else {
                $this->cart->calculateDiscountFromPackages();
                $this->cart->calculateDiscountFromCourses();
            }
        }
        return redirect()->route('cart.items');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function complete_profile() {
        return view('frontend.cart.complete-profile');
    }

    public function buyCourse565() {

        if (!isset(auth()->user()->id)) {
            return redirect()->route('cart.auth');
        }

        $course_id = "565";
        $item_id = "565"; //Id do Course
        $type = "course";

        $item = $this->cart->getItemByType($item_id, $type);

        if (!$this->cart->getById($item_id, $type)) {
            $item->price = 399.90;
            $item->discount_price = 199.95;
            $item->special_price = 199.95;

            $this->cart->addItem($item, $type);

            $order = $this->order->findOrThrowException($this->cart->orderInSession);

            $this->cart->setDiscountInSession(0);
            if (isset($order->coupon->code)) {
                $this->buildDiscountFromCoupon($order->coupon->code);
            } else {
                $this->cart->calculateDiscountFromPackages();
                $this->cart->calculateDiscountFromCourses();
            }
        }

        return redirect()->route('cart.items');
    }

    public function buyCourse577() {

        if (!isset(auth()->user()->id)) {
            return redirect()->route('cart.auth');
        }

        $item_id = 577; //Id do Pacote
        $type = "course";

        $item = $this->cart->getItemByType($item_id, $type);

        if (!$this->cart->getById($item_id, $type)) {

            $item->price = 399.90;
            $item->discount_price = 199.95;
            $item->special_price = 199.95;

            $this->cart->addItem($item, $type);

            $order = $this->order->findOrThrowException($this->cart->orderInSession);

            $this->cart->setDiscountInSession(0);
            if (isset($order->coupon->code)) {
                $this->buildDiscountFromCoupon($order->coupon->code);
            } else {
                $this->cart->calculateDiscountFromPackages();
                $this->cart->calculateDiscountFromCourses();
            }
        }

        return redirect()->route('cart.items');
    }

    public function buySaap80() {

        if (!isset(auth()->user()->id)) {
            return redirect()->route('cart.auth');
        }

        $course_id = "375";
        $item_id = "22";
        $type = "package";

        $enrollments = Enrollment::where("course_id", "=", $course_id)->where("student_id", "=", auth()->user()->id);

        if (count($enrollments) == 0) {
            return redirect()->route('home');
        }

        $item = $this->cart->getItemByType($item_id, $type);

        $item->price = 40.00;
        $item->discount_price = 40.00;

        if (!$this->cart->getById($item_id, $type)) {
            $this->cart->addItem($item, $type);

            $order = $this->order->findOrThrowException($this->cart->orderInSession);

            $this->cart->setDiscountInSession(0);
            if (isset($order->coupon->code)) {
                $this->buildDiscountFromCoupon($order->coupon->code);
            } else {
                $this->cart->calculateDiscountFromPackages();
                $this->cart->calculateDiscountFromCourses();
            }
        }

        return redirect()->route('cart.items');
    }

    public function addOabSemParar() {
        $type = 'course';
        $item_id = 375;
        $item = $this->cart->getItemByType($item_id, $type);
        if (!$this->cart->getById($item_id, $type))
            $this->cart->addItem($item, $type);

        $type = 'package';
        $item_id = 22;
        $item = $this->cart->getItemByType($item_id, $type);
        $item->price = 0.00;
        $item->discount_price = 0.00;
        if (!$this->cart->getById($item_id, $type))
            $this->cart->addItem($item, $type);

        $item_id = 5;
        $item = $this->cart->getItemByType($item_id, $type);
        $item->price = 0.00;
        $item->discount_price = 0.00;
        if (!$this->cart->getById($item_id, $type))
            $this->cart->addItem($item, $type);

        $item_id = 11;
        $item = $this->cart->getItemByType($item_id, $type);
        $item->price = 0.00;
        $item->discount_price = 0.00;
        if (!$this->cart->getById($item_id, $type))
            $this->cart->addItem($item, $type);

        $order = $this->order->findOrThrowException($this->cart->orderInSession);

        $this->cart->setDiscountInSession(0);
        if (isset($order->coupon->code)) {
            $this->buildDiscountFromCoupon($order->coupon->code);
        } else {
            $this->cart->calculateDiscountFromPackages();
            $this->cart->calculateDiscountFromCourses();
        }

        //Comprando apenas um item gratuito
        $items = $this->cart->getFullCart();
        if (($items->total <= 0) && (Cart::count() == 4)) {
            return redirect()->route('cart.payment');
        }

        //$request['added'] = '1'; Adhemar code
        return redirect()->route('cart.items');
    }

    /**
     * Discount coupon use
     *
     * @param Request $request
     * @return mixed
     */
    public function discountPartner(Request $request) {
        $partner = $request->get('partner');
        $key = $request->get('key');
        $this->remove_discount(); //Removendo Discontos que existam na session
        $this->buildDiscountFromPartner($partner, $key);

        return redirect()->route('cart.items');
    }

    /**
     * Build discounts processes
     *
     * @param $coupon_code
     * @return mixed
     */
    private function buildDiscountFromPartner($partner_id, $key) {
        $this->cart->destroyDiscount();

        $availability = $this->cart->discountPartner($partner_id, $key);

        if ($availability['available'] == false)
            return redirect()->route('cart.items')->withFlashDanger($availability['message']);

        $discountMontanteCourse = $this->cart->applyPartnerDiscountsCourseItems($partner_id);
        $discountMontantePackage = $this->cart->applyPartnerDiscountsPackageItems($partner_id);
        $discountTotal = $discountMontanteCourse + $discountMontantePackage;
        $this->order->assignPartnerToOrder($partner_id, $this->cart->orderInSession);

        //Atualizando o valor Líquido
        $Order = Order::where('id', '=', $this->cart->orderInSession)->first();
        $Order->discount_price = $Order->price - $discountTotal;
        $Order->save();


        session(['discount' => $discountTotal]);
    }

    public function setSessionId() {

        $credentials = array(
            'email' => config('laravelpagseguro.credentials.email'),
            'token' => config('laravelpagseguro.credentials.token')
        );

        $data = '';
        foreach ($credentials as $key => $value) {
            $data .= $key . '=' . $value . '&';
        }

        $environment = config('laravelpagseguro.use-sandbox');

        $host = ($environment == 'local') ? config('laravelpagseguro.host.sandbox') : config('laravelpagseguro.host.production');


        $data = rtrim($data, '&');
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $host.'/v2/sessions');
        curl_setopt($ch, CURLOPT_POST, count($credentials));
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        if (app()->environment() == 'production') {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        } else {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        }

        $result = curl_exec($ch);


        if (FALSE === $result)
            throw new GeneralException(curl_error($ch) . curl_errno($ch));



        $result = simplexml_load_string(curl_exec($ch));
        curl_close($ch);
        $result = json_decode(json_encode($result));
        Session::put('pagseguro.sessionId', $result->id);
        return $result->id;
    }

    public function getSessionId() {
        return $this->setSessionId();
    }

    public function errorHandling($errors) {

        $error_translated = [];


        Log::info("CART.ERROR_HANDLING");
        Log::info($errors);
        if (isset($errors["code"])) {
            Log::info("CART.ERROR_HANDLING 1");
            Log::info($errors);
            Log::info($errors["code"]);
            array_push($error_translated, $this->pagseguroErrors($errors["code"]));
        } else {
            foreach ($errors as $error) {
                Log::info("CART.ERROR_HANDLING 2");
                Log::info($error["code"]);
                array_push($error_translated, $this->pagseguroErrors($error["code"]));
            }
        }

        Log::info('Cart.TOTAL_ERRORS');
        Log::info($error_translated);


        return redirect()->route('cart.payment')->withErrors($error_translated);
    }

    public function pagseguroErrors($code) {
        $error_translated = "";
        switch ($code) {
            case "5003":
                $error_translated = "Falha de comunicação com a instituição financeira.";
                break;
            case "10003":
                $error_translated = "Código de segurança inválido";
                break;
            case "10006":
                $error_translated = "Código de segurança com comprimento errado";
                break;
            case "10000":
                $error_translated = "Bandeira do cartão de crédito não aceita";
                break;
            case "53043":
                $error_translated = "Usuário do cartão inválido";
                break;
            case "53044":
                $error_translated = "Usuário do cartão inválido";
                break;
            case "53046":
                $error_translated = "Número do CPF inválido";
                break;
            case "53081":
                $error_translated = "Comprador não pode estar associado ao vendedor";
                break;
            case "53084":
                $error_translated = "Receptor inválido: Verifique o estado da conta e se é uma conta de vendedor";
                break;
            case "53087":
                $error_translated = "Dados do cartão de crédito inválido";
                break;
            case "53092":
                $error_translated = "Bandeira do cartão não é aceita";
                break;
            case "53141":
                $error_translated = "Comprador bloqueado";
                break;
            case "53052":
                $error_translated = "Telefone Inválido";
                break;
            default:
                $error_translated = "Erro não identificado. Confira todos os seus dados e tente enviar novamente";
                break;
        };
        return $error_translated;
    }

    public function directSend(Request $request) {

        $pagseguro_data = array();

        $pagseguro_data['reference'] = $this->cart->orderInSession;
        $pagseguro_data['items'] = array();
        $items = $this->cart->getFullCart();
        if ($request['method'] == 'creditCard' && !isset($request['cardToken']))
            return redirect()->back()->withFlashDanger('Não foi possível validar seu cartão. Confira o número informado.');

        $checkout = $this->cart->getCheckoutArray($items, $request)[0];
        $count = $this->cart->getCheckoutArray($items, $_POST)[1];

        $ch = curl_init();

        $environment = config('laravelpagseguro.use-sandbox');

        $host = ($environment == 'local') ? config('laravelpagseguro.host.sandbox') : config('laravelpagseguro.host.production');

        $checkout['senderEmail'] = ($environment == 'local') ?
            explode('@', $checkout['senderEmail'])[0].'@sandbox.pagseguro.com.br' :
            $checkout['senderEmail'];

        curl_setopt($ch, CURLOPT_URL, $host.'/v2/transactions/');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [ 'application/x-www-form-urlencoded; charset=ISO-8859-1']);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($checkout));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        if (app()->environment() == 'production') {
            curl_setopt($ch, CURLUSESSL_TRY, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        } else {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        }

        $result = curl_exec($ch);

        if ($result == 'Unauthorized' || $result == 'Forbidden') {
            throw new GeneralException($result . ': Módulo de Compras em manutenção. Tente novamente dentro de alguns minutos');
        }

        Log::info('Cart.DATA');
        Log::info($pagseguro_data);

        Log::info('Cart.ERROR');
        Log::info($result);

        $result = simplexml_load_string($result);

        Log::info('Cart.STRING');
        Log::info($result);

        $result = json_decode(json_encode($result), true);

        Log::info('Cart.JSON');
        Log::info($result);

        curl_close($ch);

        if (isset($result['error'])) {
            Log::info('Cart.ERROR_TREATMENT');
            return $this->errorHandling($result['error']);
        } else {
            Log::info('Cart.PaymentSuccess');
            if (isset($result['status'])) {
                if ($request['method'] == 'creditCard')
                    return $this->conclusion($request['installmentAmount'] * $request['installments']);
                return $result;
            }
        }
    }

    /**
     * Função para criar registro na tabela attempt_to_register_on_the_cart
     * Criar log das tentativas de cadastro a partir do carrinho
     *
     * */
    public function createAttemptToRegisterOnTheCart() {
        DB::insert(
                "INSERT INTO attempt_to_register_on_the_cart (
                order_id, 
                email, 
                created_at, 
                updated_at
            )
            VALUES (
                " . $this->cart->orderInSession . ", 
                '" . $_POST['email'] . "', 
                '" . date('Y-m-d H:i:s') . "', 
                '" . date('Y-m-d H:i:s') . "'
            )"
        );
        return json_encode('true');
    }

}
