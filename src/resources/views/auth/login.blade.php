@extends('layout')

@section('title', 'Приемная комиссия')
@section('header', 'Вход администратора')

@section('content')

    <form method="POST" action="{{ route('login') }}">
    @csrf
        <div class="form-group">
            <label>E-mail</label>
            <input type="email" name="email" class="form-control">
        </div>
        <div class="form-group">
            <label>Пароль</label>
            <input type="password" name="password" class="form-control">
        </div>
        <button type="submit" class="btn btn-primary">Войти</button>
    </form>

@endsection
