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
        if (!is_null($row['artikel_nr'] ?? $row['item'] ?? null)){
            $fields = Arr::add($fields,'item', $row['artikel_nr'] ?? $row['item']) ;
        } else {
            // no item in file
            return redirect('/admin/importproducts')->with('message','Kolumn med artikel ska heta Artikel nr eller item');
        }
        if (!is_null($row['item_description_eng'] ?? null)){
            $fields = Arr::add($fields,'item_description_eng', $row['item_description_eng']) ;
        }
        if (!is_null($row['benamning'] ?? $row['item_description_swe'] ?? null)){
            $fields = Arr::add($fields,'item_description_swe', $row['benamning'] ?? $row['item_description_swe']) ;
        }
        if (!is_null($row['transferprice'] ?? $row['TP'] ?? null)){
            $fields = Arr::add($fields, 'transferprice', $row['transferprice'] ?? $row['TP']) ;
        }
        if (!is_null($row['currency'] ?? null)){
            $fields = Arr::add($fields,'currency', $row['currency']) ;
        }
        if (!is_null($row['pg'] ?? $row['prodgrp'] ?? $row['group'] ?? null)){
            $fields = Arr::add($fields, 'group',$row['pg'] ?? $row['prodgrp'] ?? $row['group']) ;
        }
        if (!is_null($row['family'] ?? null)){
            $fields = Arr::add($fields,'family', $row['family']) ;
        }
        if (!is_null($row['subfamily'] ?? null)){
            $fields = Arr::add($fields,'subfamily', $row['subfamily']) ;
        }
        if (!is_null($row['safety'] ?? null)){
            $fields = Arr::add($fields,'safety', $row['safety']) ;
        }
        if (!is_null($row['sourcing'] ?? null)){
            $fields = Arr::add($fields,'sourcing', $row['sourcing']) ;
        }
        if (!is_null($row['status'] ?? null)){
            $fields = Arr::add($fields,'status', $row['status']) ;
        }
        if (!is_null($row['abc'] ?? null)){
            $fields = Arr::add($fields,'abc', $row['abc']) ;
        }
        if (!is_null($row['ean'] ?? null)){
            $fields = Arr::add($fields,'ean', $row['ean']) ;
        }
        if (!is_null($row['listpris'] ?? $row['listprice'] ?? null)){
            if(!(!is_null($row['listpris'] ?? $row['listprice'] ?? null)) == 0){
                $fields = Arr::add($fields, 'listprice',$row['listpris'] ?? $row['listprice']) ;
                $fields = Arr::add($fields, 'price_date',now() ) ;
            }
        }
        if (!is_null($row['enummer'] ?? $row['e_nummer'] ?? null)){
            $fields = Arr::add($fields, 'enummer',$row['enummer'] ?? $row['e_nummer']) ;
        }

        $product = Product::updateOrCreate([
            'item' => $row['artikel_nr'] ?? $row['item']
        ], $fields);
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
