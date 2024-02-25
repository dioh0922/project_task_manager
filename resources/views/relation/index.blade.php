<div>
    <header>
        @include('header')
    </header>

    <div @style(['height: 80%']) @class([
        'container',
        'align-items-center',
        'justify-content-center'
    ])>
        <div class="row">
            <h3>{{$base_task['summary']}}</h3>
        </div>
        <div>
            @if(count($parent["relation_list"]) > 0)
                <div class="row">
                    関連上位タスク<br>
                    @foreach($parent["relation_list"] as $iter)
                        <p>{{$iter["parent"]["id"]}}：{{$iter["parent"]["summary"]}}</p>
                    @endforeach
                </div>
            @else
                <form action="{{route('relation.store')}}" method="post">
                    <div class="row">
                        @csrf
                        <label for="target_parent">親タスク</label>
                        <input type="hidden" name="target" id="target_parent" value="1"/>
                        <select class="form-select w-60" name="parent" id="" >
                            @foreach($parent["target_list"] as $item)
                                <option value='{{$item["id"]}}'>{{$item["id"]}}：{{$item["summary"]}}</option>
                            @endforeach
                        </select>
                        <input type="hidden" name="id" value="{{$base_task['id']}}"/>
                    </div>
                    <div class="row mt-1">
                        <button class="btn btn-danger" type="submit">親タスクを設定</button>
                    </div>
                </form>
            @endif

            <div class="row">
                <form action="{{route('relation.store')}}" method="post">
                    <div class="row">
                        @csrf
                        <label for="target_child">子タスク</label>
                        <input type="hidden" name="target" id="target_child" value="0"/>

                        <select class="form-select" name="parent" id="" >
                            @foreach($child["target_list"] as $item)
                                <option value='{{$item["id"]}}'>{{$item["id"]}}：{{$item["summary"]}}</option>
                            @endforeach
                        </select>
                        <input type="hidden" name="id" value="{{$base_task['id']}}"/>
                    </div>
                    <div class="row mt-2">
                        <button class="btn btn-info" type="submit">関連タスクを設定</button>
                    </div>
                </form>
            </div>

            @if(count($child["relation_list"]) > 0)
                <div class="row">
                    子タスク
                </div>
                @foreach($child["relation_list"] as $iter)
                    <div class="row">
                    @if($iter["task_depth"] == "1")
                        <form action="{{route('relation.update', ['relation' => $base_task['id']])}}" method="post">
                            @method("PATCH")
                            @csrf
                            {{$iter["child"]["id"]}}：{{$iter["child"]["summary"]}}
                            <input type="hidden" name="parent" value="{{$base_task['id']}}"/>
                            <input type="hidden" name="child" value="{{$iter['child']['id']}}"/>
                            <button class="btn btn-close" type="submit"></button>
                        </form>
                    @else
                        <p>{{$iter["child"]["id"]}}:{{$iter["child"]["summary"]}}</p>
                    @endif
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>
