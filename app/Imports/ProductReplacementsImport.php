<?php

namespace App\Imports;

use App\Http\Controllers\Support\ProductReplacementController;
use App\Product;
use Illuminate\Support\Facades\Log;
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
        // TODO Get headers from the template file to make the app more generic
        $itemFromFile = 'item';
        $replacementFromFile = 'replacement';
        $remarkFromFile = 'remark';

        $row = $row->toArray();


        // Update comment if record exist, or create
        $item = Product::where('item', $row[$itemFromFile])->first();
        // TODO Check if product doesn't exist, insert it to products table and notify that it should be updated with more data
        
        $replacement = Product::where('item', $row[$replacementFromFile])->first();
        // TODO Check if replacement product exist in Products table, otherwise insert..

        // Check if replacement exist in replacement-table
        if ($item->replacements->contains($replacement)) {
            $item->replacements()->updateExistingPivot($replacement, ['comment' => $row[$remarkFromFile]]);
            
        } else {
            $item->replacements()->attach($replacement,['comment' => $row[$remarkFromFile]]);
        }
    }        
}
