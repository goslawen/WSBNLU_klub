@extends('layouts.app')

@section('title', 'BroĹ„ - WSBNLU Klub')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">BroĹ„</h1>
        <a href="{{ route('weapons.create') }}" class="btn btn-primary">Dodaj broĹ„</a>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-striped align-middle">
            <thead>
                <tr>
                    <th>Nazwa</th>
                    <th>Typ broni</th>
                    <th>Kaliber</th>
                    <th>Numer seryjny</th>
                    <th>Status</th>
                    <th class="text-end">Akcje</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($weapons as $weapon)
                    <tr>
                        <td>{{ $weapon->name }}</td>
                        <td>{{ $weapon->weaponType->name }}</td>
                        <td>{{ $weapon->caliber }}</td>
                        <td>{{ $weapon->serial_number }}</td>
                        <td>{{ $weapon->status }}</td>
                        <td class="text-end">
                            <a href="{{ route('weapons.show', $weapon) }}" class="btn btn-sm btn-outline-secondary">PodglÄ…d</a>
                            <a href="{{ route('weapons.edit', $weapon) }}" class="btn btn-sm btn-outline-primary">Edytuj</a>
                            @if ($weapon->status !== 'inactive')
                                <form method="POST" action="{{ route('weapons.deactivate', $weapon) }}" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Dezaktywuj</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">Brak broni do wyĹ›wietlenia.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection