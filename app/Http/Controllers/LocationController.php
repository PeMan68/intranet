<?php

namespace App\Http\Controllers;

use App\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $locations = Location::whereNull('location_id')
            ->with('childrenLocations')
            ->get();
		return view('locations.index', compact('locations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('locations.create');
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
            return redirect('locations');
        }
        $validatedData = $request->validate([
            'description' => 'required',
        ]);
        $location = Location::create($validatedData);
        return redirect('locations')->with('success', 'Ny plats tillagd');
    }

     /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $location = Location::find($id);
        return view('locations.edit',['location' => $location]);
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
			$entry = Location::find($id);
			$entry->delete();
			return redirect('locations');
		}
        if ($request->has('reset')) {
			return redirect('locations');
		}
		Location::whereId($id)->update(['description' => $request->description]);
        return redirect('locations/');
    }
}
