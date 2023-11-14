<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\View\View;

class TaskController extends Controller
{
    //
    public function list(): View{
        return view('task.list', [
            'list' => Task::all(),
            'title' => 'title test'
        ]);
    }
}
