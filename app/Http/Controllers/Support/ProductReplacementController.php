<?php

namespace App\Http\Controllers\Support;

use App\Http\Controllers\Controller;
use App\Imports\ProductReplacementsImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\HeadingRowImport;

class ProductReplacementController extends Controller
{
   public function importReplacementForm()
   {
      return view('support.productreplacements.import');
   }

   public function importresult()
   {
      return view('support.productreplacements.result');
   }

   public function importReplacement(Request $request)
   {
      $request->validate([
         'file' => 'mimes:xlsx|max:1024'
      ]);

      //Temporary directory created to store file and destroyed afterwards
      $tmpDir = 'tmp';

      // Store file temporary, HeadingRowImport will delete the file after use
      $file = request()->file('file')->store($tmpDir);

      //Validate the file headings
      $headings = (new HeadingRowImport)->toArray($file);

      // TODO hardcoded for the moment. Change to validate against uploaded template
      // to make the application more generic
      if (
         $headings[0][0][0] != 'item' |
         $headings[0][0][1] != 'replacement' |
         $headings[0][0][2] != 'remark'
      ) {
         // If validation of headers failed
         Storage::deleteDirectory($tmpDir);
         return redirect('/support/importreplacementproducts')->with('danger', 'FEL! Fel fil, kolumnrubrikerna stämmer inte. Använd mallen.');
      }

      // Clear session-variable before import
      Session::forget('missingItems');
      Session::forget('importedItems');

      Excel::import(new ProductReplacementsImport, $file);
      Storage::deleteDirectory($tmpDir);

      if (Session::has('missingItems')) {
         return redirect('/support/importreplacementproductsresult');
      } else {
         return redirect('/support/importreplacementproductsresult')->with('success', 'OK! Alla produkter uppdaterade');
      }
   }
}
