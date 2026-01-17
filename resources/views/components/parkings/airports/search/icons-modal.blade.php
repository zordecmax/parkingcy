@props(['parking'])

@php
    $items = [
        [
            'condition' => $parking->handicap_accessible,
            'src' => 'images/search/handicap-accessible.svg',
            'text' => 'Handicap Accessible'
        ],
        [
            'condition' => $parking->electric_charging_stations,
            'src' => 'images/search/plug-filled.svg',
            'text' => 'Electric Charging Stations.'
        ],
        [
            'condition' => $parking->charging_speed,
            'src' => 'images/search/lightning.svg',
            'text' => "Charging speed: {$parking->charging_speed}"
        ],
        [
            'condition' => $parking->can_pay_by_card,
            'src' => 'images/search/credit-card-payment.svg',
            'text' => 'Can Pay by Card'
        ],
        [
            'condition' => $parking->max_vehicle_height,
            'src' => 'images/search/max-vehicle-height.svg',
            'text' => $parking->max_vehicle_height
        ],
        [
            'condition' =>$parking->phone,
            'src' => 'images/search/phone.svg',
            'text' => "Phone: <a href='tel:{$parking->phone}'>{$parking->phone}</a>"
        ],
        [
            'condition' =>$parking->address,
            'src' => 'images/search/map-tag.svg',
            'text' => "Address: {$parking->address}"
        ]
    ];
@endphp

<ul class="image-list p-0 m-0 d-flex flex-column">
    @foreach ($items as $item)
        @if ($item['condition'])
            <div class="image-list-item d-flex flex-start">
                <li>
                    <img src="{{ asset($item['src']) }}" alt="Icon" class="svg-icon">
                </li>
                <span class="ps-3">{!! $item['text'] !!}</span>
            </div>
        @endif
    @endforeach
</ul>
