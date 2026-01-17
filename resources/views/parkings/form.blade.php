@section('content')
<div class="row">
    <div class="col-12 col-md-6">
        <form action="{{ $action }}" method="POST" enctype="multipart/form-data">
            @csrf @method($method)
            <div class="mb-3">
                <label class="form-label">{{ __('parking/form.name') }}</label>
                <input type="text" class="form-control" name="name"
                    value="{{ $errors->has('name') ? '' : old('name', $parking->name) }}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">{{ __('parking/form.description') }}</label>
                <textarea class="form-control" name="description" rows="4"
                    >{{ old('description', $parking->description) }}</textarea>
            </div>
            <div class="mb-3">
                <div id="map" style="height: 400px;width: 100%;"></div>
                <label class="form-label">{{ __('parking/form.latitude') }}</label>
                <input type="text" id="latitude" name="latitude"
                    value="{{ $errors->has('latitude') ? '' : old('latitude', $parking->latitude) }}"
                    class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">{{ __('parking/form.longitude') }}</label>
                <input type="text" id="longitude" name="longitude"
                    value="{{ $errors->has('longitude') ? '' : old('longitude', $parking->longitude) }}"
                    class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">{{ __('parking/form.address') }}</label>
                <input type="text" name="address" value="{{ old('address', $parking->address) }}" class="form-control"
                   >
            </div>
            <div class="mb-3">
                <label class="form-label">{{ __('parking/form.phone') }}</label>
                <input type="tel" name="phone" value="{{ old('phone', $parking->phone) }}" class="form-control"
                    >
            </div>
            <div class="mb-3">
                <label class="form-label">{{ __('parking/form.total_spaces') }}</label>
                <input type="number" name="total_spaces" value="{{ old('total_spaces', $parking->total_spaces) }}"
                    class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">{{ __('parking/form.available_spaces') }}</label>
                <input type="number" name="available_spaces"
                    value="{{ old('available_spaces', $parking->available_spaces) }}" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">{{ __('parking/form.charging_speed') }}</label>
                <input type="number" name="charging_speed" value="{{ old('charging_speed', $parking->charging_speed) }}"
                    class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">{{ __('parking/form.price_per_hour') }}</label>
                <input type="number" name="price_per_hour" value="{{ old('price_per_hour', $parking->price_per_hour) }}"
                    class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">{{ __('parking/form.price_per_day') }}</label>
                <input type="number" name="price_per_day" value="{{ old('price_per_day', $parking->price_per_day) }}"
                    class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">{{ __('parking/form.max_vehicle_height') }}</label>
                <input type="number" name="max_vehicle_height"
                    value="{{ old('max_vehicle_height', $parking->max_vehicle_height) }}" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">{{ __('parking/form.active') }}</label>
                <select name="active" class="form-select">
                    <option value="1" {{ old('active', $parking->active) == 1 ? 'selected' : '' }}>
                        {{ __('parking/form.yes') }}
                    </option>
                    <option value="0" {{ old('active', $parking->active) == 0 ? 'selected' : '' }}>
                        {{ __('parking/form.no') }}
                    </option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">{{ __('parking/form.handicap_accessible') }}</label>
                <select name="handicap_accessible" class="form-select">
                    <option value="1"
                        {{ old('handicap_accessible', $parking->handicap_accessible) == 1 ? 'selected' : '' }}>
                        {{ __('parking/form.yes') }}
                    </option>
                    <option value="0"
                        {{ old('handicap_accessible', $parking->handicap_accessible) == 0 ? 'selected' : '' }}>
                        {{ __('parking/form.no') }}
                    </option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">{{ __('parking/form.electric_charging_stations') }}</label>
                <input type="number" name="electric_charging_stations"
                    value="{{ old('electric_charging_stations', $parking->electric_charging_stations) }}"
                    class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">{{ __('parking/form.can_pay_by_card') }}</label>
                <select name="can_pay_by_card" class="form-select">
                    <option value="1" {{ old('can_pay_by_card', $parking->can_pay_by_card) == 1 ? 'selected' : '' }}>
                        {{ __('parking/form.yes') }}
                    </option>
                    <option value="0" {{ old('can_pay_by_card', $parking->can_pay_by_card) == 0 ? 'selected' : '' }}>
                        {{ __('parking/form.no') }}
                    </option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">{{ __('parking/form.link') }}</label>
                <input type="url" name="link" value="{{ old('link', $parking->link) }}" class="form-control">
            </div>

            <div class="mb-3">
                <label class="form-label">{{ __('parking/form.tariff') }}</label>
                <input type="text" name="tariff" value="{{ old('tariff', $parking->tariff) }}" class="form-control"
                    >
            </div>


 <h3>Work schedule</h3>
 <div class="mb-3">
 <div class="row">
        <div class="form-check mt-1 col-12 ml-2">
            <input class="form-check-input" type="checkbox" id="mo_all" name="mo_all">
            <label class="form-check-label" for="mo_all">All week</label>
        </div>
    </div>
    <div class="row">

        <h4 class="col-5 col-sm-3">Monday</h4> 
        <div class="form-check mt-1 col-7 col-sm-9">
            <input class="form-check-input is-off-checkbox" type="checkbox" id="mo_is_off" name="schedule[mo_is_off]" value="1" {{ $schedule && $schedule->mo_time_start === null ? 'checked' : '' }}>
            <label class="form-check-label" for="mo_is_off">Day off</label>
        </div>
        
        
    </div>
    
    <div class="row">
    <div class="col-6 col-lg-3">
            <label for="mo_time_start" class="form-label ">Start Time</label>
            <input type="time" id="mo_time_start" name="schedule[mo_time_start]" class="form-control" value="{{ $schedule && $schedule->mo_time_start ? \Carbon\Carbon::parse($schedule->mo_time_start)->format('H:i') : '' }}">
        </div>
        <div class="col-6 col-lg-3">
            <label for="mo_time_end" class="form-label">End Time</label>
            <input type="time" id="mo_time_end" name="schedule[mo_time_end]" class="form-control" value="{{ $schedule && $schedule->mo_time_end ? \Carbon\Carbon::parse($schedule->mo_time_end)->format('H:i') : '' }}">
        </div>
        <div class="col-6 col-lg-3">
            <label for="mo_break_start" class="form-label">Break Start Time</label>
            <input type="time" id="mo_break_start" name="schedule[mo_break_start]" class="form-control" value="{{ $schedule && $schedule->mo_break_start ? \Carbon\Carbon::parse($schedule->mo_break_start)->format('H:i') : '' }}">
        </div>
        <div class="col-6 col-lg-3">
            <label for="mo_break_end" class="form-label">Break End Time</label>
            <input type="time" id="mo_break_end" name="schedule[mo_break_end]" class="form-control" value="{{ $schedule && $schedule->mo_break_end ? \Carbon\Carbon::parse($schedule->mo_break_end)->format('H:i') : '' }}">
        </div>
    </div>
</div>

<div class="mb-3">
    <div class="row">
        <h4 class="col-5 col-sm-3">Tuesday</h4> 
        <div class="form-check mt-1 col-7 col-sm-9">
            <input class="form-check-input is-off-checkbox" type="checkbox" id="tu_is_off" name="schedule[tu_is_off]" value="1" {{ $schedule && $schedule->tu_time_start === null ? 'checked' : '' }}>
            <label class="form-check-label" for="tu_is_off">Day off</label>
        </div>
    </div>
    <div class="row">
        <div class="col-6 col-lg-3">
            <label for="tu_time_start" class="form-label">Start of Day</label>
            <input type="time" id="tu_time_start" name="schedule[tu_time_start]" class="form-control" value="{{ $schedule && $schedule->tu_time_start ? \Carbon\Carbon::parse($schedule->tu_time_start)->format('H:i') : '' }}">
        </div>
        <div class="col-6 col-lg-3">
            <label for="tu_time_end" class="form-label">End of Day</label>
            <input type="time" id="tu_time_end" name="schedule[tu_time_end]" class="form-control" value="{{ $schedule && $schedule->tu_time_end ? \Carbon\Carbon::parse($schedule->tu_time_end)->format('H:i') : '' }}">
        </div>
        <div class="col-6 col-lg-3">
            <label for="tu_break_start" class="form-label">Start of Break</label>
            <input type="time" id="tu_break_start" name="schedule[tu_break_start]" class="form-control" value="{{ $schedule && $schedule->tu_break_start ? \Carbon\Carbon::parse($schedule->tu_break_start)->format('H:i') : '' }}">
        </div>
        <div class="col-6 col-lg-3">
            <label for="tu_break_end" class="form-label">End of Break</label>
            <input type="time" id="tu_break_end" name="schedule[tu_break_end]" class="form-control" value="{{ $schedule && $schedule->tu_break_end ? \Carbon\Carbon::parse($schedule->tu_break_end)->format('H:i') : '' }}">
        </div>
    </div>
</div>

<div class="mb-3">
    <div class="row">
        <h4 class="col-5 col-sm-3">Wednesday</h4> 
        <div class="form-check mt-1 col-7 col-sm-9">
            <input class="form-check-input is-off-checkbox" type="checkbox" id="we_is_off" name="schedule[we_is_off]" value="1" {{ $schedule && $schedule->we_time_start === null ? 'checked' : '' }}>
            <label class="form-check-label" for="we_is_off">Day off</label>
        </div>
    </div>
    <div class="row">
        <div class="col-6 col-lg-3">
            <label for="we_time_start" class="form-label">Start of Day</label>
            <input type="time" id="we_time_start" name="schedule[we_time_start]" class="form-control" value="{{ $schedule && $schedule->we_time_start ? \Carbon\Carbon::parse($schedule->we_time_start)->format('H:i') : '' }}">
        </div>
        <div class="col-6 col-lg-3">
            <label for="we_time_end" class="form-label">End of Day</label>
            <input type="time" id="we_time_end" name="schedule[we_time_end]" class="form-control" value="{{ $schedule && $schedule->we_time_end ? \Carbon\Carbon::parse($schedule->we_time_end)->format('H:i') : '' }}">
        </div>
        <div class="col-6 col-lg-3">
            <label for="we_break_start" class="form-label">Start of Break</label>
            <input type="time" id="we_break_start" name="schedule[we_break_start]" class="form-control" value="{{ $schedule && $schedule->we_break_start ? \Carbon\Carbon::parse($schedule->we_break_start)->format('H:i') : '' }}">
        </div>
        <div class="col-6 col-lg-3">
            <label for="we_break_end" class="form-label">End of Break</label>
            <input type="time" id="we_break_end" name="schedule[we_break_end]" class="form-control" value="{{ $schedule && $schedule->we_break_end ? \Carbon\Carbon::parse($schedule->we_break_end)->format('H:i') : '' }}">
        </div>
    </div>
</div>

<div class="mb-3">
    <div class="row">
        <h4 class="col-5 col-sm-3">Thursday</h4> 
        <div class="form-check mt-1 col-7 col-sm-9">
            <input class="form-check-input is-off-checkbox" type="checkbox" id="th_is_off" name="schedule[th_is_off]" value="1" {{ $schedule && $schedule->th_time_start === null ? 'checked' : '' }}>
            <label class="form-check-label" for="th_is_off">Day off</label>
        </div>
    </div>
    <div class="row">
        <div class="col-6 col-lg-3">
            <label for="th_time_start" class="form-label">Start of Day</label>
            <input type="time" id="th_time_start" name="schedule[th_time_start]" class="form-control" value="{{ $schedule && $schedule->th_time_start ? \Carbon\Carbon::parse($schedule->th_time_start)->format('H:i') : '' }}">
        </div>
        <div class="col-6 col-lg-3">
            <label for="th_time_end" class="form-label">End of Day</label>
            <input type="time" id="th_time_end" name="schedule[th_time_end]" class="form-control" value="{{ $schedule && $schedule->th_time_end ? \Carbon\Carbon::parse($schedule->th_time_end)->format('H:i') : '' }}">
        </div>
        <div class="col-6 col-lg-3">
            <label for="th_break_start" class="form-label">Start of Break</label>
            <input type="time" id="th_break_start" name="schedule[th_break_start]" class="form-control" value="{{ $schedule && $schedule->th_break_start ? \Carbon\Carbon::parse($schedule->th_break_start)->format('H:i') : '' }}">
        </div>
        <div class="col-6 col-lg-3">
            <label for="th_break_end" class="form-label">End of Break</label>
            <input type="time" id="th_break_end" name="schedule[th_break_end]" class="form-control" value="{{ $schedule && $schedule->th_break_end ? \Carbon\Carbon::parse($schedule->th_break_end)->format('H:i') : '' }}">
        </div>
    </div>
</div>

<div class="mb-3">
    <div class="row">
        <h4 class="col-5 col-sm-3">Friday</h4> 
        <div class="form-check mt-1 col-7 col-sm-9">
            <input class="form-check-input is-off-checkbox" type="checkbox" id="fr_is_off" name="schedule[fr_is_off]" value="1" {{ $schedule && $schedule->fr_time_start === null ? 'checked' : '' }}>
            <label class="form-check-label" for="fr_is_off">Day off</label>
        </div>
    </div>
    <div class="row">
        <div class="col-6 col-lg-3">
            <label for="fr_time_start" class="form-label">Start of Day</label>
            <input type="time" id="fr_time_start" name="schedule[fr_time_start]" class="form-control" value="{{ $schedule && $schedule->fr_time_start ? \Carbon\Carbon::parse($schedule->fr_time_start)->format('H:i') : '' }}">
        </div>
        <div class="col-6 col-lg-3">
            <label for="fr_time_end" class="form-label">End of Day</label>
            <input type="time" id="fr_time_end" name="schedule[fr_time_end]" class="form-control" value="{{ $schedule && $schedule->fr_time_end ? \Carbon\Carbon::parse($schedule->fr_time_end)->format('H:i') : '' }}">
        </div>
        <div class="col-6 col-lg-3">
            <label for="fr_break_start" class="form-label">Start of Break</label>
            <input type="time" id="fr_break_start" name="schedule[fr_break_start]" class="form-control" value="{{ $schedule && $schedule->fr_break_start ? \Carbon\Carbon::parse($schedule->fr_break_start)->format('H:i') : '' }}">
        </div>
        <div class="col-6 col-lg-3">
            <label for="fr_break_end" class="form-label">End of Break</label>
            <input type="time" id="fr_break_end" name="schedule[fr_break_end]" class="form-control" value="{{ $schedule && $schedule->fr_break_end ? \Carbon\Carbon::parse($schedule->fr_break_end)->format('H:i') : '' }}">
        </div>
    </div>
</div>

<div class="mb-3">
    <div class="row">
        <h4 class="col-5 col-sm-3">Saturday</h4> 
        <div class="form-check mt-1 col-7 col-sm-9">
            <input class="form-check-input is-off-checkbox" type="checkbox" id="sa_is_off" name="schedule[sa_is_off]" value="1" {{ $schedule && $schedule->sa_time_start === null ? 'checked' : '' }}>
            <label class="form-check-label" for="sa_is_off">Day off</label>
        </div>
    </div>
    <div class="row">
        <div class="col-6 col-lg-3">
            <label for="sa_time_start" class="form-label">Start of Day</label>
            <input type="time" id="sa_time_start" name="schedule[sa_time_start]" class="form-control" value="{{ $schedule && $schedule->sa_time_start ? \Carbon\Carbon::parse($schedule->sa_time_start)->format('H:i') : '' }}">
        </div>
        <div class="col-6 col-lg-3">
            <label for="sa_time_end" class="form-label">End of Day</label>
            <input type="time" id="sa_time_end" name="schedule[sa_time_end]" class="form-control" value="{{ $schedule && $schedule->sa_time_end ? \Carbon\Carbon::parse($schedule->sa_time_end)->format('H:i') : '' }}">
        </div>
        <div class="col-6 col-lg-3">
            <label for="sa_break_start" class="form-label">Start of Break</label>
            <input type="time" id="sa_break_start" name="schedule[sa_break_start]" class="form-control" value="{{ $schedule && $schedule->sa_break_start ? \Carbon\Carbon::parse($schedule->sa_break_start)->format('H:i') : '' }}">
        </div>
        <div class="col-6 col-lg-3">
            <label for="sa_break_end" class="form-label">End of Break</label>
            <input type="time" id="sa_break_end" name="schedule[sa_break_end]" class="form-control" value="{{ $schedule && $schedule->sa_break_end ? \Carbon\Carbon::parse($schedule->sa_break_end)->format('H:i') : '' }}">
        </div>
    </div>
</div>
<div class="mb-3">
    <div class="row">
        <h4 class="col-5 col-sm-3">Sunday</h4> 
        <div class="form-check mt-1 col-7 col-sm-9">
            <input class="form-check-input is-off-checkbox" type="checkbox" id="su_is_off" name="schedule[su_is_off]" value="1" {{ $schedule && $schedule->su_time_start === null ? 'checked' : '' }}>
            <label class="form-check-label" for="su_is_off">Day off</label>
        </div>
    </div>
    <div class="row">
        <div class="col-6 col-lg-3">
            <label for="su_time_start" class="form-label">Start of Day</label>
            <input type="time" id="su_time_start" name="schedule[su_time_start]" class="form-control" value="{{ $schedule && $schedule->su_time_start ? \Carbon\Carbon::parse($schedule->su_time_start)->format('H:i') : '' }}">
        </div>
        <div class="col-6 col-lg-3">
            <label for="su_time_end" class="form-label">End of Day</label>
            <input type="time" id="su_time_end" name="schedule[su_time_end]" class="form-control" value="{{ $schedule && $schedule->su_time_end ? \Carbon\Carbon::parse($schedule->su_time_end)->format('H:i') : '' }}">
        </div>
        <div class="col-6 col-lg-3">
            <label for="su_break_start" class="form-label">Start of Break</label>
            <input type="time" id="su_break_start" name="schedule[su_break_start]" class="form-control" value="{{ $schedule && $schedule->su_break_start ? \Carbon\Carbon::parse($schedule->su_break_start)->format('H:i') : '' }}">
        </div>
        <div class="col-6 col-lg-3">
            <label for="su_break_end" class="form-label">End of Break</label>
            <input type="time" id="su_break_end" name="schedule[su_break_end]" class="form-control" value="{{ $schedule && $schedule->su_break_end ? \Carbon\Carbon::parse($schedule->su_break_end)->format('H:i') : '' }}">
        </div>
    </div>
</div>
<div class="form-group">
        <button type="submit" name="action" value="save" class="btn btn-primary">Save</button>
        <button type="submit" name="action" value="save_and_close" class="btn btn-primary">Save and close</button>
    </div>            
        </form>
    </div>
</div>
@endsection