@extends('layouts.app')

@section('title', 'Dodaj wydarzenie - WSBNLU Klub')

@section('content')
    <h1 class="h3 mb-3">Dodaj wydarzenie</h1>

    @if ($errors->any())
        <div class="alert alert-danger">Popraw bĹ‚Ä™dy w formularzu.</div>
    @endif

    <form method="POST" action="{{ route('events.store') }}" class="row g-3">
        @csrf

        <div class="col-md-6">
            <label for="name" class="form-label">Nazwa</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror">
            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="col-md-6">
            <label for="event_date" class="form-label">Data</label>
            <input type="date" name="event_date" id="event_date" value="{{ old('event_date') }}" class="form-control @error('event_date') is-invalid @enderror">
            @error('event_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="col-md-6">
            <label for="location" class="form-label">Miejsce</label>
            <input type="text" name="location" id="location" value="{{ old('location') }}" class="form-control @error('location') is-invalid @enderror">
            @error('location')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="col-md-6">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-select @error('status') is-invalid @enderror">
                <option value="planned" @selected(old('status', 'planned') === 'planned')>planowane</option>
                <option value="completed" @selected(old('status') === 'completed')>zakoĹ„czone</option>
                <option value="cancelled" @selected(old('status') === 'cancelled')>anulowane</option>
            </select>
            @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="col-12">
            <label for="description" class="form-label">Opis</label>
            <textarea name="description" id="description" rows="4" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
            @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="col-12 d-flex gap-2">
            <button type="submit" class="btn btn-primary">Zapisz</button>
            <a href="{{ route('events.index') }}" class="btn btn-outline-secondary">Anuluj</a>
        </div>
    </form>
@endsection