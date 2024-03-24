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

        <pre class="mermaid">
            mindmap
                top({{$top}})
                @foreach($tree as $task)
                    <? echo preg_replace('/[0-9]*\//', "\t", $task['dep'])."\n" /** エスケープは""で囲む  **/ ?>
                @endforeach
        </pre>
    </div>

</div>
