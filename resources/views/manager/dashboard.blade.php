@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <div class="container">
        <div class="d-flex align-items-center justify-content-between">
            <h1>Dashboard</h1>
        </div>
    </div>
@stop


@section('content')
    <div class="container">
        <div class="row">

            <div class="row">
                <div class="col-12 col-md-6">

                    <x-adminlte-callout theme="info" class="d-flex justify-content-center align-items-center">
                        @if ($parking)
                            <div class="row no-gutters align-items-center ">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                        {{ __('manager/dashboard.filling') }}</div>
                                    <div class="row no-gutters align-items-center">
                                        <div class="col-auto">

                                            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                                {{ round($parking->occupancy_percentage) }}%
                                                ({{ $parking->available_spaces }} {{ __('manager/dashboard.available') }})
                                            </div>

                                        </div>
                                        <div class="col-12">
                                            <div class="progress progress-sm mr-2">

                                                <div class="progress-bar bg-info" role="progressbar"
                                                    style="width: {{ $parking->occupancy_percentage }}%;"
                                                    aria-valuenow="{{ $parking->occupancy_percentage }}" aria-valuemin="0"
                                                    aria-valuemax="100"></div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        @else
                            <p class="text-center">No parkings found.</p>
                        @endif

                    </x-adminlte-callout>
                </div>

                <div class="col-12 col-md-6">
                    <input type="hidden" id="parking_id" name="parking_id" value="{{ $parking ? $parking->id : '' }}">
                    <x-adminlte-callout theme="info"
                        class="d-flex justify-content-center align-items-center w-100 position-relative">
                        <input type="text" id="price" class="form-control me-2" name="price"
                            placeholder="Введите сумму" style="max-width: 300px;">
                        <div class="invalid-feedback d-none position-absolute" style="bottom:0px; left:0;" id="price-error">
                            Пожалуйста, введите корректную сумму.
                        </div>
                        <button type="button" id="generate-qr"
                            class="btn btn-primary text-decoration-none text-white ml-2">Получить QR
                            код</button>

                    </x-adminlte-callout>
                </div>



                @if ($parking)
                    <form action="{{ route('parkings.update', $parking->id) }}" method="POST" class="col-12">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="name" value="{{ $parking->name }}">
    <input type="hidden" name="latitude" value="{{ $parking->latitude }}">
    <input type="hidden" name="longitude" value="{{ $parking->longitude }}">
                        <div class="row">
                            <div class="col-12 col-md-6  col-xl-4">
                                <div class="col">
                                    <x-adminlte-callout theme="danger"
                                        class="row d-flex justify-content-center align-items-center p-0">
                                        <div class="row no-gutters align-items-center col-4">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                                    {{ __('manager/dashboard.price-day') }}
                                                </div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                    <span>{{ number_format($parking->price_per_day, 2) }}</span> $
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group mt-3 col-4">
                                            <input type="number" step="0.01" class="form-control" id="price_per_day"
                                                name="price_per_day" value="{{ $parking->price_per_day }}">
                                        </div>
                                        <button type="submit" class="btn btn-primary">{{ __('common.save') }}</button>

                                    </x-adminlte-callout>


                                </div>
                            </div>
                            <div class="col-12  col-md-6  col-xl-4">
                                <div class="col">
                                    <x-adminlte-callout theme="danger"
                                        class="row d-flex justify-content-center align-items-center p-0">
                                        <div class="row no-gutters align-items-center col-4">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                                    {{ __('manager/dashboard.price-hour') }}
                                                </div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                    <span>{{ number_format($parking->price_per_hour, 2) }}</span> $
                                                </div>
                                            </div>

                                        </div>
                                        <div class="form-group mt-3 col-4">
                                            <input type="number" step="0.01" class="form-control" id="price_per_hour"
                                                name="price_per_hour" value="{{ $parking->price_per_hour }}">
                                        </div>
                                        <button type="submit" class="btn btn-primary">{{ __('common.save') }}</button>

                                    </x-adminlte-callout>

                                </div>
                            </div>
                            <div class="col-12 col-lg-4">


                                <div class="col">
                                    <x-adminlte-callout theme="danger"
                                        class="row d-flex justify-content-center align-items-center p-0">
                                        <div class="row no-gutters align-items-center col-4">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                                    {{ __('manager/dashboard.parking-status') }}
                                                </div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                    <span>{{ $parking->active ? __('manager/dashboard.active') : __('manager/dashboard.inactive') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group mt-3 col-4">
                                            <input type="hidden" name="active" value="0">
                                            <input type="checkbox" class="form-control" id="active" name="active"
                                                value="1" {{ $parking->active ? 'checked' : '' }}>
                                        </div>
                                        <button type="submit" class="btn btn-primary">{{ __('common.save') }}</button>
                                    </x-adminlte-callout>
                                </div>
                            </div>
                            <div class="col-12 col-lg-4">
                                <div class="col">
                                    <x-adminlte-callout theme="danger"
                                        class="row d-flex justify-content-center align-items-center p-0">
                                        <div class="row align-items-center col-4">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                                    {{ __('manager/dashboard.tarif') }}
                                                </div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                    <span>{{ $parking->tariff }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group ml-3 mt-3 col-4">
                                            <input type="text" class="form-control" id="tariff" name="tariff"
                                                value="{{ $parking->tariff }}">
                                        </div>
                                        <button type="submit" class="btn btn-primary">{{ __('common.save') }}</button>

                                    </x-adminlte-callout>
                                </div>

                            </div>
                            <div class="col-12 col-lg-4">

                                <div class="col">
                                    <x-adminlte-callout theme="danger"
                                        class="row d-flex justify-content-center align-items-center p-0">
                                        <div class="row no-gutters align-items-center col-4">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                                    {{ __('manager/dashboard.bank-card') }}
                                                </div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                                    <span>{{ $parking->can_pay_by_card ? __('manager/dashboard.active') : __('manager/dashboard.inactive') }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group mt-3 col-4">
                                            <input type="hidden" name="can_pay_by_card" value="0">
                                            <input type="checkbox" class="form-control" id="can_pay_by_card"
                                                name="can_pay_by_card" value="1"
                                                {{ $parking->can_pay_by_card ? 'checked' : '' }}>
                                        </div>
                                        <button type="submit" class="btn btn-primary">{{ __('common.save') }}</button>
                                    </x-adminlte-callout>
                                </div>

                            </div>
                        </div>
                    </form>
                @endif

                <div class="col-12">
                    <x-adminlte-callout theme="info" title="Information">
                        {{-- <div class="d-flex justify-content-end mb-2">
            <a href="{{ route('parkings.create') }}" class="btn btn-primary text-white">{{ __('common.add') }}</a>
        </div> --}}
                        @if ($parking)
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-12 col-md-6">
                                            <h5 class="card-title">{{ __('name') }}</h5>
                                            <p class="card-text">{{ $parking->name }}</p>
                                            <h6 class="card-subtitle mb-2 text-muted">{{ __('Address') }}</h6>
                                            <p class="card-text">{{ $parking->address }}</p>
                                            <h6 class="card-subtitle mb-2 text-muted">{{ __('Phone') }}</h6>
                                            <p class="card-text">{{ $parking->phone }}</p>
                                        </div>
                                        <div class="col-12 col-md-6 mt-3 mt-md-0">
                                            <h6 class="card-subtitle mb-2 text-muted">{{ __('description') }}</h6>
                                            <p class="card-text">{{ $parking->description }}</p>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-end">
                                        <a href="{{ route('parkings.edit', $parking->id) }}" class="btn btn-primary me-2"
                                            style="color: white;">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                <path
                                                    d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                                <path fill-rule="evenodd"
                                                    d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                                            </svg>
                                        </a>
                                        {{-- <a href="#" class="btn btn-danger" style="color: white;" onclick="event.preventDefault(); document.getElementById('parking-delete-{{ $parking->id }}').submit();">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-square" viewBox="0 0 16 16">
        <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"/>
        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z"/>
    </svg>
</a> --}}

                                        <form action="{{ route('parkings.destroy', $parking->id) }}" method="POST"
                                            id="parking-delete-{{ $parking->id }}">
                                            @csrf
                                            @method('delete')
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @else
                            <p class="text-center">No parkings found.</p>
                        @endif


                    </x-adminlte-callout>
                </div>
            </div>


        </div>
    </div>




@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script>
        document.getElementById('generate-qr').addEventListener('click', () => {
            const priceInput = document.getElementById('price');
            const priceError = document.getElementById('price-error');
            const price = priceInput.value;
            const parkingId = document.getElementById('parking_id').value;

            priceInput.classList.remove('is-invalid');
            priceError.classList.add('d-none');

            if (!price || isNaN(price)) {
                priceInput.classList.add('is-invalid');
                priceError.classList.remove('d-none');
                return;
            }

            fetch(`/api/parkings/${parkingId}/payment`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute(
                            'content')
                    },
                    body: JSON.stringify({
                        price
                    })
                }).then(response => response.json())
                .then(data => {
                    if (data.error === 0) {
                        const modalContainer = document.createElement('div');
                        modalContainer.innerHTML = data.data.modal;
                        document.body.appendChild(modalContainer);
                        $('#qrModal').modal('show');
                    } else {
                        console.error('Error generating QR code:', data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        })
    </script>
@stop
