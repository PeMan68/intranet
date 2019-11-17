<?php

namespace App\Http\Controllers;

use App\Issue;
use App\Area;
use App\Task;
use App\User;
use Illuminate\Http\Request;

class IssuesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $issues = Issue::all();
		return view('issues.index',compact('issues',$issues));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $areas = Area::all();
        $tasks = Task::all();
		$users = User::where('active', 1)->get();
		return view('issues.create')->with(['areas' => $areas, 'tasks' => $tasks, 'users' => $users]);
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
			return redirect('issues');
		}
      //Validate
        $validatedData = $request->validate([
            'task' => 'required',
			'description' => 'required',
			'person' => 'required',
			'phone' => 'required',
			'email' => 'required',
        ]);
        
        $issue = Issue::create($validatedData);
        return redirect('/issues/'.$issue->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Issue  $issue
     * @return \Illuminate\Http\Response
     */
    public function show(Issue $issue)
    {
        return view('issues.show',compact('issue',$issue));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Issue  $issue
     * @return \Illuminate\Http\Response
     */
    public function edit(Issue $issue)
    {
        return view('issues.edit',compact('issue', $issue));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Issue  $issue
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Issue $issue)
    {
        if ($request->has('reset')) {
			return redirect('issues');
		}
        if ($request->has('delete')) {
			$entry = Issue::find($issue->id);
			$entry->delete();
			return redirect('issues');
		}
		
		//Validate
        $validatedData = $request->validate([
            'task' => 'required',
			'description' => 'required',
			'person' => 'required',
			'phone' => 'required',
			'email' => 'required',
        ]);
 		
		Issue::whereId($issue->id)->update($validatedData);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Issue  $issue
     * @return \Illuminate\Http\Response
     */
    public function destroy(Issue $issue)
    {
        //
    }
}
