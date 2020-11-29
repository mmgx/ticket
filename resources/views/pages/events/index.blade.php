@extends('layouts.base')
@section('top_content')
    <div class="row">
        @foreach ($shows as $show)
            <x-cards.shows href="{{ route('shows.show', $show['id']) }}">
                <x-slot name="title">Id мероприятия: {{ $show['id'] }}</x-slot>
                <x-slot name="text">Название: {{ $show['name'] }}</x-slot>
            </x-cards.shows>
        @endforeach
    </div>
@endsection
