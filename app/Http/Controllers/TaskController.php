<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Reference;
use App\Models\Comment;
use Illuminate\View\View;
use App\Http\Requests\TaskDeleteRequest;
use Illuminate\Support\Facades\Auth;

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
        if(Auth::check()){
            return view ('task.create', [
                'title' => '新規作成',
            ]);    
        }else{
            return redirect('login');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'summary' => ['required', 'bail']
        ]);
        $task = Task::create([
            'summary' => $request->summary, 
            'detail' => $request->detail, 
        ]);


        if($task != null){
            if(isset($request->reference)){
                $reference = Reference::create([
                    'task_id' => $task->id,
                    'source' => $request->reference
                ]);
            }
            return redirect('task/'.$task->id);
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
        $comment = Comment::select('comment', 'updated_at')->where('task_id', $id)->get();
        $reference = Reference::select('source', 'updated_at')->where('task_id', $id)->get();
        return view('task.detail',[
            'task' => $task,
            'comment' => $comment,
            'reference' => $reference,
            'title' => '詳細'
        ]);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        return redirect('task');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $task = Task::where('id', $id)->first();

        $task->update([
            'detail' => $request->detail, 
            'updated_at' => now()
        ]);
        if(isset($request->comment)){
            $comment = Comment::create([
                'task_id' => $id,
                'comment' => $request->comment,
            ]);
        }
        if(isset($request->reference)){
            $reference = Reference::create([
                'task_id' => $id,
                'source' => $request->reference
            ]);
        }
        return redirect('task/'.$id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        Task::where('id', $id)->update(['is_delete' => 1, 'closed_at' => now()]);
        return redirect('task');

    }
}
