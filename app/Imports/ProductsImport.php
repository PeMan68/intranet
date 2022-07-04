<?php



// Kolla vilka kolumner som finns i excelfilen
// lagra de som matchar i en array
// uppdatera endast de kolumner som är representerade i filen
// Om priset ändrats, uppdatera datum-fältet för prisuppdateringen
//! Meddela vilka kolumner som importerats och hur många records som uppdaterats eller nya

namespace App\Imports;

use App\Product;
use Illuminate\Support\Arr;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImport implements WithStartRow, OnEachRow, WithChunkReading, WithHeadingRow
{
    use Importable;
    
    public function startRow() : int
    {
        return 2;
    }

    public function onRow(Row $row)
    {
        $row = $row->toArray();
        
        // Add recognized columns to array that will be updated/imported
        $fields=[];
        if (!is_null($row['artikel_nr'] ?? null)){
            $fields = Arr::add($fields,'item', $row['artikel_nr']) ;
        } else {
            // no item in file
            return redirect('/admin/importproducts')->with('message','Kolumn med artikel ska heta Artikel nr');
        }
        if (!is_null($row['benamning'] ?? null)){
            $fields = Arr::add($fields,'item_description_swe', $row['benamning']) ;
        }
        if (!is_null($row['transferprice'] ?? $row['TP'] ?? null)){
            $fields = Arr::add($fields, 'transferprice', $row['transferprice'] ?? $row['TP']) ;
        }
        if (!is_null($row['pg'] ?? $row['prodgrp'] ?? null)){
            $fields = Arr::add($fields, 'group',$row['pg'] ?? $row['prodgrp']) ;
        }
        if (!is_null($row['listpris'] ?? null)){
            if(!$row['listpris'] == 0 ){
                $fields = Arr::add($fields, 'listprice',$row['listpris'] ) ;
                $fields = Arr::add($fields, 'price_date',now() ) ;
            }
        }
        if (!is_null($row['enummer'] ?? $row['e_nummer'] ?? null)){
            $fields = Arr::add($fields, 'enummer',$row['enummer'] ?? $row['e_nummer']) ;
        }

        $product = Product::updateOrCreate([
            'item' => $row['artikel_nr']
        ], $fields);
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
