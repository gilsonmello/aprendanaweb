<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Repositories\Backend\Product\ProductContract;
use App\Http\Requests\Backend\Product\CreateProductRequest;
use App\Http\Requests\Backend\Product\UpdateProductRequest;

class ProductController extends Controller {

    /**
     *
     * @param ProductContract $product
     * */
    public function __construct(ProductContract $product) {
        $this->product = $product;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        return view('backend.products.index')
        ->withProducts($this->product->getProductsPaginated(config('access.users.default_per_page')));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('backend.products.create')
            ->withSuppliers($this->product->getAllSuppliers());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateProductRequest $request) {
        //dd($request->all());
        $product = $this->product->create($request->all());

        if ($product) {
            return redirect()->route('admin.products.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashSuccess(trans("alerts.products.created"));
        }
        return redirect()->route('admin.products.index', ['page' => $request->session()->get('lastpage', '1')])->withFlashDanger(trans("alerts.products.created"));
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
        return view('backend.products.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        //
    }

}
