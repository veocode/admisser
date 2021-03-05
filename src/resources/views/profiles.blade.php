@extends('layout')

@section('title', 'Список анкет - Приемная комиссия')
@section('header', 'Список анкет')

@section('content')

    <table class="table table-bordered table-responsive-lg">
        <tr>
            <th>@sorthead('id', '#')</th>
            <th>@sorthead('created_at', 'Дата')</th>
            <th>@sorthead('name', 'Имя')</th>
            <th>@sorthead('type', 'Класс')</th>
            <th>@sorthead('gender', 'Пол')</th>
            <th>@sorthead('phone', 'Телефон')</th>
            <th width="80px">Действия</th>
        </tr>
        <form action="" method="get">
            <input type="hidden" name="sort" value="{{ $sort }}">
            <input type="hidden" name="order" value="{{ $order }}">
            <tr>
                <td>&nbsp;</td>
                <th>{!! \App\Models\StudentProfile::fieldFilter('created_at') !!}</th>
                <th>{!! \App\Models\StudentProfile::fieldFilter('name') !!}</th>
                <th>{!! \App\Models\StudentProfile::fieldFilter('type') !!}</th>
                <th>{!! \App\Models\StudentProfile::fieldFilter('gender') !!}</th>
                <th>{!! \App\Models\StudentProfile::fieldFilter('phone') !!}</th>
                <th>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-filter"></i></button>
                </th>
            </tr>
        </form>
        @foreach ($profiles as $profile)
            <tr>
                <td>{{ $profile->id }}</td>
                <td>{{ date_format($profile->created_at, 'd.m.Y H:i') }}</td>
                <td><a href="{{ route('profiles.show', $profile->id) }}">{{ $profile->name }}</a></td>
                <td>{{ $profile->type }}</td>
                <td>{{ $profile->fieldValue('gender') }}</td>
                <td>{{ $profile->phone }}</td>
                <td>
                    <form action="{{ route('profiles.destroy', $profile->id) }}" method="POST">

                        <a href="{{ route('profiles.edit', $profile->id) }}" title="Редактировать">
                            <i class="fa fa-edit fa-lg"></i>
                        </a>

                        @csrf

                        <button type="submit" title="Удалить" style="border: none; background-color:transparent;">
                            <i class="fa fa-trash fa-lg text-danger"></i>
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
    </table>

    {!! $links !!}

    <div class="mt-4">
        <small><a href="/logout">Выйти</a></small>
    </div>

@endsection
