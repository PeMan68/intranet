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
        $selectedProducts =  Product::where('item', 'LIKE', '%'.$request->filter.'%' )->get();   
        $products =$selectedProducts
            ->map(function($product) {
                
                return [
                    'ID' => $product->id,
                    'Artikel' => $product->item,
                    'Enummer' => $product->Enummer,
                    'Benämning' => $product->item_description_swe,
                    'Listpris' => $product->listprice,
                    'Uppdaterad' => date('y-m-d', strtotime($product->updated_at)),
                    'Ersättningar' => $product->replacements,
                    'Antal_i_demo' => count($product->demoproduct),

                ];
            });

        // foreach ($selectedProducts as $product) {
        //     if ($product->replacements->IsNotEmpty()){
        //         foreach ($product->replacements as $replacement) {
        //             $products->push( [
        //                 'ID' => $replacement->id,
        //                 'Artikel' => $replacement->item,
        //                 'E-nummer' => $replacement->Enummer,
        //                 'Benämning' => $replacement->item_description_swe,
        //                 'Listpris' => $replacement->listprice,
        //                 'Uppdaterad' => $replacement->updated_at,
        //                 'Kommentar' => $replacement->pivot->comment,
        //                 'Ersätter' => $product->id,
        //             ]);
        //         }
        //     }
        // }
        // $products->dd();
        $fields = collect([]);
        $fields->push(['key' => 'Artikel']);
        $fields->push(['key' => 'E-nummer']);
        $fields->push(['key' => 'Benämning']);
        $fields->push(['key' => 'Listpris']);
        $fields->push(['key' => 'Uppdaterad']);
        $fields->push(['key' => 'Kommentar']);

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
        $product = Product::find($id);
        return view('products.show',['product' => $product]);
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
