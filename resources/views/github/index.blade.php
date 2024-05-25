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
                    width: 1500
                    height: 500
                    xAxis:
                        showLabel: false
                        showTick: false
                themeVariables:
                    xyChart:
                        titleColor: "#ff0000"
            ---
            xychart-beta
                title "Github活動：{{$day[0]}}～{{end($day)}}"
                x-axis [{{implode(',', $day)}}]
                bar [{{implode(',', $cnt)}}]
                line [{{implode(',', $cnt)}}]
        </pre>
    </div>
</div>
