<?php

namespace App\Http\Controllers;

use App\Demoproduct;
use App\Location;
use App\Product;
use App\ProductStatus;
use Illuminate\Http\Request;
use App\Http\Requests\StoreDemoproduct;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
// use Arr;

class DemoproductController extends Controller
{
    /**
     * Recursively populate array with all children
     * 
     * @param \App\Location $location
     * @param mixed $path
     * @param mixed &$locationBreadcrumbList
     * @return void 
     */
    private function findChildren(Location $location, $path, &$locationBreadcrumbList)
    {
        $id = $location->id;
        foreach ($location->childrenLocations as $children) {
            $oldPath = $path;
            $oldId = $id;
            $path .= ' > ' . $children->name;
            $this->findChildren($children, $path, $locationBreadcrumbList);
            $path = $oldPath;
            $id = $oldId;
        }
        $locationBreadcrumbList->push(['name' => $path, 'id' => $id]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $demoproducts = Demoproduct::select('comment', 'product_id', 'location_id', 'status_id', )
        // $demoproducts = Demoproduct::with('product:id,item,item_description_swe', 'location', 'status')->get();
        $demoproducts = Demoproduct::with('product', 'location', 'status')->get();
        $selectedproducts = $demoproducts->map(function ( $product ) {
            return [
                'Artikel' => $product->product->item,
                //'Beskrivning' => $product->product->item_description_swe,
                'Status' => $product->status->description,
                'Kommentar' => $product->comment,
                'Plats' => $product->location->path(),
                //'Testad' => $product->tested,
                //'E-nummer' => $product->product->enummer,
            ];
        });
        $fields = collect($selectedproducts->first())->keys();
        $fields->transform(function ($item){
            return [
                'key' => $item,
                'sortable' => true,
            ];
        }); 
        return view('demoproducts.index', ['products' => $selectedproducts, 'fields' => $fields]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $locations = Location::whereNull('location_id')
        ->get();
        $locationBreadcrumbList = collect([]);
        foreach ($locations as $parent) {
            $place = $parent->name;
            $this->findChildren($parent, $place, $locationBreadcrumbList);
        }
        $locationBreadcrumbList = collect($locationBreadcrumbList)->sortBy('name');
        $products = Product::all();
        return view('demoproducts.create')->with([
            'locations' => $locationBreadcrumbList, 
            'products' => Product::all(),
            'statuses' => ProductStatus::all(),
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDemoproduct $request)
    {
        $validatedData = $request->validated();
        $validatedData['userCreate_id'] = Auth::id();
        $demoProduct = Demoproduct::create($validatedData);
        return redirect('/demoproducts')->with('success', $demoProduct->product->item . ' registrerad, plats ' . $demoProduct->location->name);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Demoproduct  $demoproduct
     * @return \Illuminate\Http\Response
     */
    public function show(Demoproduct $demoproduct)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Demoproduct  $demoproduct
     * @return \Illuminate\Http\Response
     */
    public function edit(Demoproduct $demoproduct)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Demoproduct  $demoproduct
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Demoproduct $demoproduct)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Demoproduct  $demoproduct
     * @return \Illuminate\Http\Response
     */
    public function destroy(Demoproduct $demoproduct)
    {
        //
    }
}
