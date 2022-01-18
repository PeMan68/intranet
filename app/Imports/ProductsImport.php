<?php

namespace App\Imports;

use App\Product;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class ProductsImport implements WithStartRow, OnEachRow, WithChunkReading
{
    use Importable;
    
    public function startRow() : int
    {
        return 2;
    }

    public function onRow(Row $row)
    {
        $row = $row->toArray();
        
        // Update timestamp for price only if price is changed
        $product = Product::where('item', $row[2])->get();
        if (!is_null($product)) {
            // Item exists
            if($row[4] <> $product->listprice) {
                // Price has changed
                $product->update('price_date', now());
            }
        }
        $product = Product::updateOrCreate([
            'item' => $row[2]
        ], [
            'item'                  => $row['Artikel'],
            'item_description_swe'  => $row['Benämning'],
            'transferprice'         => $row['Transferprice'] ?? $row['TP'],
            'currency'              => $row['Valuta'],
            'listprice'             => $row['Listpris'],
            'group'                 => $row['PG'],
            'family'                => $row['Familj'] ?? $row['FAM'],
            'subfamily'             => $row['Subfamilj'] ?? $row['SUB'],
            'safety'                => $row['Safety'],
            'sourcing'              => $row['Sourcing'],
            'status'                => $row['Status'],
            'abc'                   => $row['ABC'],
            'ean'                   => $row['ean'],
            'enummer'               => $row['enummer'] ?? $row['E-nummer'],
        ]);
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
