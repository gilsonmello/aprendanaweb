<?PHP namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Order\CreateOrderRequest;
use App\Http\Requests\Backend\OrderMessage\CreateOrderMessageRequest;
use App\Http\Requests\Backend\Order\UpdateOrderRequest;
use App\Repositories\Backend\Order\OrderContract;
use App\Repositories\Backend\OrderMessage\OrderMessageContract;
use App\Repositories\Backend\User\UserContract;
use App\Repositories\Backend\Sector\SectorContract;
use Illuminate\Http\Request;
use Carbon\Carbon;
/**
 * Class DashboardController
 * @package App\Http\Controllers\Backend
 */
class OrderStudentController extends Controller {

    /**
     * @param OrderContract $orders
     */
    public function __construct(OrderContract $orders) {
        $this->orders = $orders;
    }

    /**
     * @return mixed
     */
    public function index(Request $request) {
        $request->session()->put('lastpage', $request->only('page')['page']);

        return view('frontend.studentarea.orders.index')
            ->withOrders($this->orders->getOrdersStudent( auth()->id()))
            ->withOrdercontrolleruserid(auth()->id());
    }

    /**
     * @return mixed
     */
    public function create() {
        return view('frontend.orders.create');
    }

    /**
     * @param CreateOrderRequest $request
     * @return mixed
     */
    public function store(CreateOrderRequest $request) {
        $this->orders->create($request);

        return redirect()->route('orderstudents.index')->withFlashSuccess(trans("alerts.orders.created"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit($id) {
        $order = $this->orders->findOrThrowException($id, true);

        $messages = $this->orderMessage->getAllOrderMessages($order->id);

        return view('frontend.orders.edit')
            ->withOrder($order)
            ->withMessages($messages);
    }

    /**
     * @param $id
     * @param UpdateOrderRequest $request
     * @return mixed
     */
    public function update($id, UpdateOrderRequest $request) {
        $this->orders->update($id, $request->all());
        return redirect()->route('orderstudents.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.orders.updated"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id) {
        $this->orders->destroy($id);
        return redirect()->back()->withFlashSuccess(trans("alerts.orders.deleted"));
    }

}