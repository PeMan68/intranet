<?php

namespace App\Http\Controllers;

use App\Visitor;
use App\Visitor_name;
use App\User;
use Illuminate\Http\Request;
use App\Http\Requests\StoreVisitor;
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
        $old_visitors = Visitor::where('stopTime','<',date('y-m-d',strtotime('-30 days')))->get();
		foreach ($old_visitors as $visitor) {
			$visitor->delete();
			$vistor_names = Visitor_name::where('visitor_id',$visitor->id)->delete();
		}
		return view('visitors.index')->with(['visitors' => Visitor::all(), 'users' => User::where('calendar',1)->get()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('visitors.create')->with(['visitors' => Visitor::all(), 'users' => User::where('calendar',1)->get()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreVisitor $request)
    {
 		$validatedData = $request->validated();
		$visitor = new Visitor();
		
		$visitor->company = request('company');

		$visitor->startTime = Str::before($request['daterange'],' till ');

		$visitor->stopTime = Str::after($request['daterange'],' till ');
		
		$visitor->user_id = $request->who;
		$visitor->save();
		foreach ($request->name as $name)
		{
			if (!is_null($name))
			{
				$visitor_name = new Visitor_name();
				$visitor_name->visitor_id = $visitor->id;
				$visitor_name->name = $name;
				$visitor_name->save();
			}
		}
		
		return redirect('/visitors');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Visitor  $visitor
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return view('visitors.edit')->with(['visitor' => Visitor::findOrFail($id), 'users' => User::where('calendar',1)->get()]);
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
			$vistor_names = Visitor_name::where('visitor_id',$visitor->id)->delete();
			return redirect('/visitors');
		}
        if ($request->has('reset')) {
			return redirect('/visitors');
		}
		
		$visitor->company = request('company');
		$visitor->startTime = Str::before($request['daterange'],' till ');
		$visitor->stopTime = Str::after($request['daterange'],' till ');
		$visitor->user_id = $request->who;
		$visitor->save();
		
		$vistor_names = Visitor_name::where('visitor_id',$visitor->id)->delete();
		foreach ($request->name as $name)
		{
			if (!is_null($name))
			{
				$visitor_name = new Visitor_name();
				$visitor_name->visitor_id = $visitor->id;
				$visitor_name->name = $name;
				$visitor_name->save();
			}
		}
		
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
		$vistor_names = Visitor_name::where('visitor_id',$visitor->id)->delete();
		return redirect('/visitors');
    }
}
