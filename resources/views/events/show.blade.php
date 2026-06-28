@extends('layouts.app')

@section('title', 'Podgląd wydarzenia - WSBNLU Klub')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">{{ $event->name }}</h1>
        <div class="d-flex gap-2">
            <a href="{{ route('events.edit', $event) }}" class="btn btn-primary">Edytuj</a>
            <a href="{{ route('events.index') }}" class="btn btn-outline-secondary">Powrót</a>
        </div>
    </div>

    <dl class="row">
        <dt class="col-sm-3">Nazwa</dt>
        <dd class="col-sm-9">{{ $event->name }}</dd>

        <dt class="col-sm-3">Data</dt>
        <dd class="col-sm-9">{{ $event->event_date->format('d.m.Y') }}</dd>

        <dt class="col-sm-3">Miejsce</dt>
        <dd class="col-sm-9">{{ $event->location }}</dd>

        <dt class="col-sm-3">Status</dt>
        <dd class="col-sm-9">@include('partials.status-badge', ['status' => $event->status])</dd>

        <dt class="col-sm-3">Opis</dt>
        <dd class="col-sm-9">{{ $event->description ?: '-' }}</dd>
    </dl>

    @if ($event->status !== 'cancelled')
        <form method="POST" action="{{ route('events.destroy', $event) }}" class="mb-4">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-outline-danger">Anuluj</button>
        </form>
    @endif

    <h2 class="h5 mt-4">Uczestnicy</h2>

    @if ($errors->any())
        <div class="alert alert-danger">Formularz zawiera błędy. Popraw oznaczone pola.</div>
    @endif

    <form method="POST" action="{{ route('events.members.store', $event) }}" class="row g-2 mb-3">
        @csrf
        <div class="col-md-8">
            <select name="member_id" class="form-select @error('member_id') is-invalid @enderror">
                <option value="">Wybierz członka</option>
                @foreach ($availableMembers as $member)
                    <option value="{{ $member->id }}" @selected((string) old('member_id') === (string) $member->id)>{{ $member->last_name }} {{ $member->first_name }} ({{ $member->email }})</option>
                @endforeach
            </select>
            @error('member_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>
        <div class="col-md-4">
            <button type="submit" class="btn btn-primary">Dodaj</button>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-sm table-striped align-middle">
            <thead>
                <tr>
                    <th>Imię</th>
                    <th>Nazwisko</th>
                    <th>E-mail</th>
                    <th class="text-end">Akcje</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($event->members as $member)
                    <tr>
                        <td>{{ $member->first_name }}</td>
                        <td>{{ $member->last_name }}</td>
                        <td>{{ $member->email }}</td>
                        <td class="text-end">
                            <form method="POST" action="{{ route('events.members.destroy', [$event, $member]) }}" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Usuń</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted">Brak uczestników wydarzenia.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection