@extends('layouts.app')

@section('title', 'Podgląd członka - WSBNLU Klub')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">{{ $member->first_name }} {{ $member->last_name }}</h1>
        <div class="d-flex gap-2">
            <a href="{{ route('members.edit', $member) }}" class="btn btn-primary">Edytuj</a>
            <a href="{{ route('members.index') }}" class="btn btn-outline-secondary">Powrót</a>
        </div>
    </div>

    <dl class="row">
        <dt class="col-sm-3">Imię</dt>
        <dd class="col-sm-9">{{ $member->first_name }}</dd>

        <dt class="col-sm-3">Nazwisko</dt>
        <dd class="col-sm-9">{{ $member->last_name }}</dd>

        <dt class="col-sm-3">E-mail</dt>
        <dd class="col-sm-9">{{ $member->email }}</dd>

        <dt class="col-sm-3">Telefon</dt>
        <dd class="col-sm-9">{{ $member->phone ?: '-' }}</dd>

        <dt class="col-sm-3">Data dołączenia</dt>
        <dd class="col-sm-9">{{ $member->joined_at->format('Y-m-d') }}</dd>

        <dt class="col-sm-3">Status</dt>
        <dd class="col-sm-9">{{ $member->status === 'active' ? 'aktywny' : 'nieaktywny' }}</dd>
    </dl>

    @if ($member->status !== 'inactive')
        <form method="POST" action="{{ route('members.deactivate', $member) }}">
            @csrf
            @method('PATCH')
            <button type="submit" class="btn btn-outline-danger">Dezaktywuj</button>
        </form>
    @endif
@endsection