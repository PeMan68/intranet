<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Post;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();
        $posts = $posts->map(function($data)
        {
            return [
                'Grupp'     => $data->group,
                'Rubrik'    => $data->header,
                'Kapitel'   => $data->chapter,
                'Datum'     => $data->date,
                'Text'      => $data->text,
                'Image'     => $data->image_ref,
                'Internal'  => $data->internal,
                'Exported'  => $data->exported,
            ];
        });
        $fields = collect([]);
        $fields->push(['key'=>'Visa']);
        $fields->push(['key'=>'.']);
        $fields->push(['key'=>'Grupp', 'sortable' => true]);
        $fields->push(['key'=>'Rubrik', 'sortable' => true]);
        $fields->push(['key'=>'Kapitel']);

        return view('posts.index', ['posts' => $posts, 'fields' => $fields]);
    }
}
