<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\Helper;

class IssueResponsibilityController extends Controller
{
	public function update_tasks()
	{
		echo '<h2>Lägg till tasks</h2><br>';
		add_responsibilites();
		echo '<h2>Ta bort tasks</h2><br>';
		delete_responsibilites();
	}
}
