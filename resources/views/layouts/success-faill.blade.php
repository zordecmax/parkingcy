<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>
    <!-- Meta Tags -->
    <meta name="description" content="@yield('description')">
    <meta name="keywords" content="@yield('keywords')">

    @yield('meta')
    <title>@yield('title')</title>
    @yield('vite')
</head>
<body>
 <x-logo/>

 @yield('content')

 </body>
</html>
