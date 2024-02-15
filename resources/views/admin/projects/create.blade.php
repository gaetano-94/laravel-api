@extends('layouts.admin')

@section('content')
    <header class="d-flex justify-content-between align-items-center mt-2">
        <h1>Creazione Nuovo Progetto</h1>
        <a href="{{ route('admin.projects.index') }}" class="btn btn-primary btn-sm my-2" role="button">Torna ai Progetti</a>
    </header>
    <hr>
    <form action="{{ route('admin.projects.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label"><strong>Titolo</strong></label>
            <input type="text" class="form-control  @error('title') is-invalid
                 @enderror" id="title"
                placeholder="Nuovo Progetto" name="title">
            @error('title')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="content" class="form-label"><strong>Descrizione</strong></label>
            <textarea class="form-control @error('content') is-invalid
                 @enderror" id="content" rows="3"
                name="content"></textarea>
            @error('content')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="content" class="form-label"><strong>Tipo</strong></label>
            <select class="form-select" aria-label="Default select example" name="type_id">
                <option selected>Apri il menu</option>
                @foreach ($types as $type)
                    <option value="{{ $type->id }}" @if (old('type_id') == $type->id) selected @endif>
                        {{ $type->title }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <div>
                <label class="form-label"><strong>Tecnologie</strong></label>
            </div>
            @if ($errors->any())
            @endif
            @foreach ($technologies as $technology)
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" value="{{ $technology->id }}" name="technologies[]"
                        id="technology-{{ $technology->id }}"
                        {{ in_array($technology->id, old('technologies', [])) ? 'checked' : '' }}>
                    <label class="form-check-label" for="technology-{{ $technology->id }}">{{ $technology->title }}</label>
                </div>
            @endforeach
        </div>
        <button class="btn btn-success">Crea</button>
    </form>
@endsection
