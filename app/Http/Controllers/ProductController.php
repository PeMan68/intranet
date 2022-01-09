<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->filter) {
        $products = Product::where('item', 'LIKE', '%'.$request->filter.'%' )
            ->get()
            ->map(function($product) {
                return [
                    'Artikel' => $product->item,
                    'E-nummer' => $product->Enummer,
                    'Benämning' => $product->item_description_swe,
                    'Listpris' => $product->listprice,
                    'Uppdaterad' => $product->updated_at,
                    'Ersättningar' => $product->replacements,
                    '_showDetails' => True,
                ];
            });
        $fields = collect([]);
        $fields->push(['key' => 'Artikel']);
        $fields->push(['key' => 'E-nummer']);
        $fields->push(['key' => 'Benämning']);
        $fields->push(['key' => 'Listpris']);
        $fields->push(['key' => 'Uppdaterad']);

		return view('products.index',[
            'products' => $products,
            'fields' => $fields,
            
        ]);
    }
    return;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
