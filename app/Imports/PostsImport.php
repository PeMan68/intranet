<?php

namespace App\Imports;

use App\Post;
use Maatwebsite\Excel\Concerns\ToModel;

class PostsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Post([
            'id'        => $row[0],
            'header'    => $row[2],
            'chapter'   => $row[3],
            'updated_at'=> $row[4],
            'created_at'=> $row[4],
            'text'      => $row[5],
            'image_ref' => $row[6],
        ]);
    }
}
