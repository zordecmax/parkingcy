@extends('layouts.app')

@section('title')
   
@endsection

@section('description')
@endsection

@section('keywords')
@endsection

@section('content')
    <div class="container">
        <div class="py-4">
            <h1></h1>

            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href=""></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page"></li>
                </ol>
            </nav>

            @include('parkings.form', [
                'action' => route('parkings.store',$parking),
                'method' => 'POST',
            ])

            {{-- <form action="{{ route('artist.gallery.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Название</label>
                    <input type="text" class="form-control" name="name" value="" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Цена</label>
                    <input type="text" class="form-control" name="price" value="" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Описание</label>
                    <textarea class="form-control" name="description" rows="4" required></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Загрузить файл</label>
                    <input type="file" name="image" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary">Создать картину</button>
            </form> --}}
        </div>


        {{-- <div class="mb-3">
                <label for="category_id" class="form-label">Категория</label>
                <select class="form-select" id="category_id" name="category_id" required>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ isset($news) && $news->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div> --}}
    </div>
@endsection
