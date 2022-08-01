<?php

namespace App\Exports;

use App\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProductsExport implements FromCollection, ShouldAutoSize, WithHeadings, WithMapping
{
    protected $data;

    public function __construct($data = null)
    {
        $this->data = $data;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->data;
    }


    public function map($product) :array        
    {
        return [
            $product->item,
            $product->item_description_eng ?? null,
            $product->item_description_swe ?? null,
            $product->transferprice ?? null,
            $product->currency ?? null,
            $product->listprice ?? null,
            $product->group ?? null,
            $product->family ?? null,
            $product->subfamily ?? null,
            $product->safety ?? null,
            $product->sourcing ?? null,
            $product->status ?? null,
            $product->abc ?? null,
            $product->ean ?? null,
            $product->enummer ?? null,
            $product->price_date ?? null,
        ];
    }

    public function headings(): array
    {
        return [
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
