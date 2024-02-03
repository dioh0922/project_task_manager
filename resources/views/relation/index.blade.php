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
            {{$target['summary']}}
        </div>
        <div>
            @foreach($child as $iter)
                {{var_dump($iter["child"]["summary"])}}
            @endforeach

            @if(count($parent) == 0)
                <form action="relation/add">
                    <select name="parent" id="" method="put">
                        @foreach($tasks as $item)
                            <option value='{{$item["id"]}}'>{{$item["id"]}}：{{$item["summary"]}}</option>
                        @endforeach
                    </select>
                    <input type="hidden" value="{$item['id']}"/>
                    <button type="submit">親を設定</button>
                </form>
            @else
                <div>
                    親タスク<br>
                    <ul>
                        @foreach($parent as $iter)
                            <li>
                                <form action="relation" method="delete">
                                    {{$iter["parent"]["id"]}}：{{$iter["parent"]["summary"]}}
                                </form>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <ul>
                <li>まずは新規につける</li>
                <li>すでに紐付いているデータに子階層追加するには？</li>
                <li>次に付け替えるには？</li>
                <li>+- 自身以上の階層の親すべてを持っているが...</li>
            </ul>
        </div>
    </div>
</div>
