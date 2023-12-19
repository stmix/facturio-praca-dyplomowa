<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProductStoreRequest;
use App\Models\Product;
use DB;
use Auth;

class ProductsController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index() {
        return view('products');
    }

    public function create() {
        return view('products_create');
    }

    public function store(ProductStoreRequest $request) {
        $validated = $request->validated();
        
        $product=new Product;
        $product->owner_id=Auth::id();
        $product->product_name=$validated["product_name"];
        $product->product_price=$validated["product_price"];
        $product->producent=$validated["producent"];
        if(isset($validated["product_info"])) { $product->product_info=$validated["product_info"]; } else {
            $product->product_info='-';
        }
        
        $product->save();

        return redirect('/products')->with('success', 'Produkt dodany');
    }

    public function show($id)
    {
        // return $id;
        $product = Product::find($id);
        return view('product.show')->with('product',$product);
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();

        return redirect('/products');
    }
}
