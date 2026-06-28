@extends('layouts.app')

@section('title', 'Typy broni - WSBNLU Klub')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Typy broni</h1>
        <a href="{{ route('weapon-types.create') }}" class="btn btn-primary">Dodaj</a>
    </div>
<div class="table-responsive">
        <table class="table table-striped align-middle">
            <thead>
                <tr>
                    <th>Nazwa</th>
                    <th>Opis</th>
                    <th class="text-end">Akcje</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($weaponTypes as $weaponType)
                    <tr>
                        <td>{{ $weaponType->name }}</td>
                        <td>{{ $weaponType->description ?: '-' }}</td>
                        <td class="text-end">
                            <a href="{{ route('weapon-types.show', $weaponType) }}" class="btn btn-sm btn-outline-secondary">Pokaż</a>
                            <a href="{{ route('weapon-types.edit', $weaponType) }}" class="btn btn-sm btn-outline-primary">Edytuj</a>
                            <form method="POST" action="{{ route('weapon-types.destroy', $weaponType) }}" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger">Usuń</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center text-muted">Brak typów broni do wyświetlenia.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection