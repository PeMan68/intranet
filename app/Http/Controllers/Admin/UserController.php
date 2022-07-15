<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Role;
use App\Department;
use App\Exports\UsersExport;
use App\Task;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.users.index')->with('users', User::all());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

		return view('admin.users.edit')->with([
			'user' => User::find($id), 
			'roles' => Role::all(),
			'departments' => Department::all(),
			'tasks' => Task::all()->sortBy('area_id'),	
			]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
		if ($request->has('delete')) {
			$entry = User::find($id);
			$entry->delete();
			return redirect('admin/users');
		}
        if ($request->has('reset')) {
			return redirect('admin/users');
		}
		$user = User::find($id);
		$user->active = $request->has('active');
		$user->calendar = $request->has('calendar');
		$user->save();
		
		//update roles, departments and tasks responsibility
		$user->roles()->sync($request->roles);
		$user->departments()->sync($request->departments);
		$tasks = $request->tasks;
		
		//syncs all tasks to user
		$user->tasks()->sync($tasks);
		
		//loop through each task and assign level
		$levels = $request->levels;
		foreach ($tasks as $task){
			$level=$levels[$task];
			$user->tasks()->updateExistingPivot($task, ['level' => $level]);
		}

		return redirect()->route('admin.users.index')->with('message', 'Användaren uppdaterad.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::user()->id == $id){
			return redirect()->route('admin.users.index')->with('warning', 'Det är inte tillåtet att radera sig själv.');
		}
		
		$user = User::find($id);
		
		if($user){
			$user->roles()->detach();
			$user->departments()->detach();
			$user->tasks()->detach();
			$user->destroy($id);
			return redirect()->route('admin.users.index')->with('message', 'Användaren raderad.');
		}
			
		return redirect()->route('admin.users.index')->with('warning', 'Denna användaren kan inte raderas.');
	}

    public function export()
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }
}
