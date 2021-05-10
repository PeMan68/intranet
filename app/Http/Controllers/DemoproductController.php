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
        $demoproducts = Demoproduct::with('product', 'location', 'status')->get();
        $selectedproducts = $demoproducts->map(function ( $product ) {
            return [
                'Artikel' => $product->product->item,
                'Beskrivning' => $product->product->item_description_swe,
                'Status' => $product->status->description,
                'Kommentar' => $product->comment,
                'Plats' => $product->location->path(),
                'Testad' => $product->tested,
                'E_nummer' => $product->product->enummer,
                'Orginal_kartong' => $product->original_box,
                'Orginal_dokument' => $product->original_docs,
                'Serienummer' => $product->serial,
                'Inköpsdatum' => $product->invoice_date,
                'Version' => $product->version,
                'Uppdaterad' => $product->updated_at,

            ];
        });
        $fields = collect([]);

        $fields->push(['key'=> 'Info']);
        $fields->push(['key'=> 'Artikel']);
        $fields->push(['key'=> 'Status']);
        $fields->push(['key'=> 'Plats']);
        // $filter = request('filter') ;
        // return view('demoproducts.index', ['products' => $selectedproducts, 'fields' => $fields, 'filter' => $filter]);
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
        $products = Product::limit(50)->get();
        $items = $products->map(function ( $data ) {
            return [
                'id' => $data->id,
                'item' => $data->item,
                'beskr' => $data->item_description_swe,
            ];
        });
        return view('demoproducts.create', [
            'locations' => $locationBreadcrumbList, 
            'products' => Product::all(),
            'statuses' => ProductStatus::all(),
            'items' => $items,
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
        $validatedData['userUpdate_id'] = Auth::id();
        $demoProduct = Demoproduct::create($validatedData);
        return redirect('/demoproducts')->with('message', $demoProduct->product->item . ' registrerad, plats ' . $demoProduct->location->name);
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
