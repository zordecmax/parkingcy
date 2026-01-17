@extends('layouts.success-faill')

@section('title')
  Payment failed
@endsection

@section('vite')
  @vite(['resources/scss/parkings/success-fail/fail.scss', 'resources/js/app.js'])
@endsection

@section('content')
<section class="fail-section d-flex justify-content-center align-items-center">
  <div class="fail-container">
  <svg class="fail-icon" viewBox="0 0 96 96" aria-hidden="true">
  <g fill="red" stroke="red">
    <circle cx="48" cy="48" r="48" opacity=".1"></circle>
    <circle cx="48" cy="48" r="31" opacity=".2"></circle>
    <circle cx="48" cy="48" r="15" opacity=".3"></circle>
    <path fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M35 35l26 26M35 61l26-26"></path>
    <circle cx="86.321" cy="41.45" r="2.946" opacity=".5"></circle>
    <circle cx="26.171" cy="78.611" r="1.473" opacity=".5"></circle>
    <circle cx="49.473" cy="9.847" r="1.473" opacity=".5"></circle>
    <circle cx="10.283" cy="63" r="2.946" opacity=".2"></circle>
    <path opacity=".4" d="M59.948 88.142l10.558-3.603-4.888-4.455-5.67 8.058z"></path>
    <path opacity=".3" d="M18.512 19.236l5.667 1.456.519-8.738-6.186 7.282z"></path>
  </g>
</svg>
    <div>
     <h1 class="pt-3">Payment failed</h1>
        <p class="have-question">Have a question?<br/><a href="{{ route('contacts') }}">Contact Support</a></p>
          <div class="pt-3">
           <a href="{{ route('home') }}" class="btn btn-primary text-decoration-none text-white">Home</a>
          </div>
     </div>
  </div>
</section>
@endsection