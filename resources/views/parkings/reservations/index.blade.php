@extends('adminlte::page')

@section('title', 'Reservations Parking')

@php
    $heads = [
        'ID',
        'Name',
        'Email',
        'Phone',
        'Time Start',
        'Time End',
        'Car Number',
        'Car Model',
        'Car Color',
        'Price',
        'Status',
        'Days',
        'Action',
    ];
@endphp

@section('content_header')
    <h1>Reservations Parking</h1>
@stop

@vite(['resources/scss/parkings/reservations/index.scss'])

@section('content')
    <x-adminlte-datatable id="table1" :heads="$heads">
    <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#create-reservation-modal">
        Create Reservation
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
        @foreach ($reservations as $reservation)
            <tr>
                <td data-label="ID">{{ $reservation->id }}</td>
                <td data-label="Name">{{ $reservation->client->name }}</td>
                <td data-label="Email">{{ $reservation->client->email }}</td>
                <td data-label="Phone">{{ $reservation->client->phone }}</td>
                <td data-label="Time Start">{{ $reservation->time_start }}</td>
                <td data-label="Time End">{{ $reservation->time_end }}</td>
                <td data-label="Car Number">{{ $reservation->client->car_number }}</td>
                <td data-label="Car Model">{{ $reservation->client->car_model }}</td>
                <td data-label="Car Color">{{ $reservation->client->car_color }}</td>
                <td data-label="Price">{{ $reservation->price }}</td>
                <td data-label="Status">
                 {{ \App\Enums\ReservationStatusesEnum::getValues()[$reservation->status->value] }}
                </td>
                <td data-label="Days">
                    @php
                        $start = new DateTime($reservation->time_start);
                        $end = new DateTime($reservation->time_end);
                        $duration = $start->diff($end);
                        $days = $duration->days;
                        $hours = $duration->h;
                        echo "$days days, $hours hours";
                    @endphp
                </td>
                <td class="button-line">
                    <nobr>
                      <a href="#" class="btn btn-xs btn-default text-primary mx-1 shadow" title="Edit" data-toggle="modal" data-target="#edit-reservation-modal{{ $reservation->id }}">
                        <i class="fa fa-lg fa-fw fa-pen"></i>
                      </a>
                      <form action="{{ route('reservations.destroy', $reservation->id) }}" style="display: inline" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-xs btn-default text-danger mx-1 shadow" title="Delete">
                         <i class="fa fa-lg fa-fw fa-trash"></i>
                       </button>
                    </form>
                    </nobr>
               </td>
            </tr>
               <!-- Modal -->
               <div class="modal fade" id="edit-reservation-modal{{ $reservation->id }}" tabindex="-1" role="dialog" aria-labelledby="edit-reservation-modal-label{{ $reservation->id }}" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content modal-scroll">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="edit-reservation-modal-label{{ $reservation->id }}">Edit Reservation</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form action="{{ route('reservations.update', $reservation->id) }}" id="status-form-{{ $reservation->id }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-body">
                                     <div class="row">
                                        <div class="col-12 col-sm-6">
                                          <x-parkings.reservations.form-update name="name" label="Name" :value="$reservation->client->name" :error="$errors->first('name')" />
                                        </div>
                                        <div class="col-12 col-sm-6">
                                          <x-parkings.reservations.form-update type="email" name="email" label="Email" :value="$reservation->client->email" :error="$errors->first('email')" />
                                        </div>
                                     </div> 
                                     <div class="row">
                                        <div class="col-12 col-sm-6">
                                          <x-parkings.reservations.form-update name="phone" label="Phone" :value="$reservation->client->phone" :error="$errors->first('phone')" />
                                        </div>
                                        <div class="col-12 col-sm-6">
                                          <x-parkings.reservations.form-update type="datetime-local" name="time_start" label="Time Start" :value="$reservation->time_start" :error="$errors->first('time_start')" />
                                        </div>
                                     </div>
                                     <div class="row">
                                        <div class="col-12 col-sm-6">
                                          <x-parkings.reservations.form-update type="datetime-local" name="time_end" label="Time End" :value="$reservation->time_end" :error="$errors->first('time_end')"/>
                                        </div>
                                        <div class="col-12 col-sm-6">
                                          <x-parkings.reservations.form-update type="text" name="car_number" label="Car Number" :value="$reservation->client->car_number" :error="$errors->first('car_number')" />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-sm-6">
                                          <x-parkings.reservations.form-update type="text" name="car_model" label="Car Model" :value="$reservation->client->car_model" :error="$errors->first('car_model')" />
                                        </div>
                                        <div class="col-12 col-sm-6">
                                          <x-parkings.reservations.form-update type="text" name="car_color" label="Car Color" :value="$reservation->client->car_color" :error="$errors->first('car_color')" />
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 col-sm-6">
                                          <x-parkings.reservations.form-update type="number" name="price" label="Price" :value="$reservation->price" :error="$errors->first('price')" />
                                        </div>
                                        <div class="col-12 col-sm-6">
                                          <label for="status">Status</label>
                                          <select name="status" class="form-control"
                                           onchange="updateReservationStatus({{ $reservation->id }}, this.value)">
                                           @foreach (App\Enums\ReservationStatusesEnum::getValues() as $value => $label)
                                              <option value="{{ $value }}"
                                                {{ $reservation->status->value == $value ? 'selected' : '' }}>
                                                  {{ $label }}
                                               </option>
                                           @endforeach
                                          </select>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                     <!-- Modal for creating a new reservation -->
    <div class="modal fade" id="create-reservation-modal" tabindex="-1" role="dialog" aria-labelledby="create-reservation-modal-label" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-scroll">
                <div class="modal-header">
                    <h5 class="modal-title" id="create-reservation-modal-label">Create Reservation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('reservations.store', ['airport' => $reservation->parking->airport, 'parking' =>$reservation->parking]) }}"
                                    method="POST">
                                    @csrf
                    <div class="modal-body">
                     <div class="row">
                       <div class="col-12 col-sm-6">
                        <x-parkings.reservations.form-update name="name" label="Name" :value="old('name')" :error="$errors->first('name')" />
                       </div>
                       <div class="col-12 col-sm-6">
                        <x-parkings.reservations.form-update type="email" name="email" label="Email" :value="old('email')" :error="$errors->first('email')" />
                       </div>
                      </div> 
                     <div class="row">
                       <div class="col-12 col-sm-6">
                        <x-parkings.reservations.form-update name="phone" label="Phone" :value="old('phone')" :error="$errors->first('phone')" />
                       </div>
                       <div class="col-12 col-sm-6">
                        <x-parkings.reservations.form-update type="datetime-local" name="time_start" label="Time Start" :value="old('time_start')" :error="$errors->first('time_start')" />
                       </div>
                     </div>
                     <div class="row">
                       <div class="col-12 col-sm-6">
                        <x-parkings.reservations.form-update type="datetime-local" name="time_end" label="Time End" :value="old('time_end')" :error="$errors->first('time_end')" />
                       </div>
                       <div class="col-12 col-sm-6">
                        <x-parkings.reservations.form-update type="text" name="car_number" label="Car Number" :value="old('car_number')" :error="$errors->first('car_number')" />
                       </div>
                      </div>
                      <div class="row">
                       <div class="col-12 col-sm-6">
                        <x-parkings.reservations.form-update type="text" name="car_model" label="Car Model" :value="old('car_model')" :error="$errors->first('car_model')" />
                       </div>
                       <div class="col-12 col-sm-6">
                        <x-parkings.reservations.form-update type="text" name="car_color" label="Car Color" :value="old('car_color')" :error="$errors->first('car_color')" />
                       </div>
                      </div>
                      <div class="row">
                       <div class="col-12 col-sm-6">
                          <x-parkings.reservations.form-update type="number" name="price" label="Price" :value="old('price')" :error="$errors->first('price')" required/>
                       </div>
                        <div class="col-12 col-sm-6">
                          <label class="form-label w-100">
                            <span class="d-block mb-1">Payment Method</span>
                                <select name="payment_method" class="form-control w-100" required>
                                    <option value="cash">Cash</option>
                                    <option value="online">Online</option>
                                </select>
                          </label>
                        </div>
                      </div> 
                       
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Create Reservation</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
        @endforeach
    </x-adminlte-datatable>
@endsection

@push('scripts')
    <script>
        function updateReservationStatus(reservationId, newStatus) {
            const url = `/api/reservations/${reservationId}/status`;
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            fetch(url, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': token
                    },
                    body: JSON.stringify({
                        status: newStatus
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
