@extends('layouts.app')

@section('title', 'Edytuj typ broni - WSBNLU Klub')

@section('content')
    <h1 class="h3 mb-3">Edytuj typ broni</h1>

    @if ($errors->any())
        <div class="alert alert-danger">Popraw błędy w formularzu.</div>
    @endif

    <form method="POST" action="{{ route('weapon-types.update', $weaponType) }}" class="row g-3">
        @csrf
        @method('PUT')

        <div class="col-md-6">
            <label for="name" class="form-label">Nazwa</label>
            <input type="text" name="name" id="name" value="{{ old('name', $weaponType->name) }}" class="form-control @error('name') is-invalid @enderror">
            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="col-12">
            <label for="description" class="form-label">Opis</label>
            <textarea name="description" id="description" rows="4" class="form-control @error('description') is-invalid @enderror">{{ old('description', $weaponType->description) }}</textarea>
            @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="col-12 d-flex gap-2">
            <button type="submit" class="btn btn-primary">Zapisz</button>
            <a href="{{ route('weapon-types.show', $weaponType) }}" class="btn btn-outline-secondary">Anuluj</a>
        </div>
    </form>
@endsection