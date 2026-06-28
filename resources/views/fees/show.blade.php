@extends('layouts.app')

@section('title', 'Podgląd składki - WSBNLU Klub')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Składka {{ $fee->year }}</h1>
        <div class="d-flex gap-2">
            <a href="{{ route('fees.edit', $fee) }}" class="btn btn-primary">Edytuj</a>
            <a href="{{ route('fees.index') }}" class="btn btn-outline-secondary">Powrót</a>
        </div>
    </div>

    <dl class="row">
        <dt class="col-sm-3">Członek</dt>
        <dd class="col-sm-9">{{ $fee->member->first_name }} {{ $fee->member->last_name }}</dd>

        <dt class="col-sm-3">Rok</dt>
        <dd class="col-sm-9">{{ $fee->year }}</dd>

        <dt class="col-sm-3">Kwota</dt>
        <dd class="col-sm-9">{{ number_format((float) $fee->amount, 2, ',', ' ') }} zł</dd>

        <dt class="col-sm-3">Status</dt>
        <dd class="col-sm-9">@include('partials.status-badge', ['status' => $fee->status, 'labels' => ['cancelled' => 'anulowana']])</dd>

        <dt class="col-sm-3">Data opłacenia</dt>
        <dd class="col-sm-9">{{ $fee->paid_at?->format('Y-m-d') ?: '-' }}</dd>
    </dl>

    <div class="d-flex gap-2">
        @if ($fee->status !== 'paid')
            <form method="POST" action="{{ route('fees.mark-paid', $fee) }}">
                @csrf
                @method('PATCH')
                <button type="submit" class="btn btn-outline-success">Oznacz jako opłacone</button>
            </form>
        @endif
        @if ($fee->status !== 'cancelled')
            <form method="POST" action="{{ route('fees.destroy', $fee) }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline-danger">Anuluj</button>
            </form>
        @endif
    </div>
@endsection