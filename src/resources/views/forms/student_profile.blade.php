@extends('layout')

@php
    $title = $action == 'create' ? 'Создание анкеты' : 'Редактирование анкеты';
    $submit = $action == 'create' ? 'Отправить анкету' : 'Сохранить анкету';
    $url = $action == 'create' ? route('profiles.store') : route('profiles.update', $profile);
@endphp

@section('title', $title.' - Приемная комиссия')
@section('header', $title)

@section('content')
    <div class="page-form">
        <form method="post" action="{{ $url }}">
            @csrf

            <input type="hidden" name="type" value="{{ $profile->type }}">

            <div class="mb-3">
                <label class="form-label">ФИО абитуриента</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" placeholder="Иванов Иван Иванович" value="{{ $profile->name }}">
                @error('name')
                    <div class="form-text text-danger">Поле должно быть заполнено</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Пол</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="gender" value="m" @if($profile->gender == 'm') checked @endif>
                    <label class="form-check-label" for="flexRadioDefault1">
                        Мужской
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="gender" value="f" @if($profile->gender == 'f') checked @endif>
                    <label class="form-check-label" for="flexRadioDefault2">
                        Женский
                    </label>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Номер телефона для связи</label>
                <input type="text" class="form-control @error('phone') is-invalid @enderror" name="phone" placeholder="+7 999 111-22-33" value="{{ $profile->phone }}">
                @error('phone')
                    <div class="form-text text-danger">Поле должно быть заполнено</div>
                @enderror
            </div>

            <div>
                <button class="btn btn-success" type="submit">{{ $submit }}</button>
            </div>

        </form>
    </div>
@endsection
