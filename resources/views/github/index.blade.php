<div>
    <header>
        @include('header')
        <script src='https://cdn.jsdelivr.net/npm/mermaid@10.9.0/dist/mermaid.min.js'></script>
    </header>

    <div @style(['height: 80%']) @class([
        'container',
        'align-items-center',
        'justify-content-center'
    ])>
        <div class='container'>
        </div>
        <pre class="mermaid">
            ---
            config:
                xyChart:
                    width: 1000
                    height: 400
                themeVariables:
                    xyChart:
                        titleColor: "#ff0000"
            ---
            xychart-beta
                title "Github活動"
                x-axis [{{implode(',', $day)}}]
                bar [{{implode(',', $cnt)}}]
                line [{{implode(',', $cnt)}}]
        </pre>
    </div>
</div>
