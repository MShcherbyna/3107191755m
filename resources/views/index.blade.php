<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>address ::: user office ::: foodclub</title>

        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700,700italic,400italic&subset=latin,latin-ext' rel='stylesheet' type='text/css'>
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Styles -->
        <link href="{{ asset('css/default.css') }}" rel="stylesheet">
    </head>
    <body>
        <div id="app">
            <div class="cbc">
                <app-component></app-component>
            </div>
        </div>

        <script src="/js/app.js"></script>
    </body>
</html>
