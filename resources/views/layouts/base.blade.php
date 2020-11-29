@extends('layouts.app')
@section('styles')
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
@stop
@yield('custom_styles')

@section('scripts')
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
@endsection

@yield('custom_head_scripts')

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
