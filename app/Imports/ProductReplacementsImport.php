<?php

namespace App\Imports;

use App\Product;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Row;

class ProductReplacementsImport implements WithStartRow, OnEachRow, WithChunkReading, WithHeadingRow
{

    use Importable;


    public function startRow(): int
    {
        return 2;
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    public function onRow(Row $row)
    {
        // TODO Get headers from the template file to make the app more generic
        static $itemFromFile = 'item';
        static $replacementFromFile = 'replacement';
        static $remarkFromFile = 'remark';

        $rowIndex = $row->getIndex();
        $row = $row->toArray();
        $okToImport = true;

        // Search for item in the product-table
        $item = Product::where('item', $row[$itemFromFile])->first();
        // If product doesn't exist, add it to session array
        if (is_null($item)) {
            Session::push('missingItems', [
                'rad' => $rowIndex,
                'item' => $row[$itemFromFile],
            ]);
            Session::push('productsToImport', [
                'item' => $row[$itemFromFile],
            ]);
            $okToImport = false;
        }
        // Search for item in the product-table
        $replacement = Product::where('item', $row[$replacementFromFile])->first();
        // If replacement product doesn't exist, add it to session array
        if (is_null($replacement)) {
            Session::push('missingItems', [
                'rad' => $rowIndex,
                'item' => $row[$replacementFromFile],
            ]);
            Session::push('productsToImport', [
                'item' => $row[$replacementFromFile],
            ]);
            $okToImport = false;
        }

        if ($okToImport) {
            // Upsert replacement
            if ($item->replacements->contains($replacement)) {
                $item->replacements()->updateExistingPivot($replacement, ['comment' => $row[$remarkFromFile]]);
            } else {
                $item->replacements()->attach($replacement, ['comment' => $row[$remarkFromFile]]);
            }
            Session::increment('numberOfImportedItems');
        } else {
            // Store missing products so they can be saved for another import 
            // after products have been imported to product database
            Session::push('replacementsToImport', [
                'item' => $row[$itemFromFile],
                'replacement' => $row[$replacementFromFile],
                'remark' => $row[$remarkFromFile],
            ]);
        }
    }
}
