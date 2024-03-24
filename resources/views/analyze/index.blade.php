<div>
    <header>
        @include('header')

        <script src="https://cdn.jsdelivr.net/npm/mermaid@10.9.0/dist/mermaid.min.js"></script>
        <script>
            function selectedItem(id){
                location.href = location.pathname + '/../' +id;
            }
        </script>
    </header>

    <div @style(['height: 80%']) @class([
        'container',
        'align-items-center',
        'justify-content-center'
    ])>
        <div class='container'>
            <div class='row' >
                <select class='my-2' onchange='selectedItem(event.target.value)'>
                    <option value='0'>未選択</option>
                    @foreach($task as $item)
                        <option value='{{$item["id"]}}'
                            @if($target == $item['id'])
                                selected
                            @endif
                        >
                            {{$item['id']}}:{{$item['summary']}}
                        </option>
                    @endforeach
                </select>
            </div>

            <pre class="mermaid">
                mindmap
                    top({{$top}})
                    @foreach($tree as $task)
                        <? echo preg_replace('/[0-9]*\//', "\t", $task['dep'])."\n" /** エスケープは""で囲む  **/ ?>
                    @endforeach
            </pre>
        </div>
    </div>

</div>
