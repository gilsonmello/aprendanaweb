<?php
/**
 * Created by PhpStorm.
 * User: geofrey19
 * Date: 22/09/15
 * Time: 16:38
 */

namespace App\Http\Controllers\Backend;


use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\RepresentativeCommission\CreateRepresentativeCommissionRequest;
use App\Http\Requests\Backend\RepresentativeCommission\UpdateRepresentativeCommissionRequest;
use App\Repositories\Backend\RepresentativeCommission\RepresentativeCommissionContract;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Commands\importPartnerCommand;
use FPDI;

class RepresentativeCommissionController extends Controller {
    
    /**
     * @param RepresentativeCommissionContract $representativecommissions
     */
    public function __construct(RepresentativeCommissionContract $representativecommissions) {
        $this->representativecommissions = $representativecommissions;

    }

    /**
     * @return mixed
     */
    public function index(Request $request) {
        $request->session()->put('lastpage', $request->only('page')['page']);

        $f_submit = $request->input('f_submit', '');

        $f_RepresentativeCommissionController_id = get_parameter_or_session( $request, 'f_RepresentativeCommissionController_id', '', $f_submit, '' );

        return view('backend.representativecommissions.index')
            ->withRepresentativeCommissions($this->representativecommissions->getRepresentativeCommissionsRepresentative( $f_RepresentativeCommissionController_id))
            ->withRepresentativecommissioncontrollerid($f_RepresentativeCommissionController_id);
    }
    
    /**
     * @return mixed
     */
    public function create() {
        return view('backend.representativecommissions.create');
    }

    /**
     * @param CreateRepresentativeCommissionRequest $request
     * @return mixed
     */
    public function store(CreateRepresentativeCommissionRequest $request) {
        $this->representativecommissions->create($request);
        return redirect()->route('admin.representativecommissions.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.representativecommissions.created"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function edit($id) {
        $representativecommission = $this->representativecommissions->findOrThrowException($id, true);
        return view('backend.representativecommissions.edit')->withRepresentativeCommission($representativecommission);
    }

    /**
     * @param $id
     * @param UpdateRepresentativeCommissionRequest $request
     * @return mixed
     */
    public function update($id, UpdateRepresentativeCommissionRequest $request) {
        $this->representativecommissions->update($id, $request->except(['students','courses','modules']), $request->only('students'),
            $request->only('courses'),$request->only('modules'));
        return redirect()->route('admin.representativecommissions.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.representativecommissions.updated"));
    }

    /**
     * @param $id
     * @return mixed
     */
    public function destroy($id) {
        $this->representativecommissions->destroy($id);
        return redirect()->back()->withFlashSuccess(trans("alerts.representativecommissions.deleted"));
    }




}