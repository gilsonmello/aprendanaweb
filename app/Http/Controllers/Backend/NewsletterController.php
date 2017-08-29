<?PHP namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Newsletter\CreateNewsletterRequest;
use App\Http\Requests\Backend\Newsletter\UpdateNewsletterRequest;
use App\Repositories\Backend\Newsletter\NewsletterContract;
use App\Repositories\Backend\User\UserContract;
use Illuminate\Http\Request;
use App\Campaign;

/**
 * Class DashboardController
 * @package App\Http\Controllers\Backend
 */
class NewsletterController extends Controller {

    /**
     * @param NewsletterContract $newsletters
     */
    public function __construct(NewsletterContract $newsletters, UserContract $users) {
        $this->newsletters = $newsletters;
        $this->users = $users;
    }

    /**
     * @return mixed
     */
    public function index(Request $request) {
        $request->session()->put('lastpage', $request->only('page')['page'] );

        $f_submit = $request->input('f_submit', '');

        $f_NewsletterController_name = get_parameter_or_session( $request, 'f_NewsletterController_name', '', $f_submit, '' );

        $f_NewsletterController_campaign_id = get_parameter_or_session( $request, 'f_NewsletterController_campaign_id', '', $f_submit, '' );

        return view('backend.newsletters.index')
            ->withNewsletters($this->newsletters->getNewslettersPaginated(config('access.users.default_per_page'), $f_NewsletterController_name, $f_NewsletterController_campaign_id))
            ->withNewslettercontrollername($f_NewsletterController_name)
            ->withNewslettercontrollercampaignid($f_NewsletterController_campaign_id)
            ->withCampaigns(Campaign::query()->orderBy('name', 'asc')->get());
    }

    public function listNewsletter(Request $request) {
        $campaign = session('f_NewsletterController_campaign_id');
        
        if(!empty($campaign) && isset($campaign)){
            $this->executions_to_csv_download($this->newsletters->getAllNewsletters($campaign));
        }else{
            return view('backend.newsletters.list')
                ->withNewsletters($this->newsletters->getAllNewsletters($campaign))
                ->withUsers($this->users->getUsersNewsletters( ));
        }
    }

    /**
     * @return mixed
     */
    public function create() {
        return view('backend.newsletters.create');
    }

    /**
     * @param CreateNewsletterRequest $request
     * @return mixed
     */
    public function store(CreateNewsletterRequest $request) {
        $this->newsletters->create($request);
        return redirect()->route('admin.newsletters.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.newsletters.created"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit($id) {
        $newsletter = $this->newsletters->findOrThrowException($id, true);
        return view('backend.newsletters.edit')->withNewsletter($newsletter);
    }

    /**
     * @param $id
     * @param UpdateNewsletterRequest $request
     * @return mixed
     */
    public function update($id, UpdateNewsletterRequest $request) {
        $this->newsletters->update($id, $request->all());
        return redirect()->route('admin.newsletters.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.newsletters.updated"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id) {
        $this->newsletters->destroy($id);
        return redirect()->back()->withFlashSuccess(trans("alerts.newsletters.deleted"));
    }
    
     private function executions_to_csv_download($data, $delimiter = ",") {
        // open raw memory as file so no temp files needed, you might run out of memory though
        $f = fopen('php://output', 'w');
        $filename = "usuarios_" . time()  . ".csv";
        fputs($f, $bom =( chr(0xEF) . chr(0xBB) . chr(0xBF) ));
        header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename="'.$filename.'";');

        foreach($data as $result){
            $line = [
                $result->email
            ];
            fputcsv($f, $line, $delimiter);
        }
        fpassthru($f);
    }

}