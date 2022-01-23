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
    
        return view('products.index');
    }

    public function search(Request $request)
    {
        if (!is_null($request->filter)) {
            $selectedProducts =  Product::where('item', 'LIKE', '%' . $request->filter . '%')
                ->orWhere('item_description_swe', 'LIKE', '%' . $request->filter . '%')    
                ->orWhere('enummer', $request->filter)
                ->get();

            if (count($selectedProducts) == 1) {
                // One item only
                return view('products.show', ['product' => $selectedProducts[0]]);
            }

            $products = $selectedProducts
                ->map(function ($product) {

                    return [
                        'ID' => $product->id,
                        'Artikel' => $product->item,
                        'E_nummer' => $product->enummer,
                        'Benämning' => $product->item_description_swe,
                        'Listpris' => formatPrice($product->listprice),
                        'Uppdaterad' => formatPriceDate($product),
                        'Ersättningar' => $product->replacements,
                        'Antal_i_demo' => count($product->demoproduct),

                    ];
                });

            $fields = collect([]);
            $fields->push(['key' => 'Artikel']);
            $fields->push(['key' => 'E-nummer']);
            $fields->push(['key' => 'Benämning']);
            $fields->push(['key' => 'Listpris']);
            $fields->push(['key' => 'Uppdaterad']);
            $fields->push(['key' => 'Kommentar']);

            return view('products.overview', [
                'products' => $products,
                'fields' => $fields,

            ]);
        } else {
            return view('products.index');
        }
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
        $product = Product::find($id);
        return view('products.show', ['product' => $product]);
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
