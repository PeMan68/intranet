<?php

namespace App\Http\Controllers\Support;

use App\Http\Controllers\Controller;
use App\Imports\ProductReplacementsImport;
use Maatwebsite\Excel\Facades\Excel;

class ProductReplacementController extends Controller
{
    public function importReplacementForm()
    {
       return view('support.productReplacements.import');
    }
      
    public function importReplacement() 
    {
		$file = request()->file('file');
		Excel::import(new ProductReplacementsImport,$file);
		return redirect('/products');
	}
}
