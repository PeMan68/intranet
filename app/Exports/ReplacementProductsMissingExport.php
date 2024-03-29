<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ReplacementProductsMissingExport implements FromCollection, WithHeadings
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

    public function headings(): array
    {
        return [
            'item',
            'replacement',
            'remark',
        ];
    }
}
