@extends('layouts.app')

@section('title', 'Członkowie - WSBNLU Klub')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Członkowie</h1>
        <a href="{{ route('members.create') }}" class="btn btn-primary">Dodaj</a>
    </div>
<form method="GET" action="{{ route('members.index') }}" class="row g-2 mb-3">
        <div class="col-md-9">
            <input type="text" name="search" value="{{ $search }}" class="form-control" placeholder="Szukaj po imieniu, nazwisku lub e-mailu">
        </div>
        <div class="col-md-3 d-flex gap-2">
            <button type="submit" class="btn btn-outline-primary">Szukaj</button>
            <a href="{{ route('members.index') }}" class="btn btn-outline-secondary">Wyczyść</a>
        </div>
    </form>

    <div class="table-responsive">
        <table class="table table-striped align-middle">
            <thead>
                <tr>
                    <th>Imię</th>
                    <th>Nazwisko</th>
                    <th>E-mail</th>
                    <th>Telefon</th>
                    <th>Data dołączenia</th>
                    <th>Status</th>
                    <th class="text-end">Akcje</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($members as $member)
                    <tr>
                        <td>{{ $member->first_name }}</td>
                        <td>{{ $member->last_name }}</td>
                        <td>{{ $member->email }}</td>
                        <td>{{ $member->phone ?: '-' }}</td>
                        <td>{{ $member->joined_at->format('Y-m-d') }}</td>
                        <td>@include('partials.status-badge', ['status' => $member->status])</td>
                        <td class="text-end">
                            <a href="{{ route('members.show', $member) }}" class="btn btn-sm btn-outline-secondary">Pokaż</a>
                            <a href="{{ route('members.edit', $member) }}" class="btn btn-sm btn-outline-primary">Edytuj</a>
                            @if ($member->status !== 'inactive')
                                <form method="POST" action="{{ route('members.deactivate', $member) }}" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Dezaktywuj</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">Brak członków do wyświetlenia.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection