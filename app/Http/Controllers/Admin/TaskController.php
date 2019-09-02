<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Task;

class TaskController extends Controller
{
    public function index()
    {
        return view('admin.tasks.index')->with('tasks', Task::all());
    }

}
