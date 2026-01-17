@extends('layouts.app')

@section('vite')
    @vite(['resources/scss/airport.scss', 'resources/js/app.js'])
@endsection

@section('content')
    <form action="{{ route('parkings.airport.search.store', $airport) }}" method="POST">
        @csrf
        <div class="container d-flex justify-content-center">

            <div class="parking-box row">
                <div class="parking-form row col-12 ">
                    <div class="parking-info time-info  col-12 col-lg-5">
                        <div class="row">
                            <label class="form-label" for="start-date">PARKING FROM:</label>
                            <input class="data col-lg-6" type="date" id="start-date" name="start-date" required>
                            <input class="time col-lg-6" type="time" id="start-time" name="start-time" required
                                value="00:00">
                        </div>
                    </div>
                    <div class="parking-info time-info col-12 col-lg-5">
                        <div class="row">
                            <label class="form-label" for="end-date">PARKING TO:</label>
                            <input class="data col-lg-6" type="date" id="end-date" name="end-date" required>
                            <input class="time col-lg-6" type="time" id="end-time" name="end-time" required
                                value="00:00">
                        </div>
                    </div>
                    <div class="show-prices col-12 col-lg-2">
                        <button type="submit" class="btn btn-primary btn-block  show-prices-btn">CHECK PRICES</button>
                    </div>
                </div>
                <div class="col-12 check" style="background-color: #F6F6F6">
                    <div class="radio-box ">
                        <div class="">SHOW OFFERS FOR</div>
                        <label class="form-check-inline"><input class="radio-box-item" type="radio" name="parking"
                                value="transport">Parking lot with direct traffic</label>
                        <label class="form-check-inline"><input class="radio-box-item" type="radio" name="parking"
                                value="airport">Official airport parking lot</label>
                    </div>
                </div>

                <div class="box-choice " style="background-color:#343A48">
                    <div class="container-fluid row justify-content-around p-4">
                        <div class="col-6 col-md-3 row">
                            <div class="icon col-3">
                                <img src="{{ asset('images/award.svg') }}" alt="">
                            </div>
                            <div class="col-9 text-left d-flex align-items-center ">
                                <span class="text-white">Best price <b>guaranteed</b></span>
                            </div>

                        </div>
                        <div class="col-6 col-md-3  row">
                            <div class="icon col-3">
                                <img src="{{ asset('images/award.svg') }}" alt="">

                            </div>
                            <div class="col-9 text-left d-flex align-items-center ">
                                <span class="text-white">Book your spot <b>online</b></span>
                            </div>

                        </div>
                        <div class="col-6 col-md-3  row">
                            <div class="icon col-3">
                                <img src="{{ asset('images/award.svg') }}" alt="">

                            </div>
                            <div class="col-9 text-left d-flex align-items-center ">
                                <span class="text-white"> <b>Instant</b> booking confirmation</span>
                            </div>

                        </div>
                        <div class="col-6 col-md-3 row">
                            <div class="icon col-3">
                                <img src="{{ asset('images/award.svg') }}" alt="">
                            </div>
                            <div class="col-9 text-left d-flex align-items-center ">
                                <span class="text-white"><b>No credit card </b>needed</span>
                            </div>

                        </div>
                    </div>

                </div>
            </div>

        </div>
    </form>
@endsection
