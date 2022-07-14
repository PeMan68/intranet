<?php

namespace App\Http\Controllers\Support;

use App\Exports\ProductsExport;
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
       return view('support.products.import');
    }
      
    public function import() 
    {
		$file = request()->file('file');
		Excel::import(new ProductsImport,$file);
		return redirect('/products');
	}

	public function export()
	{
		return Excel::download(new ProductsExport(Product::all()), 'Produkter_alla.xlsx');
	}
	
	public function template()
	{
		return Excel::download(new ProductsExport, 'Produkter_mall.xlsx');
	}
}
