@extends('layouts.app')

@section('title', 'Wygeneruj składki roczne - WSBNLU Klub')

@section('content')
    <h1 class="h3 mb-3">Wygeneruj składki roczne</h1>

    @if ($errors->any())
        <div class="alert alert-danger">Popraw błędy w formularzu.</div>
    @endif

    <form method="POST" action="{{ route('fees.generate') }}" class="card card-body">
        @csrf

        <div class="mb-3">
            <label for="year" class="form-label">Rok</label>
            <input type="number" name="year" id="year" value="{{ old('year', date('Y')) }}" class="form-control @error('year') is-invalid @enderror" min="2000" max="2100">
            @error('year')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="amount" class="form-label">Kwota</label>
            <input type="number" step="0.01" name="amount" id="amount" value="{{ old('amount', '240.00') }}" class="form-control @error('amount') is-invalid @enderror" min="0">
            @error('amount')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Wygeneruj składki</button>
            <a href="{{ route('fees.index') }}" class="btn btn-outline-secondary">Anuluj</a>
        </div>
    </form>
@endsection