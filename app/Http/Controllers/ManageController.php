<?php

namespace App\Http\Controllers;

use App\Product as AppProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Product;

class ManageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $product_data = AppProduct::all();
        return view('manage')->with('product_data',$product_data);
    }

}
