@extends('layouts.admin')

@section('content')
    <header class="d-flex justify-content-between align-items-center mt-2">
        <h1><strong>Elenco dei Progetti</strong></h1>
        <a href="{{ route('admin.projects.create') }}" role="button" class="btn btn-success btn-sm my-2">Crea un nuovo
            progetto</a>
    </header>
    @if (session('message'))
        <div class="toast-container position-fixed bottom-0 end-0 p-3">
            <div id="liveToast" class="toast-show" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header">
                    <strong class="me-auto">Notifica</strong>
                    <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    {{ session('message') }}
                </div>
            </div>
        </div>
    @endif
    <hr>
    <table class="table">
        <thead>
            <tr>
                <th scope="col"><strong>ID</strong></th>
                <th scope="col"><strong>TITOLO</strong></th>
                <th scope="col"><strong>SLUG</strong></th>
                <th scope="col"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($projects as $project)
                <tr>
                    <th>{{ $project->id }}</th>
                    <td>{{ $project->title }}</td>
                    <td>{{ $project->slug }}</td>
                    <td>
                        <a href="{{ route('admin.projects.show', $project) }}" role="button"
                            class="btn btn-warning btn-sm">Dettagli</a>

                        <a href="{{ route('admin.projects.edit', $project->slug) }}" role="button"
                            class="btn btn-primary btn-sm">Modifica</a>

                        <form action="{{ route('admin.projects.destroy', $project->slug) }}" method="POST"
                            class="d-inline">
                            @csrf

                            @method('DELETE')

                            <input type="submit" value="Elimina" class="btn btn-danger btn-sm">

                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
