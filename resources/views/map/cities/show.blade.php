@extends('layouts.base')

@section('title')
    {{ __('parking/cities.meta_title', ['name' => $city->name]) }}
@endsection

@section('description')
    {{ __('parking/cities.meta_description', ['name' => $city->name]) }}
@endsection

@section('keywords')
    {{ __('parking/cities.meta_keywords') }}
@endsection

@section('vite')
    @viteReactRefresh
    @vite(['resources/scss/home.scss', 'resources/js/home.js'])
@endsection

@section('meta')
    <meta name="coordinates" content="{{ json_encode(['lat' => $city->latitude, 'lng' => $city->longitude]) }}">
@endsection

@section('content')
    <div id="parking"></div>
@endsection
