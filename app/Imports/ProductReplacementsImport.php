<?php

namespace App\Imports;

use App\Http\Controllers\Support\ProductReplacementController;
use App\Product;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Row;

class ProductReplacementsImport implements WithStartRow, OnEachRow, WithChunkReading, WithHeadingRow
{

    use Importable;

    public function startRow() :int
    {
        return 2;
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    public function onRow(Row $row)
    {
        $itemFromFile = 'item';
        $replacementFromFile = 'replacement';
        $remarkFromFile = 'remark';

        $row = $row->toArray();

        // Check columns
        if (is_null($row[$itemFromFile] ?? null)) {
            //! Return with error message, fix!
            return redirect()->action([ProductReplacementController::class, 'importReplacementForm'])->with('danger', 'Kolumnen ' . $item . ' saknas');
        }
        if (is_null($row[$replacementFromFile] ?? null)) {
            //! Return with error message, fix!
            return;
        }
        if (is_null($row[$remarkFromFile] ?? null)) {
            //! Return with error message, fix!
            return;
        }

        // Update comment if record exist, or create
        $item = Product::where('item', $row[$itemFromFile])->first();
        $replacement = Product::where('item', $row[$replacementFromFile])->first();
        // If product doesn't exist, insert it to products table and notify that it should be updated with more data
        // Check if replacement product exist in Products table, otherwise insert..

        // Check if replacement exist in replacement-table
        if ($item->replacements->contains($replacement)) {
            $item->replacements()->updateExistingPivot($replacement, ['comment' => $row[$remarkFromFile]]);
            
        } else {
            $item->replacements()->attach($replacement,['comment' => $row[$remarkFromFile]]);
            // $item->replacements()->updateExistingPivot($item, ['comment' => $row[$remarkFromFile]]);
            // dd ($item->item . ' tillagd');
        }
    }        
}
