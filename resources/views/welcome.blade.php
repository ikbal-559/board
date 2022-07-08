<html>
<head>
    <title>Kanban Board</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script>window.Laravel = { csrfToken: '{{ csrf_token() }}' }</script>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div id="app">
        <board-component></board-component>
    </div>


<script src="{{ asset('js/app.js') }}"></script>
</body>
</html>


