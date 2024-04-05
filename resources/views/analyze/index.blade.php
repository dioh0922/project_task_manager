<div>
    <header>
        @include('header')

        <script src="https://cdn.jsdelivr.net/npm/mermaid@10.9.0/dist/mermaid.min.js"></script>

    </header>

    <div @style(['height: 80%']) @class([
        'container',
        'align-items-center',
        'justify-content-center'
    ])>
        <div class='container'>
            <div class='row' >
                <form action='{{route("showAnalyze")}}' method='post'>
                    @csrf
                    <div class='form-check form-switch'>
                        <input class='form-check-input'
                        name='close'
                        type='checkbox'
                        role='switch'
                        id='flexSwitchCheckDefault'
                        value='1'
                        onchange='submit(this.form)'
                        @if($close == 1)
                            checked
                        @endif
                        @if($target == 0)
                            disabled
                        @endif
                        />
                        <label class='form-check-label' for='flexSwitchCheckDefault'>完了を含む</label>
                    </div>
                    <select class='my-2' name='id' onchange='submit(this.form)'>
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
                    <radio></radio>
                </form>
            </div>

            <pre class="mermaid">
                mindmap
                    top((*))
                    @foreach($tree as $task)
                        <? echo preg_replace('/[0-9]*\//', "\t", $task['dep'])."\n" /** エスケープは""で囲む  **/ ?>
                    @endforeach
            </pre>
        </div>
    </div>

</div>
