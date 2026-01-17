@extends('adminlte::page')


@section('content')
    <form action="{{ route('parkings.payment.store', $parking) }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-12 col-md-6">
                <div class="form-group">
                    <label for="price">Price:</label>
                    <input type="text" class="form-control" name="price" value="{{ old('price') }}"
                        placeholder="Введите сумму на которую будет оплачен платеж" required>
                </div>
                <div class="col-12 col-md-6">
                    <x-adminlte-button type="submit" label="Сгенерировать QR код на оплату" theme="primary" />
                </div>
            </div>
        </div>
    </form>
@endsection
