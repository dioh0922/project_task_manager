<div>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{$title}}</title>
        @include('style_cdn')
    </head>
    <div @style([
        'padding: 10px',
        'text-align: center',
        'background: #1abc9c',
        'color: white',
        'font-size: 30px',
        'margin-bottom: 10px'
    ])>{{$title}}</div>
</div>
