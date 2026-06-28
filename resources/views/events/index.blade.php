@extends('layouts.app')

@section('title', 'Wydarzenia - WSBNLU Klub')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Wydarzenia</h1>
        <a href="{{ route('events.create') }}" class="btn btn-primary">Dodaj</a>
    </div>
<div class="table-responsive">
        <table class="table table-striped align-middle">
            <thead>
                <tr>
                    <th>Nazwa</th>
                    <th>Data</th>
                    <th>Miejsce</th>
                    <th>Status</th>
                    <th class="text-end">Akcje</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($events as $event)
                    <tr>
                        <td>{{ $event->name }}</td>
                        <td>{{ $event->event_date->format('d.m.Y') }}</td>
                        <td>{{ $event->location }}</td>
                        <td>@include('partials.status-badge', ['status' => $event->status])</td>
                        <td class="text-end">
                            <a href="{{ route('events.show', $event) }}" class="btn btn-sm btn-outline-secondary">Pokaż</a>
                            <a href="{{ route('events.edit', $event) }}" class="btn btn-sm btn-outline-primary">Edytuj</a>
                            @if ($event->status !== 'cancelled')
                                <form method="POST" action="{{ route('events.destroy', $event) }}" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Anuluj</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted">Brak wydarzeń do wyświetlenia.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection