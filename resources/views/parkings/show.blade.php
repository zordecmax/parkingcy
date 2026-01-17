@extends('layouts.app')
@section('content')
    @if (isset($parking))
        <div class="container">
            <div class="d-flex justify-content-end w-100">
                <a href="{{ route('parkings.payment.show', $parking) }}" class="btn btn-primary">Pay</a>
            </div>
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" class="form-control" id="name"
                    value="{{ isset($parking->name) ? $parking->name : 'N/A' }}" readonly>
            </div>
            <div class="form-group">
                <label for="description">Description:</label>
                <input type="text" class="form-control" id="description"
                    value="{{ isset($parking->description) ? $parking->description : 'N/A' }}" readonly>
            </div>
            <div class="form-group">
                <label for="latitude">Latitude:</label>
                <input type="text" class="form-control" id="latitude"
                    value="{{ isset($parking->latitude) ? $parking->latitude : 'N/A' }}" readonly>
            </div>
            <div class="form-group">
                <label for="longitude">Longitude:</label>
                <input type="text" class="form-control" id="longitude"
                    value="{{ isset($parking->longitude) ? $parking->longitude : 'N/A' }}" readonly>
            </div>
            <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" class="form-control" id="address"
                    value="{{ isset($parking->address) ? $parking->address : 'N/A' }}" readonly>
            </div>
            <div class="form-group">
                <label for="phone">Phone:</label>
                <input type="text" class="form-control" id="phone"
                    value="{{ isset($parking->phone) ? $parking->phone : 'N/A' }}" readonly>
            </div>
            <div class="form-group">
                <label for="total_spaces">Total Spaces:</label>
                <input type="text" class="form-control" id="total_spaces"
                    value="{{ isset($parking->total_spaces) ? $parking->total_spaces : 'N/A' }}" readonly>
            </div>
            <div class="form-group">
                <label for="available_spaces">Available Spaces:</label>
                <input type="text" class="form-control" id="available_spaces"
                    value="{{ isset($parking->available_spaces) ? $parking->available_spaces : 'N/A' }}" readonly>
            </div>
            <div class="form-group">
                <label for="handicap_accessible">Handicap Accessible:</label>
                <input type="text" class="form-control" id="handicap_accessible"
                    value="{{ isset($parking->handicap_accessible) ? $parking->handicap_accessible : 'N/A' }}" readonly>
            </div>
            <div class="form-group">
                <label for="electric_charging_stations">Electric Charging Stations:</label>
                <input type="text" class="form-control" id="electric_charging_stations"
                    value="{{ isset($parking->electric_charging_stations) ? $parking->electric_charging_stations : 'N/A' }}"
                    readonly>
            </div>
            <div class="form-group">
                <label for="can_pay_by_card">Can Pay by Card:</label>
                <input type="text" class="form-control" id="can_pay_by_card"
                    value="{{ isset($parking->can_pay_by_card) ? ($parking->can_pay_by_card ? 'Yes' : 'No') : 'N/A' }}"
                    readonly>
            </div>
            <div class="form-group">
                <label for="charging_speed">Charging Speed:</label>
                <input type="text" class="form-control" id="charging_speed"
                    value="{{ isset($parking->charging_speed) ? $parking->charging_speed : 'N/A' }}" readonly>
            </div>
            <div class="form-group">
                <label for="price_per_hour">Price per Hour:</label>
                <input type="text" class="form-control" id="price_per_hour"
                    value="{{ isset($parking->price_per_hour) ? $parking->price_per_hour : 'N/A' }}" readonly>
            </div>
            <div class="form-group">
                <label for="price_per_day">Price per Day:</label>
                <input type="text" class="form-control" id="price_per_day"
                    value="{{ isset($parking->price_per_day) ? $parking->price_per_day : 'N/A' }}" readonly>
            </div>
            <div class="form-group">
                <label for="tariffs">Tariffs:</label>
                <input type="text" class="form-control" id="tariffs"
                    value="{{ isset($parking->tariffs) ? json_encode($parking->tariffs) : 'N/A' }}" readonly>
            </div>
            <div class="form-group">
                <label for="link">Link:</label>
                <input type="text" class="form-control" id="link"
                    value="{{ isset($parking->link) ? $parking->link : 'N/A' }}" readonly>
            </div>
            <div class="form-group">
                <label for="max_vehicle_height">Max Vehicle Height:</label>
                <input type="text" class="form-control" id="max_vehicle_height"
                    value="{{ isset($parking->max_vehicle_height) ? $parking->max_vehicle_height : 'N/A' }}" readonly>
            </div>
            <div class="form-group">
                <label for="active">Active:</label>
                <input type="text" class="form-control" id="active"
                    value="{{ isset($parking->active) ? ($parking->active ? 'Yes' : 'No') : 'N/A' }}" readonly>
            </div>
        @else
            <p>parking not found.</p>
    @endif
    </div>
@endsection
