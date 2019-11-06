<?php

namespace App\Http\Controllers;

use App\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class VisitorsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		
        $visitors = Visitor::all();
		return view('visitors.index',compact('visitors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('visitors.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $visitor = new Visitor();
		
		$visitor->name = request('name');
		$visitor->company = request('company');

		$request['start'] = Str::before($request['daterange'],' till ');
		$visitor->start = request('start');

		$request['stop'] = Str::after($request['daterange'],' till ');
		$visitor->stop = request('stop');
		
		$visitor->save();
		
		return redirect('/visitors');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Visitor  $visitor
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $visitor = Visitor::findOrFail($id);
		return view('visitors.show',compact('visitor'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Visitor  $visitor
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $visitor = Visitor::findOrFail($id);
		return view('visitors.edit', compact('visitor'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Visitor  $visitor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Visitor $visitor)
    {
		$visitor = Visitor::findOrFail($visitor->id);
		if ($request->has('delete')) {
			$visitor->delete();
			return redirect('/visitors');
		}
        if ($request->has('reset')) {
			return redirect('/visitors');
		}
		

		$visitor->name = request('name');
		$visitor->company = request('company');

		$request['start'] = Str::before($request['daterange'],' till ');
		$visitor->start = request('start');

		$request['stop'] = Str::after($request['daterange'],' till ');
		$visitor->stop = request('stop');
		
		$visitor->save();
		
		return redirect('/visitors');
		
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Visitor  $visitor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Visitor $visitor)
    {
        Visitor::findOrFail($visitor)->delete();
		return redirect('/visitors');
    }
}
