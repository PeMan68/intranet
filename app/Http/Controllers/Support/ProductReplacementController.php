<?php

namespace App\Http\Controllers\Support;

use App\Exports\ProductsExport;
use App\Exports\ReplacementProductsMissingExport;
use App\Http\Controllers\Controller;
use App\Imports\ProductReplacementsImport;
use App\Imports\ProductsImport;
use Illuminate\Http\Request;
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

   /**
    * Import data from Excelfile
    *
    * @param Request $request
    * @return void
    */
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
         return redirect()->route('support.replacement.importform')->with('danger', 'FEL! Fel fil, kolumnrubrikerna stämmer inte. Använd mallen.');
      }

      // Clear session-variable before import
      Session::forget('missingItems');
      Session::forget('numberOfImportedItems');
      Session::forget('productsToImport');
      Session::forget('replacementsToImport');

      Excel::import(new ProductReplacementsImport, $file);
      Storage::deleteDirectory($tmpDir);

      return redirect()->route('support.replacement.result');
   }

   public function missing()
   {
      return Excel::download(new ReplacementProductsMissingExport(session('replacementsToImport')), 'Ersättningsprodukter_saknade.xlsx');
   }

   public function create_product_file()
   {
      // dd(session('productsToImport'));

      return Excel::download(new ProductsExport(session('productsToImport')), 'Produkter_att_importera.xlsx');
   }

   public function template()
   {
      return Excel::download(new ReplacementProductsMissingExport, 'Ersättningsprodukter mall.xlsx');
   }
}
