<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Imports\ProductPriceUpdate;
use App\Product;
use App\Imports\ProductsImport;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;

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
