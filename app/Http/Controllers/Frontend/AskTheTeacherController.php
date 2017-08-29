<?PHP namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Ticket\CreateTicketRequest;
use App\Http\Requests\Backend\TicketMessage\CreateTicketMessageRequest;
use App\Http\Requests\Backend\Ticket\UpdateTicketRequest;
use App\Repositories\Backend\Ticket\TicketContract;
use App\Repositories\Frontend\AskTheTeacher\AskTheTeacherContract;
use Illuminate\Http\Request;
use Carbon\Carbon;
/**
 * Class DashboardController
 * @package App\Http\Controllers\Backend
 */
class AskTheTeacherController extends Controller {

    /**
     * @param TicketContract $tickets
     */
    public function __construct(AskTheTeacherContract $askTheTeachers) {
        $this->askTheTeachers = $askTheTeachers;
    }

    /**
     * @return mixed
     */
    public function index(Request $request) {
        $request->session()->put('lastpage', $request->only('page')['page']);

        return view('frontend.studentarea.asktheteacher.index')
            ->withAsktheteachers($this->askTheTeachers->getAskTheTeachersPerStudent( auth()->id() ) );
    }



}