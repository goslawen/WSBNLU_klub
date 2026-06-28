@extends('layouts.app')

@section('title', 'PodglÄ…d broni - WSBNLU Klub')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">{{ $weapon->name }}</h1>
        <div class="d-flex gap-2">
            <a href="{{ route('weapons.edit', $weapon) }}" class="btn btn-primary">Edytuj</a>
            <a href="{{ route('weapons.index') }}" class="btn btn-outline-secondary">PowrĂłt</a>
        </div>
    </div>

    <dl class="row">
        <dt class="col-sm-3">Nazwa</dt>
        <dd class="col-sm-9">{{ $weapon->name }}</dd>

        <dt class="col-sm-3">Typ broni</dt>
        <dd class="col-sm-9">{{ $weapon->weaponType->name }}</dd>

        <dt class="col-sm-3">Kaliber</dt>
        <dd class="col-sm-9">{{ $weapon->caliber }}</dd>

        <dt class="col-sm-3">Numer seryjny</dt>
        <dd class="col-sm-9">{{ $weapon->serial_number }}</dd>

        <dt class="col-sm-3">Status</dt>
        <dd class="col-sm-9">{{ $weapon->status }}</dd>
    </dl>

    @if ($weapon->status !== 'inactive')
        <form method="POST" action="{{ route('weapons.deactivate', $weapon) }}">
            @csrf
            @method('PATCH')
            <button type="submit" class="btn btn-outline-danger">Dezaktywuj broĹ„</button>
        </form>
    @endif
@endsection