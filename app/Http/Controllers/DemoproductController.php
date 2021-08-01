<?php

namespace App\Http\Controllers;

use App\Demoproduct;
use App\Location;
use App\Product;
use App\ProductStatus;
use Illuminate\Http\Request;
use App\Http\Requests\StoreDemoproduct;
use Illuminate\Support\Facades\Auth;

class DemoproductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $demoproducts = Demoproduct::with('product', 'location', 'status')->get();
        $selectedproducts = $demoproducts->map(function ($product) {
            return [
                'ID' => $product->id,
                'Artikel' => $product->product->item,
                'Beskrivning' => $product->product->item_description_swe,
                'Status' => $product->status->description,
                'Status_id' => $product->status_id,
                'Kommentar' => $product->comment,
                'Plats' => $product->location->path(),
                'Plats_id' => $product->location_id,
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

        $fields->push(['key' => 'Info']);
        $fields->push(['key' => 'Artikel']);
        $fields->push(['key' => 'Status']);
        $fields->push(['key' => 'Plats']);
        $locationBreadcrumbList = $this->locationNames();
        // dd($locationBreadcrumbList);
        // $locations = Location::all();
        // $locationBreadcrumbList = $locations->map(function ($f) {
        //     return [
        //         'text' => $f->path(),
        //         'value' => $f->id,
        //     ];
        // })->sortBy('text');
        return view('demoproducts.index', [
            'products' => $selectedproducts,
            'fields' => $fields,
            'locations' => $locationBreadcrumbList,
            'statuses' => ProductStatus::all(),
        ]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $locationBreadcrumbList = $this->locationNames();
        $products = Product::limit(50)->get();
        $items = $products->map(function ($data) {
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
     * Recursively populate array with all children
     * 
     * @param \App\Location $location
     * @param mixed $path
     * @param mixed &$names
     * @return void 
     */
    private function findChildren(Location $location, $path, &$names)
    {
        $id = $location->id;
        foreach ($location->childrenLocations as $children) {
            $oldPath = $path;
            $oldId = $id;
            $path .= ' > ' . $children->name;
            $this->findChildren($children, $path, $names);
            $path = $oldPath;
            $id = $oldId;
        }
        $names->push(['name' => $path, 'id' => $id]);
    }

    /**
     * Create a list as breadcrums
     * 
     * @return collection
     */
    private function locationNames()
    {
        $locations = Location::whereNull('location_id')
            ->get();
        $names = collect([]);
        foreach ($locations as $parent) {
            $place = $parent->name;
            $this->findChildren($parent, $place, $names);
        }
        return $names->sortBy('name');
    }
}
