@props(['parking'])

@php
    $icons = [
        [
            'condition' => $parking->handicap_accessible,
            'src' => 'images/search/handicap-accessible.svg',
            'tooltip' => 'Handicap Accessible',
        ],
        [
            'condition' => $parking->electric_charging_stations,
            'src' => 'images/search/plug-filled.svg',
            'tooltip' => 'Electric Charging Stations',
        ],
        [
            'condition' => $parking->can_pay_by_card,
            'src' => 'images/search/credit-card-payment.svg',
            'tooltip' => 'Can Pay by Card',
     
        ],
        [
            'condition' =>$parking->max_vehicle_height,
            'src' => 'images/search/max-vehicle-height.svg',
            'tooltip' => 'Max Vehicle Height: ' . $parking->max_vehicle_height,
           
        ]
    ];
@endphp

<ul class="image-list">
    @foreach ($icons as $icon)
        @if ($icon['condition'])
            <div class="image-list-item">
                <li>
                    <img src="{{ asset($icon['src']) }}" alt="Icon" class="svg-icon">
                    @if ($icon['tooltip'])
                        <div class="tooltip">{{ $icon['tooltip'] }}</div>
                    @endif
                </li>
            </div>
        @endif
    @endforeach
</ul>
