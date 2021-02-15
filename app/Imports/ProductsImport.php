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

        $product = Product::updateOrCreate([
            'item' => $row[2]
        ], [
            'item'                  => $row[2],
            'item_description_swe'  => $row[3],
            'transferprice'         => $row[5],
            'currency'              => $row[6],
            'listprice'             => $row[4],
            'group'                 => $row[1],
            'family'                => $row[10],
            'subfamily'             => $row[11],
            'safety'                => $row[7],
            'sourcing'              => $row[17],
            'status'                => $row[18],
            'abc'                   => $row[0],
            'ean'                   => $row[9],
            'enummer'               => $row[12],
        ]);
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
