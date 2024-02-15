@extends('layouts.admin')

@section('content')
    <header class="d-flex justify-content-between align-items-center mt-2">
        <h1>Modifica Progetto: {{ $project->title }}</h1>
        <a href="{{ route('admin.projects.index') }}" class="btn btn-primary btn-sm my-2" role="button">Torna ai Progetti</a>
    </header>
    <hr>
    <form action="{{ route('admin.projects.update', $project->slug) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="title" class="form-label"><strong>Titolo</strong></label>
            <input type="text" class="form-control  @error('title') is-invalid
                 @enderror" id="title"
                placeholder="Modifica Progetto" name="title" value="{{ old('title', $project->title) }}">
            @error('title')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="content" class="form-label"><strong>Tipo</strong></label>
            <select class="form-select" aria-label="Default select example" name="type_id">
                <option selected>Apri il menu</option>
                @foreach ($types as $type)
                    <option value="{{ $type->id }}" @if (old('type_id', $project->type_id) == $type->id) selected @endif>
                        {{ $type->title }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <div>
                <label class="form-label"><strong>Tecnologie</strong></label>
            </div>
            @foreach ($technologies as $technology)
                <div class="form-check form-check-inline">
                    @if ($errors->any())
                        <input class="form-check-input" type="checkbox" value="{{ $technology->id }}" name="technologies[]"
                            id="technology-{{ $technology->id }}"
                            {{ in_array($technology->id, old('technologies', [])) ? 'checked' : '' }}>
                        <label class="form-check-label"
                            for="technology-{{ $technology->id }}">{{ $technology->title }}</label>
                    @else
                        <input class="form-check-input" type="checkbox" value="{{ $technology->id }}" name="technologies[]"
                            id="technology-{{ $technology->id }}"
                            {{ $project->technologies->contains($technology->id) ? 'checked' : '' }}>
                        <label class="form-check-label"
                            for="technology-{{ $technology->id }}">{{ $technology->title }}</label>
                    @endif
                </div>
            @endforeach
        </div>
        <div class="mb-3">
            <label class="form-label"><strong>Descrizione</strong></label>
            <textarea class="form-control @error('content') is-invalid
                 @enderror" name="content" id=""
                cols="30" rows="5">{{ old('content', $project->content) }}</textarea>
            @error('content')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>
        <button class="btn btn-success">Modifica</button>
    </form>
@endsection
