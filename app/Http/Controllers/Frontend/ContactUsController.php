<?PHP namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\ContactUs\ContactUsRequest;
use App\Repositories\Backend\Sector\SectorContract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

/**
 * Class DashboardControllerapp/Http/Controllers/Backend/VideoController.php:7
 * @package App\Http\Controllers\Backend
 */
class ContactUsController extends Controller {

    /**
     * @param TicketContract $tickets
     */
    public function __construct(SectorContract $sectors) {
        $this->sectors = $sectors;
    }


    /**
     * @return mixed
     */
    public function index() {

        if (isset(auth()->user()->id)) {
            return view('frontend.studentarea.tickets.create')
                ->withSector($this->sectors->getAllSectorsNoUsers());
        }

        return view('frontend.contactus.index')
            ->withSector($this->sectors->getAllSectorsNoUsers());
    }

    /**
     * @param $id
     * @return mixed
     */
    public function send(ContactUsRequest $request) {

        $this->answered($request);



        return redirect()->back()->withFlashSuccess(trans("alerts.contactus.send"));
    }

    public function answered($input){

        $sector= $this->sectors->findOrThrowException($input['sectors'][0]);

        $users =$sector->users()->get(["name","email"]);

        $emailFrom = $input['email'];
        $nameFrom = $input['name'];

            Mail::send('emails.contact_us', ['from_name' => $nameFrom,
            'from_email' => $emailFrom,
            'sector' => $sector->name,
            'reply_message' => $input['message']
        ], function($message) use ($sector,$users, $emailFrom, $nameFrom )
        {
            foreach($users as $user){
                $message->to($user->email, $user->name);
                $message->replyTo($emailFrom, $nameFrom);
            }
            $message->subject(app_name() . ': ' . 'Fale Conosco');
       });

        return true;

        throw new GeneralException('There was a problem send this mail. Please try again.');
    }

}