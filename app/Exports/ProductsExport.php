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
        return collect($this->data);
    }

    public function map($product) :array        
    {
        return [
            $product->item,
            $product->item_description_eng,
            $product->item_description_swe,
            $product->transferprice,
            $product->currency,
            $product->listprice,
            $product->group,
            $product->family,
            $product->subfamily,
            $product->safety,
            $product->sourcing,
            $product->status,
            $product->abc,
            $product->ean,
            $product->enummer,
            $product->price_date,   
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
