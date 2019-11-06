<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
		 $visitors = Visitor::where([
			['start','<=',date('Y-m-d')],
			['stop','>=',date('Y-m-d')],
			])->get();

		return view('/reception', ['visitors' => $visitors]);
	}
}
