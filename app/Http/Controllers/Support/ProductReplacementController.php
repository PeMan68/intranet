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
      return view('support.productReplacements.import');
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
      
      Excel::import(new ProductReplacementsImport, $file);
      Storage::deleteDirectory($tmpDir);
      

      // ! Funkar inte att skicka med data om vilka produkter som saknas!
      if (Session::has('missingItems')) {
         $missingItems = Session::get('missingItems');
         Log::info('Importen hade missing items');
         return redirect('/support/importreplacementproducts')
         ->with('warning', 'VARNING! En del produkter kunde inte importeras. De måste importeras till Produkter först');
      } else {
         Log::info('Importen hade INGA missing items');
         return redirect('/support/importreplacementproducts')->with('success', 'OK! Alla produkter uppdaterade');
      }
   }
}
