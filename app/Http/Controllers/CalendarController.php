<?php

namespace App\Http\Controllers;

use App\CalendarEntry;
use App\CalendarCategory;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

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
        return view('calendar.create')->with(['categories' => CalendarCategory::all(), 'users' => User::where('calendar',1)->get()]);
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
			return redirect('/home');
		}
		$request['start'] = Str::before($request['daterange'],' till ');
		$request['stop'] = Str::after($request['daterange'],' till ');
        $validatedData = $request->validate([
			'description' => 'required|max:255',
			'start' => 'required|date',
			'stop' => 'required|date|after_or_equal:start',
		]);
		$validatedData['user_id'] = $request->user_id;
		$validatedData['calendarcategory_id'] = $request->calendarcategory_id;
		$calendarEntry = CalendarEntry::create($validatedData);
		return redirect('/home');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CalendarEntry  $calendar
     * @return \Illuminate\Http\Response
     */
    public function show(CalendarEntry $calendar)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CalendarEntry  $calendar
     * @return \Illuminate\Http\Response
     */
    public function edit(CalendarEntry $calendar)
    {
		$categories = CalendarCategory::all();
		$users = User::all();
		$data = [
			'categories' => $categories,
			'users' => $users,
			'entry' => $calendar,
			];
        return view('calendar.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CalendarEntry  $calendar
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CalendarEntry $calendar)
    {
        if ($request->has('delete')) {
			$entry = CalendarEntry::find($calendar->id);
			$entry->delete();
			return redirect('/home');
		}
        if ($request->has('reset')) {
			return redirect('/home');
		}
		
		$validatedData = $request->validate([
			'description' => 'required|max:255',
			'start' => 'required|date',
			'stop' => 'required|date|after_or_equal:start',
		]);
		$validatedData['user_id'] = $request->user_id;
		$validatedData['calendarcategory_id'] = $request->calendarcategory_id;
		
		CalendarEntry::whereId($calendar->id)->update($validatedData);
		return redirect('/home');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CalendarEntry  $calendar
     * @return \Illuminate\Http\Response
     */
    public function destroy(CalendarEntry $calendar)
    {
		//
	}
}
