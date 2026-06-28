@extends('layouts.app')

@section('title', 'Podgląd typu broni - WSBNLU Klub')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">{{ $weaponType->name }}</h1>
        <div class="d-flex gap-2">
            <a href="{{ route('weapon-types.edit', $weaponType) }}" class="btn btn-primary">Edytuj</a>
            <a href="{{ route('weapon-types.index') }}" class="btn btn-outline-secondary">Powrót</a>
        </div>
    </div>

    <dl class="row">
        <dt class="col-sm-3">Nazwa</dt>
        <dd class="col-sm-9">{{ $weaponType->name }}</dd>

        <dt class="col-sm-3">Opis</dt>
        <dd class="col-sm-9">{{ $weaponType->description ?: '-' }}</dd>
    </dl>

    <h2 class="h5 mt-4">Broń tego typu</h2>
    @if ($weaponType->weapons->isNotEmpty())
        <div class="table-responsive">
            <table class="table table-sm table-striped align-middle">
                <thead>
                    <tr>
                        <th>Nazwa</th>
                        <th>Kaliber</th>
                        <th>Numer seryjny</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($weaponType->weapons as $weapon)
                        <tr>
                            <td>{{ $weapon->name }}</td>
                            <td>{{ $weapon->caliber }}</td>
                            <td>{{ $weapon->serial_number }}</td>
                            <td>{{ $weapon->status }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p class="text-muted">Brak broni przypisanej do tego typu.</p>
    @endif

    <form method="POST" action="{{ route('weapon-types.destroy', $weaponType) }}" class="mt-3">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-outline-danger">Usuń</button>
    </form>
@endsection