<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Reference;
use App\Models\Comment;
use App\Models\Relation;
use App\Http\Requests\RelationAddRequest;
use App\Http\Requests\RelationDeleteRequest;

class RelationController extends Controller
{
    private function create_closure_table(int $parent, int $child){
        $ancestor_task = Relation::select(['base_task_id', 'task_depth'])->where([
            ['child_task_id', '=', $child],
            ['task_depth', '!=', 0]
        ])->get();

        // 子タスク以下の階層もすべて記録する
        $descendants_task = Relation::select('child_task_id', 'task_depth')->where([
            ['base_task_id', '=', $parent],
        ])->orderBy('task_depth', 'asc')->get();

        // 親にしているものの1つ下にする
        $parent_depth = 1;
        foreach($descendants_task as $descendant){
            Relation::create([
                'base_task_id' => $child,
                'child_task_id' => $descendant->child_task_id,
                'task_depth' => $parent_depth
            ]);
            $parent_depth += 1;
        }

        foreach($ancestor_task as $ancestor){
            $depth_iter = $ancestor->task_depth;
            foreach($descendants_task as $descendant){
                $depth_iter += 1;
                Relation::create([
                    'base_task_id' => $ancestor->base_task_id,
                    'child_task_id' => $descendant->child_task_id,
                    'task_depth' => $depth_iter
                ]);
            }
        }
    }
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
    public function store(RelationAddRequest $request)
    {
        if($request->target == '1'){
            $this->create_closure_table($request->id, $request->parent);
        }else{
            $this->create_closure_table($request->parent, $request->id);
        }
        return redirect('relation/'.$request->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // 関連テーブルには自身の階層も登録しているため、同じIDのデータは除外
        $parent_list = Relation::select('*')
            ->where('child_task_id', $id)
            ->whereNot('base_task_id', $id)
            ->with('child')
            ->with('parent')
            ->get();

        // TODO: さらに下のタスクをツリーごとにまとめて取得するように
        $child_list = Relation::select('*')
            ->where('task_depth', 1)
            ->where('base_task_id', $id)
            ->whereNot('child_task_id', $id)
            ->with('parent')
            ->orderBy('child_task_id')
            ->get();

        $parent = [
            "relation_list" => $parent_list,
            "target_list" => Task::select('id', 'summary')->whereNot('id', $id)->get()
        ];

        // 子タスクに設定されていない副問い合わせ
        $sub = Relation::select('sub.id')
        ->join('tasks as sub', 'id', '=', 'child_task_id')
        ->where('base_task_id', $id)
        ->whereColumn('sub.id',  'ext.id');
        $child = [
            "relation_list" => $child_list,
            "target_list" => Task::from('tasks as ext')
                ->select('ext.id', 'ext.summary')
                ->whereNotExists($sub)
                ->get()
        ];

        // 関連テーブルで直接つながっていないタスクを選べるようにする
        $sub = Relation::select('tasks.id')->join('tasks', 'id', '=', 'base_task_id')
        ->where('child_task_id', $id)
        ->whereRaw('raw.id = tasks.id');
        $task = Task::from('tasks as raw')->select('raw.id as id', 'summary')->whereNotExists($sub)->get();

        return view ('relation.index', [
            'base_task' => Task::find($id),
            'tasks' => $task,
            'child' => $child,
            'parent' => $parent,
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
    public function update(RelationDeleteRequest $request, string $id)
    {
        // 選んだタスクの子階層を取得する -> そこに含まれるchild_taskを消す
        $descendant_task = Relation::select('*')->where([
            ['base_task_id', '=', $request->child]
        ])->get();
        foreach($descendant_task as $descendant){
            Relation::where([
                ['base_task_id', $id],
                ['child_task_id', $descendant->child_task_id]
            ])->delete();
        }
        return redirect('relation/'.$id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
