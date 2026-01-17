<div class="alert-wrapper">
    @php
        $messageTypes = ['success', 'error', 'warning', 'info'];
    @endphp


    @foreach ($messageTypes as $type)
        @if ($message = Session::get($type))
            <div class="alert alert-{{ $type }} alert-block flashmessage-fade-in"
                style="width:300px; top:40px; left:10px; position: absolute; z-index:999;">
                <strong>{{ $message }}</strong>
            </div>
        @endif
    @endforeach
</div>


@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const alertElement = document.querySelector('.alert');


            if (alertElement) {
                setTimeout(function() {
                    hideAlert();
                }, 1000);
            }


            function hideAlert() {
                alertElement.classList.add('flashmessage-fade-out');
                setTimeout(function() {
                    alertElement.parentNode.removeChild(alertElement);
                }, 500);
            }
        });
    </script>
@endpush
