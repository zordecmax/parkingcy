@extends('adminlte::page')

@section('title', 'Manage Parking')

@php
    $heads = ['ID', 'QR code', 'Check in', 'Check out','Spot','License plate', 'Model', 'Color','Amount','Paid Status', 'Actions'];
@endphp

@section('content_header')
    <h1>Manage Parking</h1>
@stop
@vite(['resources/scss/parkings/reservations/index.scss'])
@section('content')
    <x-adminlte-datatable id="table1" :heads="$heads">
          <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#create-manage-modal">
            Create
          </button>
          @if ($errors->any())
              <div class="alert alert-danger">
                 <ul>
                   @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                   @endforeach
                 </ul>
               </div>
              @endif
        @foreach ($parking->parking_services as $parking_service)
            <tr>
                <td data-label="ID">{{ $parking_service->id }}</td>
                <td data-label="Qr code">
                    @if (!$parking_service->invoice->paid->value)
                        <button class="btn btn-primary open-qr-modal"
                                data-title="{{ $parking->name }}"
                                data-url="{{ $parking_service->invoice->payment_link }}"
                                data-toggle="modal"
                                data-target="#qrModal{{ $parking_service->id }}">
                            Pay
                        </button>
                    @endif
                </td>
                <td data-label="Check in">{{ $parking_service->parking_start_time }}</td>
                <td data-label="Check out">
                     {{$parking_service->parking_end_time}}
                </td>
                <td data-label="Spot">{{ $parking_service->parking_spot}}</td>
                <td data-label="License plate">{{ $parking_service->license_plate }}</td>
                <td data-label="Model">{{ $parking_service->model }}</td>
                <td data-label="Color">{{ $parking_service->color }}</td>
                <td data-label="Amount">{{ $parking_service->invoice->amount }}</td>
                <td data-label="Paid Status">
                    <span class="badge badge-{{ $parking_service->invoice->paid->color() }}">{{ $parking_service->invoice->paid->label() }}</span>
                </td>
                <td class="button-line">
                    <nobr>
                    <a href="#" class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit" data-toggle="modal" data-target="#edit-manage-modal{{ $parking_service->id }}">
                      <i class="fa fa-lg fa-fw fa-pen"></i>
                     </a>
                    <form action="{{ route('parkings.services.destroy', ['service' => $parking_service->id]) }}" style="display: inline" method="POST">
                      @csrf
                      @method('DELETE')
                       <button type="submit" class="btn btn-xs btn-default text-danger mx-1 shadow" title="Delete">
                         <i class="fa fa-lg fa-fw fa-trash"></i>
                       </button>
                     </form>
                    </nobr>
                </td>
            </tr>
            <div class="modal fade" id="edit-manage-modal{{ $parking_service->id }}" tabindex="-1" role="dialog" aria-labelledby="edit-manage-modal-label{{ $parking_service->id }}" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content modal-scroll">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="edit-manage-modal-label{{ $parking_service->id }}">Edit</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="{{ route('parkings.services.update', ['service' => $parking_service->id,'parking' => $parking_service->parking_id]) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                      <div class="row">
                                        <div class="col-12 col-sm-6">
                                          <x-parkings.reservations.form-update name="license_plate" label="License plate" :value="$parking_service->license_plate" :error="$errors->first('license_plate')" />
                                        </div>
                                        <div class="col-12 col-sm-6">
                                          <x-parkings.reservations.form-update  name="model" label="Model" :value="$parking_service->model" :error="$errors->first('model')" />
                                        </div>
                                     </div> 
                                     <div class="row">
                                        <div class="col-12 col-sm-6">
                                          <x-parkings.reservations.form-update name="color" label="Color" :value="$parking_service->color" :error="$errors->first('color')" />
                                        </div>
                                        <div class="col-12 col-sm-6">
                                          <label for="paid">Paid Status</label>
                                           <select name="paid" class="form-control"
                                             onchange="updatePaymentStatus({{ $parking_service->id }}, this.value)" required>
                                           @foreach (App\Enums\PaymentEnum::getValues() as $value => $label)
                                            <option value="{{ $value }}"
                                            {{ $parking_service->invoice->paid->value == $value ? 'selected' : '' }}>
                                             {{ $label }}
                                            </option>
                                            @endforeach
                                           </select>
                                         </div>
                                     </div> 
                                     <div class="row">
                                        <div class="col-12 col-sm-6">
                                           <x-parkings.reservations.form-update type="datetime-local" name="parking_start_time" label="Check in" :value="$parking_service->parking_start_time" :error="$errors->first('parking_start_time')" />
                                        </div>
                                        <div class="col-12 col-sm-6">
                                           <x-parkings.reservations.form-update type="datetime-local" name="parking_end_time" label="Check out" :value="$parking_service->parking_end_time" :error="$errors->first('parking_time_end')"/>
                                        </div>
                                     </div>
                                     <div class="row">
                                        <div class="col-12 col-sm-6">
                                          <x-parkings.reservations.form-update type="number" name="amount" label="Amount" :value="$parking_service->invoice->amount" :error="$errors->first('amount')" />
                                        </div>
                                        <div class="col-12 col-sm-6">
                                          <x-parkings.reservations.form-update name="parking_spot" label="Spot" :value="$parking_service->parking_spot" :error="$errors->first('parking_spot')" />
                                        </div>
                                     </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="qrModal{{ $parking_service->id }}" tabindex="-1" role="dialog"
                 aria-labelledby="qrModalLabel{{ $parking_service->id }}" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="qrModalLabel{{ $parking_service->id }}">QR Code Payment</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body text-center">
                            <h4>{{ $parking->name }}</h4>
                            <p>Отсканируйте QR-код для оплаты:</p>
                            {!! QrCode::size(300)->generate($parking_service->invoice->payment_link) !!}
                            <p class="mt-3">Или перейдите по <a href="{{ $parking_service->invoice->payment_link }}">этой ссылке</a>.</p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
                 <div class="modal fade" id="create-manage-modal" tabindex="-1" role="dialog" aria-labelledby="create-manage-modal-label" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content modal-scroll">
                      <div class="modal-header">
                        <h5 class="modal-title" id="create-manage-modal-label">Create</h5>
                         <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                           <span aria-hidden="true">&times;</span>
                          </button>
                            </div>
                               <form action="{{ route('parkings.services.store', $parking->id) }}" method="POST">
                                   @csrf
                                   <div class="modal-body">
                                    <div class="row">
                                        <div class="col-12 col-sm-6">
                                          <x-parkings.reservations.form-update name="license_plate" label="License plate" :value="old('license_plate')" :error="$errors->first('license_plate')" />
                                        </div>
                                        <div class="col-12 col-sm-6">
                                          <x-parkings.reservations.form-update  name="model" label="Model" :value="old('model')" :error="$errors->first('model')" />
                                        </div>
                                     </div> 
                                     <div class="row">
                                        <div class="col-12 col-sm-6">
                                          <x-parkings.reservations.form-update name="color" label="Color" :value="old('color')" :error="$errors->first('color')" />
                                        </div>
                                        <div class="col-12 col-sm-6"> 
                                          <div class="form-group">
                                           <label for="paid">Paid Status</label>
                                             <select class="form-control" id="paid" name="paid" required>
                                               <option value="1">Paid</option>
                                               <option value="0">Not Paid</option>
                                             </select>
                                           </div>
                                        </div>
                                     </div> 
                                     <div class="row">
                                        <div class="col-12 col-sm-6">
                                           <x-parkings.reservations.form-update type="datetime-local" name="parking_start_time" label="Check in" :value="old('parking_start_time')" :error="$errors->first('parking_start_time')" />
                                        </div>
                                        <div class="col-12 col-sm-6">
                                           <x-parkings.reservations.form-update type="datetime-local" name="parking_end_time" label="Check out" :value="old('parking_end_time')" :error="$errors->first('parking_time_end')"/>
                                        </div>
                                     </div>
                                     <div class="row">
                                        <div class="col-12 col-sm-6">
                                          <x-parkings.reservations.form-update type="number" name="amount" label="Amount" :value="old('amount')" :error="$errors->first('amount')" />
                                        </div>
                                        <div class="col-12 col-sm-6">
                                          <x-parkings.reservations.form-update name="parking_spot" label="Spot" :value="old('parking_spot')" :error="$errors->first('parking_spot')" />
                                        </div>
                                     </div>                                  
                                    </div>
                                <div class="modal-footer">
                                 <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                  <button type="submit" class="btn btn-primary">Create</button>
                                </div>
                           </form>
                         </div>
                     </div>
                  </div>
    </x-adminlte-datatable>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')

@endsection
@push('scripts')
    <script>
        function updatePaymentStatus(serviceId, newStatus) {
            const url = `/api/parking_services/${serviceId}/payment`;
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch(url, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify({
                        paid: newStatus
                    })
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('Success:', data);
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }
    </script>
@endpush
