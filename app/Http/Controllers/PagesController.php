<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Visitor;

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
			['startTime','<=',date('Y-m-d',strtotime('tomorrow'))],
			['stopTime','>=',date('Y-m-d')],
			])->orderBy('company')->get()->sortBy('startTime');
		$files = Storage::files('public/reception');
		$f=array();
		// trim the path to images
		foreach ($files as $file)
		{
			array_push($f, Str::after($file, 'public/'));
		}
		
		return view('/reception2', [
			'visitors' => $visitors,
			'files' => $f,
			]);
	}
}
