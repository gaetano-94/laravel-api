@extends('layouts.admin')

@section('content')
    <header class="d-flex justify-content-between align-items-center my-2">
        <h1>Titolo: {{ $project->title }}</h1>
        <a href="{{ route('admin.projects.index') }}" class="btn btn-primary btn-sm" role="button">Torna ai Progetti</a>
    </header>
    <div>
        <strong>Tipo:</strong> {{ $project->type?->title ?: 'Nessun tipo' }}
    </div>
    <div>
        <strong>Tecnologia:</strong>
        <ul>
            @foreach ($project->technologies as $technology)
                <li>{{ $technology->title }}</li>
            @endforeach
        </ul>
    </div>
    <p><strong>Descrizione: </strong>{{ $project->content }}</p>
@endsection
