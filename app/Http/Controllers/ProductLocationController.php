<?php

namespace App\Http\Controllers;

use App\ProductLocation;
use Illuminate\Http\Request;

class ProductLocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		return view('productlocations.index')->with('locations', ProductLocation::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('productlocations.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->has('reset')) {
            return redirect('productlocations');
        }
        $validatedData = $request->validate([
            'description' => 'required',
        ]);
        $productLocation = ProductLocation::create($validatedData);
        return redirect('productlocations')->with('success', 'Ny plats tillagd');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ProductLocation  $productLocation
     * @return \Illuminate\Http\Response
     */
    public function show(ProductLocation $productLocation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $location = ProductLocation::find($id);
        return view('productlocations.edit',['location' => $location]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if ($request->has('delete')) {
			$entry = ProductLocation::find($id);
			$entry->delete();
			return redirect('productlocations');
		}
        if ($request->has('reset')) {
			return redirect('productlocations');
		}
		ProductLocation::whereId($id)->update(['description' => $request->description]);
        return redirect('productlocations/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProductLocation  $productLocation
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductLocation $productLocation)
    {
        //
    }
}
