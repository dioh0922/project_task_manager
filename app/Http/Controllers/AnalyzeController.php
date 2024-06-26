<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\Http;
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
         ->groupBy('tasks.summary')
         ->orderBy('dep')
         ->get();

         $count = Relation::select('base_task_id', DB::raw('count(*) as c_cnt'))->whereNot('task_depth', 0)->groupBy('base_task_id');
         $task = Task::select('*')->joinSub($count, 'cnt', function(JoinClause $join){
             $join->on('tasks.id', '=', 'cnt.base_task_id');
         })
         ->get();

        // 階層文字列内の区切りごとにインデントしてグラフ表示
        return view('analyze.index', [
            'title' => 'タスク分析',
            'tree' => $closure,
            'target' => 0,
            'task' => $task,
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
            ->groupBy('tasks.id')
            ->groupBy('tasks.summary');
        }else{
            $closure = Relation::select('tasks.id', 'tasks.summary', DB::raw('GROUP_CONCAT(base_task_id ORDER BY task_depth DESC separator "/") as dep'))
            ->join('tasks', 'tasks.id', '=', 'relations.child_task_id')
            ->where('tasks.is_delete', 0)
            ->groupBy('tasks.id')
            ->groupBy('tasks.summary');
        }

        $list = Relation::from('relations as target')->select('*')
        ->leftJoinSub($closure, 'child', function(JoinClause $join){
            $join->on('target.child_task_id', '=', 'child.id');
        })
        ->where('base_task_id', $request->id)
        ->whereNot('id', $request->id)
        ->orderBy('dep')
        ->get();

        $count = Relation::select('base_task_id', DB::raw('count(*) as c_cnt'))->whereNot('task_depth', 0)->groupBy('base_task_id');
        $task = Task::select('*')->joinSub($count, 'cnt', function(JoinClause $join){
            $join->on('tasks.id', '=', 'cnt.base_task_id');
        })
        ->get();

        // 階層文字列内の区切りごとにインデントしてグラフ表示
        return view('analyze.index', [
            'title' => 'タスク分析',
            'tree' => $list,
            'target' => $request->id,
            'task' => $task,
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

    /**
     * Githubアカウントページ
     */
    public function github(){

        $param = [
            'query' => sprintf(
                    "query{user(login:\"%s\"){contributionsCollection {contributionCalendar {weeks {contributionDays {contributionCount\ndate}}}}}}",
                    config('app.github_user')
                )
        ];
        $res = Http::withToken(config('app.github_token'))
        ->post('https://api.github.com/graphql', $param);

        if($res->successful()){
            $user = $res->object()->data->user;
            $weeks = $user->contributionsCollection->contributionCalendar->weeks;
            $day_list = [];
            $cnt_list = [];
            // TODO: 成形方法の検討
            foreach($weeks as $days){
                foreach($days->contributionDays as $item){
                    $day_list[] = $item->date;
                    $cnt_list[] = $item->contributionCount;
                }
            }
            // TODO: mermaidのxychartは試験実装のため、別の表示も検討
            return view('github.index', [
                'title' => 'Githubアカウント',
                'contribute' => $weeks,
                'day' => $day_list,
                'cnt' => $cnt_list
            ]);
        }else{
            throw new \Exception($res->status().':'.$res->object()->message);
        }
    }

}
