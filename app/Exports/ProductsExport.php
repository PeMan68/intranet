<?php

namespace App\Exports;

use App\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductsExport implements FromCollection, ShouldAutoSize, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Product::all();
    }

    public function headings(): array
    {
        return [
            'id',
            'created_at',
            'updated_at',
            'item',
            'item_description_eng',
            'item_description_swe',
            'transferprice',
            'currency',
            'listprice',
            'group',
            'family',
            'subfamily',
            'safety',
            'sourcing',
            'status',
            'abc',
            'ean',
            'enummer',
            'price_date',

        ];
    }
}
