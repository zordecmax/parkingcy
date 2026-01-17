@extends('adminlte::page')

@section('content')
    <h1>{{ $parking->name }}</h1>
    <p>Отсканируйте QR-код, чтобы перейти к оплате:</p>
    @if (isset($session_url) && is_string($session_url))
        {{ QrCode::size(300)->generate($session_url) }}
        <p class="mt-3">Или перейдите по <a href="{{ $session_url }}">этой ссылке</a>.</p>
    @endif
@endsection
