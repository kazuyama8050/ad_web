<?php 
    $uri = $_SERVER['REQUEST_URI'];
    $splitUri = explode('/', $uri);
    $lastUri = $splitUri[count($splitUri) -1];
?>
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Vue Laravel SPA') }}</title>

    <!-- Styles -->
    {{-- bootstrap --}}
    <link href="{{ mix('/css/app.css') }}" rel="stylesheet">
</head>
<body>
<div id="app">
    
    @if ($lastUri !== 'login' && $lastUri !== 'register')
        <header-component></header-component>
    @endif

    <router-view></router-view>
</div>
<!-- Scripts -->
<script src="{{ mix('/js/app.js') }}" defer></script>
</body>
</html>