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
            ->orderBy('name','asc')
            ->get();
		return view('locations.index', compact('locations'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @param mixed $id
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        if ($id == 0) {
            $name = '';
            $id = null;
        } else {
            $location = Location::find($id);
            $name = $location->path();
        }
        return view('locations.create', ['parent' => $name, 'id' => $id]);
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
            'name' => 'required',
        ]);
        $validatedData['location_id'] = $request->parent_id;
        $location = Location::create($validatedData);
        return redirect('locations')->with('message', 'Ny plats tillagd');
    }

     /**
     * Show the form for editing the specified resource.
     *
     * @param mixed $id
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
     * @param mixed $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if ($request->has('reset')) {
			return redirect('locations');
		}
		Location::whereId($id)->update(['name' => $request->description]);
        return redirect('locations/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\CalendarEntry $calendar
     * @param mixed $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $entry = Location::find($id);
        if ($entry->deletable()) {
            $entry->delete();
        }
        return redirect('locations');
    }
}
