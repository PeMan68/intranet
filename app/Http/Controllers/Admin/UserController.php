<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Role;
use Illuminate\Support\Facades\Auth;

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
        if(Auth::user()->id == $id){
			return redirect()->route('admin.users.index')->with('warning', 'Det är inte tillåtet att ändra sig själv.');
		}

		return view('admin.users.edit')->with(['user' => User::find($id), 'roles' => Role::all()]);
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
        if(Auth::user()->id == $id){
			return redirect()->route('admin.users.index')->with('warning', 'Det är inte tillåtet att ändra sig själv.');
		}
		
		$user = User::find($id);
		$user->roles()->sync($request->roles);
		return redirect()->route('admin.users.index')->with('success', 'Användaren uppdaterad.');
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
			$user->destroy($id);
			return redirect()->route('admin.users.index')->with('success', 'Användaren raderad.');
		}
			
		return redirect()->route('admin.users.index')->with('warning', 'Denna användaren kan inte raderas.');
	}
}
