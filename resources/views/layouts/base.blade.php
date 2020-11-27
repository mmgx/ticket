@extends('layouts.app')
@section('head_styles')
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
@stop

@section('head_scripts')
    <script src="{{ asset('js/app.js') }}" defer></script>
@stop
@section('body')
    @include('parts.menu')
    <main role="main">
        <div class="jumbotron">
            <div class="container">
                @yield('top_content')
            </div>
        </div>
        <div class="container">
            @yield('content')
        </div>
    </main>
@stop
