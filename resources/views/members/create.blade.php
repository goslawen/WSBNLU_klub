@extends('layouts.app')

@section('title', 'Dodaj czĹ‚onka - WSBNLU Klub')

@section('content')
    <h1 class="h3 mb-3">Dodaj czĹ‚onka</h1>

    @if ($errors->any())
        <div class="alert alert-danger">Popraw bĹ‚Ä™dy w formularzu.</div>
    @endif

    <form method="POST" action="{{ route('members.store') }}" class="row g-3">
        @csrf

        <div class="col-md-6">
            <label for="first_name" class="form-label">ImiÄ™</label>
            <input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}" class="form-control @error('first_name') is-invalid @enderror">
            @error('first_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="col-md-6">
            <label for="last_name" class="form-label">Nazwisko</label>
            <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}" class="form-control @error('last_name') is-invalid @enderror">
            @error('last_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="col-md-6">
            <label for="email" class="form-label">E-mail</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-control @error('email') is-invalid @enderror">
            @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="col-md-6">
            <label for="phone" class="form-label">Telefon</label>
            <input type="text" name="phone" id="phone" value="{{ old('phone') }}" class="form-control @error('phone') is-invalid @enderror">
            @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="col-md-6">
            <label for="joined_at" class="form-label">Data doĹ‚Ä…czenia</label>
            <input type="date" name="joined_at" id="joined_at" value="{{ old('joined_at') }}" class="form-control @error('joined_at') is-invalid @enderror">
            @error('joined_at')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="col-md-6">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-select @error('status') is-invalid @enderror">
                <option value="active" @selected(old('status', 'active') === 'active')>aktywny</option>
                <option value="inactive" @selected(old('status') === 'inactive')>nieaktywny</option>
            </select>
            @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="col-12 d-flex gap-2">
            <button type="submit" class="btn btn-primary">Zapisz</button>
            <a href="{{ route('members.index') }}" class="btn btn-outline-secondary">Anuluj</a>
        </div>
    </form>
@endsection