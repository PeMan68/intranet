<?php

namespace App\Http\Controllers\Support;

use App\Http\Controllers\Controller;
use App\Imports\ProductReplacementsImport;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;

class ProductReplacementController extends Controller
{
    public function importReplacementForm()
    {
       return view('support.productReplacements.import');
    }
      
    public function importReplacement() 
    {
		// Store file temporary, HeadingRowImport will delete the file after use
      $file = request()->file('file')->store('tmp');

      //Validate the file headings
      $headings = (new HeadingRowImport)->toArray($file);

      // hardcoded for the moment. Change to validate against uploaded template
      // to make the application more generic
      if ($headings[0][0][0] == 'item' &&
      $headings[0][0][1] == 'replacement' &&
      $headings[0][0][2] == 'remark') {
         Excel::import(new ProductReplacementsImport,$file);
         return redirect('/products');
      }
      
      // If validation of headers failed
      return redirect('/support/importreplacementproducts')->with('message', 'Fel filformat');
	}
}
