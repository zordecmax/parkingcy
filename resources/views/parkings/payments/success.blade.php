@extends('layouts.success-faill')

@section('title')
  Payment was successful
@endsection

@section('vite')
  @vite(['resources/scss/parkings/success-fail/success.scss', 'resources/js/app.js'])
@endsection

@section('content')
<section class="success-section d-flex justify-content-center align-items-center flex-grow-1">
 <div class="success-container pb-5">
    <svg class="success-icon " viewBox="0 0 96 96" aria-hidden="true">
      <g fill="currentColor">
        <circle cx="48" cy="48" r="48" opacity=".1"></circle>
        <circle cx="48" cy="48" r="31" opacity=".2"></circle>
        <circle cx="48" cy="48" r="15" opacity=".3"></circle>
        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M40 48.5l5 5 11-11"></path>
        <path transform="rotate(25.474 70.507 8.373)" opacity=".5" d="M68.926 4.12h3.159v8.506h-3.159z"></path>
        <path transform="rotate(-52.869 17.081 41.485)" opacity=".5" d="M16.097 36.336h1.969v10.298h-1.969z"></path>
        <path transform="rotate(82.271 75.128 61.041)" opacity=".5" d="M74.144 57.268h1.969v7.547h-1.969z"></path>
        <circle cx="86.321" cy="41.45" r="2.946" opacity=".5"></circle>
        <circle cx="26.171" cy="78.611" r="1.473" opacity=".5"></circle>
        <circle cx="49.473" cy="9.847" r="1.473" opacity=".5"></circle>
        <circle cx="10.283" cy="63" r="2.946" opacity=".2"></circle>
        <path opacity=".4" d="M59.948 88.142l10.558-3.603-4.888-4.455-5.67 8.058z"></path>
        <path opacity=".3" d="M18.512 19.236l5.667 1.456.519-8.738-6.186 7.282z"></path>
      </g>
    </svg>
    <div>
      <h1 class="pt-3">Payment was successful</h1>
     <div class="pt-3">
       <a href="{{ route('home') }}" class="btn btn-primary text-decoration-none text-white">Home</a>
      </div>
    </div>
  </div>
</section>
@endsection