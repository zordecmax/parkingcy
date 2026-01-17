@extends('layouts.app')

@section('vite')
    @vite(['resources/scss/search.scss', 'resources/js/app.js'])
@endsection

@section('content')
    <div class="container">
        <div class="row d-flex flex-wrap">
            @foreach ($airport->parkings as $parking)
                <div class="col-12 col-sm-6 col-lg-4 pt-4">
                    <div class="d-flex justify-content-center">
                        <div class="row box text-center">
                            <div class="info-box-title col-12">{{ $parking->name }}</div>
                            <div class="col-12">
                                <div class="row parking-box-content">
                                    <x-parkings.airports.search.icons :parking="$parking" />
                                    @if ($parking->is_long_range)
                                        <div class="transfer-time">
                                            <div class="transfer-title">
                                                <img src="{{ asset('images/search/car.svg') }}" alt="Icon"
                                                    class="svg-icon">
                                                Long-term parking
                                            </div>
                                            <div class="transfer-time-description">
                                                This parking lot is designed for long term storage
                                            </div>
                                        </div>
                                    @else
                                        <div class="transfer-title">
                                            <img src="{{ asset('images/search/driving-time.svg') }}" alt="Icon"
                                                class="svg-icon">
                                            No long-term parking
                                        </div>
                                        <div class="transfer-time-description">
                                            Parking is not intended for long term storage
                                        </div>
                                    @endif
                                    <div class="price">
                                        {{ $parking->total_price }}$
                                    </div>
                                    <button class="btn btn-primary button-more-info rounded-0" data-bs-toggle="modal"
                                        data-bs-target="#parking-card-modal-{{ $parking->id }}">MORE INFO</button>
                                    <div class="modal fade modal-item" id="parking-card-modal-{{ $parking->id }}"
                                        tabindex="-1" aria-labelledby="parking-card-label" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <div class="modal-title-info d-flex flex-column">
                                                        <div class="d-flex flex-start modal-title">
                                                            {{ $parking->name }}</div>
                                                        <div class="d-flex flex-start">
                                                            Total spaces:{{ $parking->total_spaces }}</div>
                                                        <div class="d-flex flex-start">
                                                            Available spaces:{{ $parking->available_spaces }}</div>
                                                    </div>
                                                    <button type="button" class="btn-close btn-close-modal"
                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body p-0">
                                                    <div class="row">
                                                        <div class="col-12 col-sm-12">
                                                            <div class="row">
                                                                <div class="col-12 information">
                                                                    <div class="general">
                                                                        <div class="d-flex flex-start information-title">
                                                                            GENERAL</div>
                                                                        <div class="d-flex flex-start information-item">
                                                                            DESCRIPTION</div>
                                                                        <div class="information-description">
                                                                            @if (isset($parking->description))
                                                                                {{ $parking->description }}
                                                                            @else
                                                                                No description
                                                                            @endif
                                                                        </div>
                                                                        <div class="d-flex flex-start information-item">
                                                                            USEFUL INFORMATION</div>
                                                                        <x-parkings.airports.search.icons-modal
                                                                            :parking="$parking" />
                                                                        <div class="d-flex flex-start information-item">
                                                                            OPERATING HOURS</div>
                                                                        <div class="schedule">
                                                                            {!! renderSchedule($parking) !!}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <div
                                                        class=" total-price-modal d-flex align-items-center flex-start p-0">
                                                        {{ $parking->total_price }}$
                                                    </div>
                                                    <div class="ps-1">
                                                        {{-- <button type="submit"
                                                                class="btn btn-primary p-3">Reservation</button> --}}
                                                        <button class="btn btn-primary"
                                                            data-bs-target="#exampleModalToggle2-{{ $parking->id }}"
                                                            data-bs-toggle="modal"
                                                            data-bs-dismiss="modal">Reservation</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade" id="exampleModalToggle2-{{ $parking->id }}" aria-hidden="true"
                    aria-labelledby="exampleModalToggleLabel2" tabindex="-1">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalToggleLabel2">Reservation</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form
                                    action="{{ route('reservations.store', ['airport' => $airport, 'parking' => $parking]) }}"
                                    method="POST">
                                    @csrf
                                    <label class="form-label w-100">
                                        <span class="d-block mb-1">Name</span>
                                        <input type="text" name="name" class="form-control w-100"
                                            placeholder="Enter your name ...">
                                    </label>
                                    <label class="form-label w-100">
                                        <span class="d-block mb-1">Phone</span>
                                        <input type="text" name="phone" class="form-control w-100"
                                            placeholder="Enter your phone ...">
                                    </label>
                                    <label class="form-label w-100">
                                        <span class="d-block mb-1">Email</span>
                                        <input type="email" name="email" class="form-control w-100"
                                            placeholder="Enter your email ...">
                                    </label>
                                    <label class="form-label w-100">
                                        <span class="d-block mb-1">Car Number</span>
                                        <input type="text" name="car_number" class="form-control w-100"
                                            placeholder="Enter your car number ...">
                                    </label>
                                    <label class="form-label w-100">
                                        <span class="d-block mb-1">Car Model</span>
                                        <input type="text" name="car_model" class="form-control w-100"
                                            placeholder="Enter your car model ...">
                                    </label>
                                    <label class="form-label w-100">
                                        <span class="d-block mb-1">Car Color</span>
                                        <input type="text" name="car_color" class="form-control w-100"
                                            placeholder="Enter your car color ...">
                                    </label>
                                    <label class="form-label w-100">
                                        <span class="d-block mb-1">Payment Method</span>
                                        <select name="payment_method" class="form-control w-100" required>
                                            <option value="cash">Cash</option>
                                            <option value="online">Online</option>
                                        </select>
                                    </label>
                                    <input type="hidden" name="price" value="{{ $parking->total_price }}">
                                    <div class="d-flex align-items-center justify-content-end">
                                        <button type="submit" class="btn btn-primary d-block">Reservation</button>
                                    </div>
                                </form>
                            </div>
                            {{-- <div class="modal-footer">
                                <button class="btn btn-primary" data-bs-target="#parking-card-modal-{{ $parking->id }}"
                                    data-bs-toggle="modal" data-bs-dismiss="modal">Back to first</button>
                            </div> --}}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
