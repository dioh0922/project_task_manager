<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Reference;
use App\Models\Comment;
use App\Models\Relation;
use Illuminate\View\View;
use App\Http\Requests\TaskDeleteRequest;
use Illuminate\Support\Facades\Auth;

use Illuminate\Database\Query\JoinClause;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $child = Relation::select('base_task_id')->where('task_depth', '<>', 0)->groupBy('base_task_id');
        $list = Task::select('*')
        ->leftJoinSub($child, 'child', function(JoinClause $join){
            $join->on('tasks.id', '=', 'child.base_task_id');
        })
        ->get()
        ->sortByDesc('created_at')->sortBy('is_delete');
        return view('task.list', [
            'list' => $list,
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
            // 閉包テーブル用に自身の階層を記録しておく
            $relation = Relation::create([
                'base_task_id' => $task->id,
                'child_task_id' => $task->id,
            ]);
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
        if($task == null){
            return redirect('task')->withErrors('タスクが見つかりません:id='.$id);
        }else if(Auth::check() || $task->is_delete == 1){
            $comment = Comment::select('comment', 'updated_at')->where('task_id', $id)->get();
            $reference = Reference::select('source', 'updated_at')->where('task_id', $id)->get();

            $parent_list = Relation::select('*')
                ->where([
                    ['child_task_id', '=', $id],
                    ['base_task_id', '<>', $id],
                ])
                ->with('child')
                ->with('parent')
                ->get();

            $child_list = Relation::select('*')
                ->where([
                    ['child_task_id', '<>', $id],
                    ['base_task_id', '=', $id],
                ])
                ->with('parent')
                ->get();

            return view('task.detail',[
                'task' => $task,
                'comment' => $comment,
                'reference' => $reference,
                'parent' => $parent_list,
                'child' => $child_list,
                'title' => '詳細'
            ]);
        }else{
            return redirect('login');
        }

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
