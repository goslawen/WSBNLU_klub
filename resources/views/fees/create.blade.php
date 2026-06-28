@extends('layouts.app')

@section('title', 'Dodaj skĹ‚adkÄ™ - WSBNLU Klub')

@section('content')
    <h1 class="h3 mb-3">Dodaj skĹ‚adkÄ™</h1>

    @if ($errors->any())
        <div class="alert alert-danger">Popraw bĹ‚Ä™dy w formularzu.</div>
    @endif

    <form method="POST" action="{{ route('fees.store') }}" class="row g-3">
        @csrf

        <div class="col-md-6">
            <label for="member_id" class="form-label">CzĹ‚onek</label>
            <select name="member_id" id="member_id" class="form-select @error('member_id') is-invalid @enderror">
                <option value="">Wybierz czĹ‚onka</option>
                @foreach ($members as $member)
                    <option value="{{ $member->id }}" @selected((string) old('member_id') === (string) $member->id)>{{ $member->last_name }} {{ $member->first_name }} ({{ $member->email }})</option>
                @endforeach
            </select>
            @error('member_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="col-md-6">
            <label for="year" class="form-label">Rok</label>
            <input type="number" name="year" id="year" value="{{ old('year', date('Y')) }}" class="form-control @error('year') is-invalid @enderror">
            @error('year')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="col-md-6">
            <label for="amount" class="form-label">Kwota</label>
            <input type="number" step="0.01" min="0" name="amount" id="amount" value="{{ old('amount') }}" class="form-control @error('amount') is-invalid @enderror">
            @error('amount')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="col-md-6">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-select @error('status') is-invalid @enderror">
                <option value="unpaid" @selected(old('status', 'unpaid') === 'unpaid')>nieopĹ‚acona</option>
                <option value="paid" @selected(old('status') === 'paid')>opĹ‚acona</option>
                <option value="cancelled" @selected(old('status') === 'cancelled')>anulowana</option>
            </select>
            @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="col-md-6">
            <label for="paid_at" class="form-label">Data opĹ‚acenia</label>
            <input type="date" name="paid_at" id="paid_at" value="{{ old('paid_at') }}" class="form-control @error('paid_at') is-invalid @enderror">
            @error('paid_at')<div class="invalid-feedback">{{ $message }}</div>@enderror
        </div>

        <div class="col-12 d-flex gap-2">
            <button type="submit" class="btn btn-primary">Zapisz</button>
            <a href="{{ route('fees.index') }}" class="btn btn-outline-secondary">Anuluj</a>
        </div>
    </form>
@endsection