<?PHP namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Ticket\CreateTicketRequest;
use App\Http\Requests\Backend\TicketMessage\CreateTicketMessageRequest;
use App\Http\Requests\Backend\Ticket\UpdateTicketRequest;
use App\Repositories\Backend\Ticket\TicketContract;
use App\Repositories\Backend\TicketMessage\TicketMessageContract;
use App\Repositories\Backend\User\UserContract;
use App\Repositories\Backend\Sector\SectorContract;
use Illuminate\Http\Request;
use Carbon\Carbon;
/**
 * Class DashboardController
 * @package App\Http\Controllers\Backend
 */
class TicketStudentController extends Controller {

    /**
     * @param TicketContract $tickets
     */
    public function __construct(TicketContract $tickets, TicketMessageContract $ticketMessage, SectorContract $sectors) {
        $this->tickets = $tickets;
        $this->ticketMessage = $ticketMessage;
        $this->sectors = $sectors;

    }

    /**
     * @return mixed
     */
    public function index(Request $request) {
        $request->session()->put('lastpage', $request->only('page')['page']);

        return view('frontend.studentarea.tickets.index')
            ->withTickets($this->tickets->getTicketsStudentPaginated(config('access.users.default_per_page'), auth()->id()))
            ->withTicketcontrolleruserid(auth()->id());
    }

    public function listTicket() {
        return view('backend.studentarea.tickets.list')
            ->withTickets($this->tickets->getAllTickets( ))
            ->withUsers($this->users->getUsersTickets( ));
    }

    /**
     * @return mixed
     */
    public function create() {
        return view('frontend.studentarea.tickets.create')
            ->withSector($this->sectors->getAllSectorsNoUsers());
    }

    /**
     * @param CreateTicketRequest $request
     * @return mixed
     */
    public function store(CreateTicketRequest $request) {
        $this->tickets->create($request);

        return redirect()->route('student.ticketstudents.index')->withFlashSuccess(trans("alerts.tickets.created"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit($id) {
        $ticket = $this->tickets->findOrThrowException($id, true);

        $messages = $this->ticketMessage->getAllTicketMessages($ticket->id, 'id', 'desc');

        return view('frontend.studentarea.tickets.edit')
            ->withTicket($ticket)
            ->withMessages($messages);
    }

    /**
     * @param $id
     * @param UpdateTicketRequest $request
     * @return mixed
     */
    public function update($id, UpdateTicketRequest $request) {
        $this->tickets->update($id, $request->all());
        return redirect()->route('student.ticketstudents.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.tickets.updated"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id) {
        $this->tickets->destroy($id);
        return redirect()->back()->withFlashSuccess(trans("alerts.tickets.deleted"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function messageDestroy($id) {
        $this->ticketMessage->destroy($id);
        return redirect()->back()->withFlashSuccess(trans("alerts.tickets.deleted"));
    }

    /**
     * @param CreateTicketRequest $request
     * @return mixed
     */
    public function messageStore(CreateTicketMessageRequest $request) {
        $ticketMessage = $this->ticketMessage->create($request);
        if ($ticketMessage != null){
            $this->tickets->notAnswered($request, $ticketMessage);
        }
        return redirect()->back()->withFlashSuccess(trans("alerts.tickets.message_replied"));
    }

}