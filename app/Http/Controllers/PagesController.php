<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Visitor;
use App\User;

class PagesController extends Controller
{
    public function home()
	{
		return view('/home');
	}
 
	public function posten()
	{
		return view('/posten');
	}

	public function reception()
	{
		if (!Auth::check()){
			Auth::loginUsingId(4, true);
		}
		$visitors = Visitor::where([
			['start','<=',date('Y-m-d')],
			['stop','>=',date('Y-m-d')],
			])->get();

		return view('/reception', ['visitors' => $visitors]);
	}	
	
	public function reception2()
	{
		if (!Auth::check()){
			Auth::loginUsingId(4, true);
		}
		$visitors = Visitor::where([
			['start','<=',date('Y-m-d')],
			['stop','>=',date('Y-m-d')],
			])->get();

		$files = Storage::files(public_path('images/reception'));

		return view('/reception2', [
			'visitors' => $visitors,
			'files' => $files,
			]);
	}
}
