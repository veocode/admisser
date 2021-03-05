@extends('layout')

@section('title', 'Приемная комиссия')
@section('header', 'Подать заявку на поступление')

@section('content')

    <div class="home-type-selector">
        <div class="buttons">
            <a class="btn btn-large btn-primary" href="{{ route('profiles.create', ['type' => 9]) }}">После 9-го класса</a>
            <a class="btn btn-large btn-primary" href="{{ route('profiles.create', ['type' => 11]) }}">После 11-го класса</a>
        </div>
    </div>

    <div class="mt-4">
        <small><a href="/login">Вход для администратора</a></small>
    </div>

@endsection
