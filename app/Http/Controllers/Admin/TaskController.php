<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Task;
use App\Area;
use App\Priority;

class TaskController extends Controller
{
    public function index()
    {
        return view('admin.tasks.index')->with('tasks', Task::all());
    }
	
	public function create()
	{
		$priorities = Priority::all();
		$areas = Area::all();
		$data = [
			'priorities' => $priorities,
			'areas' => $areas,
			];
		return view('admin.tasks.create', $data);
	}

    public function store(Request $request)
    {
        if ($request->has('reset')) {
			return redirect('admin/tasks');
		}
		//Validate
        $validatedData = $request->validate([
            'name' => 'required',
            'area_id' => 'required',
            'prio_id' => 'required',
        ]);
        $task = Task::create($validatedData);
        return redirect('admin/tasks/');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        return view('admin.tasks.show',compact('task',$task));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
		$priorities = Priority::all();
		$areas = Area::all();
		$data = [
			'priorities' => $priorities,
			'areas' => $areas,
			'task' => $task,
			];
        return view('admin.tasks.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
		dd($task);
        if ($request->has('delete')) {
			$entry = Task::find($task->id);
			$entry->delete();
			return redirect('admin/tasks');
		}
        if ($request->has('reset')) {
			return redirect('admin/tasks');
		}
		Task::whereId($task->id)->update(['name' => $request->name,'area_id' => $request->area_id,'prio_id' => $request->prio_id]);
        return redirect('admin/tasks/');
		
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        //
    }

}
