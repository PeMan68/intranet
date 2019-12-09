<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Visitor;

class ReceptionDisplayController extends Controller
{
    public function index()
	{
		$files = Storage::files('/public/reception');
		if (!Auth::check()){
			Auth::loginUsingId(4, true);
		}
		$visitors = Visitor::where([
			['start','<=',date('Y-m-d')],
			['stop','>=',date('Y-m-d')],
			])->get();

		return view('/reception2', ['visitors' => $visitors, 'files' => $files]);
	}
}
