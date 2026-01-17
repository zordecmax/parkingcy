@props([
    'title' => '',
    'url' => '',
])

<x-adminlte-modal id="qrModal"  title="{{ $title }}" theme="purple" icon="fas fa-bolt" size='lg' disable-animations>
    <div class="d-flex align-items-center justify-content-center flex-column">
        <p>Отсканируйте QR-код, чтобы перейти к оплате:</p>
        @if (isset($url) && is_string($url) && !empty($url))
            {{ QrCode::size(300)->generate($url) }}
            <p class="mt-3">Или перейдите по <a href="{{ $url }}">этой ссылке</a>.</p>
        @endif
    </div>
</x-adminlte-modal>
