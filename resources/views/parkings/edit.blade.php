@php
    /**
     * This file represents the view for editing a parking record.
     * It extends the 'adminlte::page' layout and includes a form for updating the parking record.
     * It also includes a Google Maps script for displaying and selecting the location of the parking.
     *
     * @var string $apiKey The API key for accessing the Google Maps API.
     */
@endphp

@extends('adminlte::page')

@php
    $apiKey = env('GOOGLE_MAPS_API_KEY');
@endphp

@section('content_header')
    <h1>Setting Parking</h1>
@stop

@vite(['resources/js/parkings/edit.js'])

@section('content')
    @include('parkings.form', [
        'action' => route('parkings.update', $parking),
        'method' => 'PUT',
    ])
@endsection

@push('scripts')
    <script type="text/javascript">
        window.config = {
            apiKey: "{{ env('GOOGLE_MAPS_API_KEY') }}",
            lat: <?php echo $parking->latitude; ?>,
            lng: <?php echo $parking->longitude; ?>
        }
        const GOOGLE_MAPS_API_KEY = window.config.apiKey;
        if (GOOGLE_MAPS_API_KEY) {
            (g => {
                var h, a, k, p = "The Google Maps JavaScript API",
                    c = "google",
                    l = "importLibrary",
                    q = "__ib__",
                    m = document,
                    b = window;
                b = b[c] || (b[c] = {});
                var d = b.maps || (b.maps = {}),
                    r = new Set,
                    e = new URLSearchParams,
                    u = () => h || (h = new Promise(async (f, n) => {
                        await (a = m.createElement("script"));
                        e.set("libraries", [...r] + "");
                        for (k in g) e.set(k.replace(/[A-Z]/g, t => "_" + t[0].toLowerCase()), g[k]);
                        e.set("callback", c + ".maps." + q);
                        a.src = `https://maps.${c}apis.com/maps/api/js?` + e;
                        d[q] = f;
                        a.onerror = () => h = n(Error(p + " could not load."));
                        a.nonce = m.querySelector("script[nonce]")?.nonce || "";
                        m.head.append(a)
                    }));
                d[l] ? console.warn(p + " only loads once. Ignoring:", g) : d[l] = (f, ...n) => r.add(f) && u().then(
                () =>
                    d[l](
                        f, ...n))
            })({
                key: GOOGLE_MAPS_API_KEY,
                v: "weekly",
                // Use the 'v' parameter to indicate the version to use (weekly, beta, alpha, etc.).
                // Add other bootstrap parameters as needed, using camel case.
            });
        }
    </script>


    <script type="text/javascript">
        let map;

        async function initMap() {
            // The location of Uluru
            const position = {
                lat: window.config.lat ?? null,
                lng: window.config.lng ?? null
            };
            // Request needed libraries.
            //@ts-ignore
            const {
                Map
            } = await google.maps.importLibrary("maps");
            const {
                AdvancedMarkerElement
            } = await google.maps.importLibrary("marker");

            // The map, centered at Uluru
            map = new Map(document.getElementById("map"), {
                zoom: 12,
                center: position,
                mapId: "DEMO_MAP_ID",
            });

            // The marker, positioned at Uluru
            const marker = new AdvancedMarkerElement({
                map: map,
                position: position,
                title: "Parking",
            });
        }

        initMap();
    </script>
@endPush
