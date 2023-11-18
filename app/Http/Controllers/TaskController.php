<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\View\View;
use App\Http\Requests\TaskDeleteRequest;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('task.list', [
            'list' => Task::all(),
            'title' => 'タスク一覧'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view ('task.create', [
            'title' => '新規作成'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $task = Task::create([
            'summary' => $request->summary, 
            'detail' => $request->detail, 
            'reference' => $request->reference
        ]);
        if($task != null){
            return redirect('task');
        }else{
            throw new Exception('faild create task');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $task = Task::find($id);
        $task["detail"] = str_replace("\\n", "\n", $task["detail"]);
        $task["detail"] = str_replace("\\r", "\r", $task["detail"]);
        return view('task.detail',[
            'task' => $task,
            'title' => '詳細'
        ]);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        Task::where('id', $id)->update(['is_delete' => 1]);
        return redirect('task');

    }
}
