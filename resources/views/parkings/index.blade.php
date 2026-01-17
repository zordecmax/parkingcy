@extends('layouts.app')

@section('title')
@endsection

@section('description')
@endsection

@section('keywords')
@endsection

@section('content')
<x-parkings.items :parkings="$parkings" />

@endsection