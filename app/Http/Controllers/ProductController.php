<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;
use App\Imports\ProductsImport;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{
    public function index()
	{
		$products = Product::paginate(50);
		return view('products.index',['products' => $products]);
	}
	
	public function importform()
    {
       return view('products.import');
    }
      
    public function import() 
    {
        Product::truncate(); // deletes all rows before inserting new data
		Excel::import(new ProductsImport,request()->file('file'));
		return redirect('/products');
	}
}
