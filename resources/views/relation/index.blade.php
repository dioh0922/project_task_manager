<div>
    <header>
        @include('header')
    </header>

    <div @style(['height: 80%']) @class([
        'container',
        'align-items-center',
        'justify-content-center'
    ])>
        <div>
            {{$base_task['summary']}}
        </div>
        <div>
            @if(count($parent["relation_list"]) > 0)
                <div>
                    関連上位タスク<br>
                    <ul>
                        @foreach($parent["relation_list"] as $iter)
                            <li>
                                <form action="relation" method="delete">
                                    {{$iter["parent"]["id"]}}：{{$iter["parent"]["summary"]}}
                                </form>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @else
                <div>
                    <form action="{{route('relation.store')}}" method="post">
                        @csrf
                        <label for="target_parent">親タスク</label>
                        <input type="hidden" name="target" id="target_parent" value="1"/>
                        <select name="parent" id="" >
                            @foreach($parent["target_list"] as $item)
                                <option value='{{$item["id"]}}'>{{$item["id"]}}：{{$item["summary"]}}</option>
                            @endforeach
                        </select>
                        <input type="hidden" name="id" value="{{$base_task['id']}}"/>
                        <button type="submit">親タスクを設定</button>
                    </form>
                </div>
            @endif

            <form action="{{route('relation.store')}}" method="post">
                @csrf
                <label for="target_child">子タスク</label>
                <input type="hidden" name="target" id="target_child" value="0"/>

                <select name="parent" id="" >
                    @foreach($child["target_list"] as $item)
                        <option value='{{$item["id"]}}'>{{$item["id"]}}：{{$item["summary"]}}</option>
                    @endforeach
                </select>
                <input type="hidden" name="id" value="{{$base_task['id']}}"/>
                <button type="submit">関連タスクを設定</button>
            </form>

            子タスク<br>
            @foreach($child["relation_list"] as $iter)
                @if($iter["task_depth"] == "1")
                    <form action="{{route('relation.update', ['relation' => $base_task['id']])}}" method="post">
                        @method("PATCH")
                        @csrf
                        {{$iter["child"]["id"]}}：{{$iter["child"]["summary"]}}
                        <input type="hidden" name="parent" value="{{$base_task['id']}}"/>
                        <input type="hidden" name="child" value="{{$iter['child']['id']}}"/>
                        <button type="submit">解除</button>
                    </form>
                @else
                    <div class="">・{{$iter["child"]["id"]}}:{{$iter["child"]["summary"]}}</div>
                @endif
            @endforeach
        </div>
    </div>
</div>
