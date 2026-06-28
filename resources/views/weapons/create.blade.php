@extends('layouts.app')

@section('title', 'Dodaj broń - WSBNLU Klub')

@section('content')
    <h1 class="h3 mb-3">Dodaj broń</h1>

    @if ($errors->any())
        <div class="alert alert-danger">Popraw błędy w formularzu.</div>
    @endif

    <form method="POST" action="{{ route('weapons.store') }}" class="row g-3">
        @csrf

        <div class="col-md-6">
            <label for="weapon_type_id" class="form-label">Typ broni</label>
            <select name="weapon_type_id" id="weapon_type_id" class="form-select @error('weapon_type_id') is-invalid @enderror">
                <option value="">Wybierz typ broni</option>
                @foreach ($weaponTypes as $weaponType)
                    <option value="{{ $weaponType->id }}" @selected((string) old('weapon_type_id') === (string) $weaponType->id)>{{ $weaponType->name }}</option>
                @endforeach
            </select>
            @error('weapon_type_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="col-md-6">
            <label for="name" class="form-label">Nazwa</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror">
            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="col-md-6">
            <label for="caliber" class="form-label">Kaliber</label>
            <input type="text" name="caliber" id="caliber" value="{{ old('caliber') }}" class="form-control @error('caliber') is-invalid @enderror">
            @error('caliber')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="col-md-6">
            <label for="serial_number" class="form-label">Numer seryjny</label>
            <input type="text" name="serial_number" id="serial_number" value="{{ old('serial_number') }}" class="form-control @error('serial_number') is-invalid @enderror">
            @error('serial_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="col-md-6">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-select @error('status') is-invalid @enderror">
                <option value="available" @selected(old('status', 'available') === 'available')>dostępna</option>
                <option value="assigned" @selected(old('status') === 'assigned')>przypisana</option>
                <option value="inactive" @selected(old('status') === 'inactive')>nieaktywny</option>
            </select>
            @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="col-12 d-flex gap-2">
            <button type="submit" class="btn btn-primary">Zapisz</button>
            <a href="{{ route('weapons.index') }}" class="btn btn-outline-secondary">Anuluj</a>
        </div>
    </form>
@endsection