@extends('layout')

@section('title', 'Анкета - Приемная комиссия')
@section('header', "Анкета #{$profile->id}")

@section('content')

    <table class="table table-bordered table-responsive-lg mt-3">
        @foreach ($fields as $name => $opts)
            <tr>
                <td style="font-weight: bold; width: 250px">{{ $profile->fieldTitle($name) }}</td>
                <td>{{ $profile->fieldValue($name) }}</td>
            </tr>
        @endforeach
    </table>

    <a class="btn btn-primary" href="javascript:history.go(-1)">Назад</a>

@endsection