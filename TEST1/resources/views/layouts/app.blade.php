<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'すがのサイト') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/reset.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        
        <main class="py-4">
            <div class="system-title">
                @yield('title') 
            </div>
            <div class="system__containar">
                <div class="system__customer-name">得意先名：{{$customer}}</div>
                <div class="system__description">@yield('description') </div>
                @yield('content')
                <div class="system-back">
                        <a class="back-button" href="{{url('/')}}">戻る</a>
                </div>  
             </div>
        </main>
    </div>
</body>
</html>