@extends('layouts.app')

@section('title', 'PodglÄ…d skĹ‚adki - WSBNLU Klub')

@section('content')
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">SkĹ‚adka {{ $fee->year }}</h1>
        <div class="d-flex gap-2">
            <a href="{{ route('fees.edit', $fee) }}" class="btn btn-primary">Edytuj</a>
            <a href="{{ route('fees.index') }}" class="btn btn-outline-secondary">PowrĂłt</a>
        </div>
    </div>

    <dl class="row">
        <dt class="col-sm-3">CzĹ‚onek</dt>
        <dd class="col-sm-9">{{ $fee->member->first_name }} {{ $fee->member->last_name }}</dd>

        <dt class="col-sm-3">Rok</dt>
        <dd class="col-sm-9">{{ $fee->year }}</dd>

        <dt class="col-sm-3">Kwota</dt>
        <dd class="col-sm-9">{{ number_format((float) $fee->amount, 2, ',', ' ') }} zĹ‚</dd>

        <dt class="col-sm-3">Status</dt>
        <dd class="col-sm-9">{{ $fee->status }}</dd>

        <dt class="col-sm-3">Data opĹ‚acenia</dt>
        <dd class="col-sm-9">{{ $fee->paid_at?->format('Y-m-d') ?: '-' }}</dd>
    </dl>

    <div class="d-flex gap-2">
        @if ($fee->status !== 'paid')
            <form method="POST" action="{{ route('fees.mark-paid', $fee) }}">
                @csrf
                @method('PATCH')
                <button type="submit" class="btn btn-outline-success">Oznacz jako opĹ‚aconÄ…</button>
            </form>
        @endif
        @if ($fee->status !== 'cancelled')
            <form method="POST" action="{{ route('fees.destroy', $fee) }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-outline-danger">Anuluj skĹ‚adkÄ™</button>
            </form>
        @endif
    </div>
@endsection