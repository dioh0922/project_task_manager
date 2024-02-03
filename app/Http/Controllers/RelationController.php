<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Reference;
use App\Models\Comment;
use App\Models\Relation;

class RelationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        // 関連テーブルには自身の階層も登録しているため、同じIDのデータは除外
        $parent_list = Relation::select('*')
            ->where('child_task_id', $id)
            ->whereNot('base_task_id', $id)
            ->with('child')
            ->with('parent')
            ->get();

        $child_list = Relation::select('*')
            ->where('base_task_id', $id)
            ->whereNot('child_task_id', $id)
            ->with('parent')
            ->get();

        // 関連テーブルで直接つながっていないタスクを選べるようにする
        $sub = Relation::select('tasks.id')->join('tasks', 'id', '=', 'base_task_id')
        ->where('child_task_id', $id)
        ->whereRaw('raw.id = tasks.id');
        $task = Task::from('tasks as raw')->select('raw.id as id', 'summary')->whereNotExists($sub)->get();

        return view ('relation.index', [
            'target' => Task::find($id),
            'tasks' => $task,
            'child' => $child_list,
            'parent' => $parent_list,
            'title' => '関連追加',
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
        //
    }
}
