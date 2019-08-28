<?php

namespace App\Http\Controllers;

use App\CalendarEntry;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CalendarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('calendar.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
			'calendarcategory_id' => 'between:1,4',
			'description' => 'required|max:255',
			'start' => 'required|date',
			'stop' => 'required|date|after:start',
			'calendarcategory_id' => '',
		]);
		$validatedData['user_id'] = Auth::User()->id;
		$calendarEntry = CalendarEntry::create($validatedData);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CalendarEntry  $calendarEntry
     * @return \Illuminate\Http\Response
     */
    public function show(CalendarEntry $calendarEntry)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CalendarEntry  $calendarEntry
     * @return \Illuminate\Http\Response
     */
    public function edit(CalendarEntry $calendarEntry)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CalendarEntry  $calendarEntry
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CalendarEntry $calendarEntry)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CalendarEntry  $calendarEntry
     * @return \Illuminate\Http\Response
     */
    public function destroy(CalendarEntry $calendarEntry)
    {
        //
    }
}
