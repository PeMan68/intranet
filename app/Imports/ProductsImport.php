<?php

namespace App\Imports;

use App\Product;
use Maatwebsite\Excel\Concerns\ToModel;

use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsErrors;

class ProductsImport implements ToModel
{
    use Importable;
    
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Product([
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
}
