<?php

namespace App\Http\Controllers;

use App\Holiday;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HolidayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $this->delete_old_data();
       $fields = collect([]);
    //    $fields->push(['key'=>''])
       return view('holidays.index')->with(['holidays' => Holiday::all()]);
    }

    private function delete_old_data() 
    {
        // Delete data from model older than 12 months
        return true;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('holidays.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $holiday = new Holiday();

        $holiday->date = $request->date;
        if ($request->has('half_day')) {
            $holiday->half_day = true;
        }
        $holiday->user_id = Auth::user()->id;
        $holiday->description = $request->description;
        $holiday->save();
        return redirect('/holidays');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Holiday  $holiday
     * @return \Illuminate\Http\Response
     */
    public function show(Holiday $holiday)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Holiday  $holiday
     * @return \Illuminate\Http\Response
     */
    public function edit(Holiday $holiday)
    {
        return view('holidays.edit')->with(['holiday'=>$holiday]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Holiday  $holiday
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Holiday $holiday)
    {
        if ($request->has('reset')) {
            return redirect('/holidays');
        }
        if ($request->has('delete')) {
            $holiday->delete();
            return redirect('/holidays');
        }
        $holiday->date = $request('date');
        if ($request->has('half_day')) {
            $holiday->half_day = true;
        }
        $holiday->user_id = Auth::user()->id;
        $holiday->description = $request('description');
        $holiday->save();
        return redirect('/holidays');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Holiday  $holiday
     * @return \Illuminate\Http\Response
     */
    public function destroy(Holiday $holiday)
    {
        //
    }
}
