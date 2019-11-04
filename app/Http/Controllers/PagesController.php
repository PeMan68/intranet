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
		return view('/reception', ['visitors' => Visitor::All()]);
	}
}
