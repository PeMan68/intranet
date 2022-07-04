<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Product;
use App\Imports\ProductsImport;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{
    public function index()
	{
		$products = Product::paginate(50);
		return view('admin.products.index',['products' => $products]);
	}
	
	public function importform()
    {
       return view('admin.products.import');
    }
      
    public function import() 
    {
		$file = request()->file('file');
		Excel::import(new ProductsImport,$file);
		return redirect('/products');
	}
}
