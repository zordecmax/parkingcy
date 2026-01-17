@extends('layouts.base')

@section('title')
    Parking Cyprus
@endsection

@section('description')
    Welcome to Parking Cyprus
@endsection

@section('keywords')
    parking, Cyprus, car park
@endsection

@section('vite')
    @viteReactRefresh
    @vite(['resources/scss/home.scss', 'resources/js/home.js'])
@endsection

@section('content')
    <div id="parking"></div>
@endsection
