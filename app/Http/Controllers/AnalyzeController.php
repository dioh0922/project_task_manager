<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Database\Query\JoinClause;
use App\Models\Relation;
use App\Models\Task;
use App\Http\Requests\AnalyzeRequest;

class AnalyzeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // 閉包テーブル内の親タスクを連結して階層文字列を取得する、階層文字列でソートしてツリー順に並べる
         $closure = Relation::select('tasks.id', 'tasks.summary', DB::raw('GROUP_CONCAT(base_task_id ORDER BY task_depth DESC separator "/") as dep'))
         ->join('tasks', 'tasks.id', '=', 'relations.child_task_id')
         ->groupBy('tasks.id')
         ->orderBy('dep')
         ->get();

        // 階層文字列内の区切りごとにインデントしてグラフ表示
        return view('analyze.index', [
            'title' => 'タスク分析',
            'tree' => $closure,
            'target' => 0,
            'task' => Task::select('*')->orderByDesc('id')->get(),
            'close' => 0
        ]);
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
     * マインドマップ画面の拡張
     */
    public function showAnalyze(AnalyzeRequest $request)
    {
        if(empty($request->id)){
            return redirect('analyze');
        }

        // 閉包テーブル内の親タスクを連結して階層文字列を取得する、階層文字列でソートしてツリー順に並べる
        if($request->close == '1'){
            $closure = Relation::select('tasks.id', 'tasks.summary', DB::raw('GROUP_CONCAT(base_task_id ORDER BY task_depth DESC separator "/") as dep'))
            ->join('tasks', 'tasks.id', '=', 'relations.child_task_id')
            ->groupBy('tasks.id');
        }else{
            $closure = Relation::select('tasks.id', 'tasks.summary', DB::raw('GROUP_CONCAT(base_task_id ORDER BY task_depth DESC separator "/") as dep'))
            ->join('tasks', 'tasks.id', '=', 'relations.child_task_id')
            ->where('tasks.is_delete', 0)
            ->groupBy('tasks.id');
        }


        $list = Relation::from('relations as target')->select('*')
        ->leftJoinSub($closure, 'child', function(JoinClause $join){
            $join->on('target.child_task_id', '=', 'child.id');
        })
        ->where('base_task_id', $request->id)
        ->whereNot('id', $request->id)
        ->orderBy('dep')
        ->get();

        // 階層文字列内の区切りごとにインデントしてグラフ表示
        return view('analyze.index', [
            'title' => 'タスク分析',
            'tree' => $list,
            'target' => $request->id,
            'task' => Task::select('*')->orderByDesc('id')->get(),
            'close' => $request->close
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

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
