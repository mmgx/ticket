@extends('layouts.base')
@section('top_content')
    <div class="row">
        @foreach ($events as $event)
            <x-cards.shows href="{{ route('events.places', $event['id']) }}">
                <x-slot name="title">Id события: {{ $event['id'] }}</x-slot>
                <x-slot name="text">Дата: {{ $event['date'] }}</x-slot>
            </x-cards.shows>
        @endforeach
    </div>
@endsection
