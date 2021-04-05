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
       $holidays =  Holiday::orderBy('date')->get()->map(function ($item) {
           return [
               'Ändra' => $item->id,
               'Datum' => date('Y-m-d (l)',strtotime($item->date)),
               'Halvdag' => $item->half_day,
               'Beskrivning' => $item->description,
           ];
       });
       $fields = collect([]);
        $fields->push(['key'=>'Ändra']);
        $fields->push(['key'=>'Datum']);
        $fields->push(['key'=>'Halvdag']);
        $fields->push(['key'=>'Beskrivning']);

       return view('holidays.index')->with(['holidays' => $holidays, 'fields' => $fields]);
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
    public function edit($id)
    {
        
        return view('holidays.edit')->with(['holiday'=>Holiday::find($id)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Holiday  $holiday
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if ($request->has('reset')) {
            return redirect('/holidays');
        }
        $holiday = Holiday::find($id);
        if ($request->has('delete')) {
            $holiday->delete();
            return redirect('/holidays');
        }
        $holiday->date = $request->date;
        if ($request->has('half_day')) {
            $holiday->half_day = true;
        } else {
            $holiday->half_day = false;
        }
        $holiday->user_id = Auth::user()->id;
        $holiday->description = $request->description;
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
