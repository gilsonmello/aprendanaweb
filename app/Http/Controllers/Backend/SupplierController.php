<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Requests\Backend\Supplier\CreateSupplierRequest;
use App\Http\Requests\Backend\Supplier\UpdateSupplierRequest;
use App\Repositories\Backend\Supplier\SupplierContract;
use App\Http\Controllers\Controller;

class SupplierController extends Controller {

    /**
     * 
     * @param SupplierContract $supplier
     */
    public function __construct(SupplierContract $supplier) {
        $this->supplier = $supplier;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $request->session()->put('lastpage', $request->only('page')['page']);

        $f_submit = $request->input('f_submit', '');

        //$f_NewsController_title = get_parameter_or_session( $request, 'f_NewsController_title', '', $f_submit, '' );


        return view('backend.suppliers.index')
                        ->withSuppliers($this->supplier->getAllSuppliersPaginated(config('access.users.default_per_page')));
        //->withNews($this->news->getAllNewsPaginated(config('access.users.default_per_page'), 'id', 'desc', $f_NewsController_title))
        //->withNewscontrollertitle($f_NewsController_title);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('backend.suppliers.create')
                        ->withCities($this->supplier->getAllCities())
                        ->withStates($this->supplier->getAllStates())
                        ->withCountries($this->supplier->getAllCountries());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateSupplierRequest $request) {
        $supplier = $this->supplier->create($request->all());

        if ($supplier) {
            return redirect()->route('admin.suppliers.index', [
                        'page' => $request->session()->get('lastpage', '1')
                    ])->withFlashSuccess(trans("alerts.suppliers.created"));
        }

        return redirect()->route('admin.suppliers.index', [
                    'page' => $request->session()->get('lastpage', '1')
                ])->withFlashDanger(trans("alerts.suppliers.created_error"));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $supplier = $this->supplier->findOrThrowException($id, true);
        return view('backend.suppliers.edit')
                        ->withSupplier($supplier)
                        ->withCities($this->supplier->getAllCities())
                        ->withStates($this->supplier->getAllStates())
                        ->withCountries($this->supplier->getAllCountries());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSupplierRequest $request, $id) {
        $supplier = $this->supplier->update($id, $request->all());

        if ($supplier) {
            return redirect()->route('admin.suppliers.index', [
                        'page' => $request->session()->get('lastpage', '1')
                    ])->withFlashSuccess(trans("alerts.suppliers.updated"));
        }

        return redirect()->route('admin.suppliers.index', [
                    'page' => $request->session()->get('lastpage', '1')
                ])->withFlashDanger(trans("alerts.suppliers.updated_error"));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $result = $this->supplier->destroy($id);
        if ($result) {
            return redirect()->route('admin.suppliers.index')->withFlashSuccess(trans("alerts.suppliers.deleted"));
        }
        return redirect()->route('admin.suppliers.index')->withFlashDanger(trans("alerts.suppliers.deleted"));
    }

}
