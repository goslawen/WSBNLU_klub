@extends('layouts.app')

@section('title', 'Składki - WSBNLU Klub')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Składki</h1>
        <div class="d-flex gap-2">
            <a href="{{ route('fees.generate-form') }}" class="btn btn-outline-primary">Wygeneruj składki roczne</a>
            <a href="{{ route('fees.create') }}" class="btn btn-primary">Dodaj</a>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped align-middle">
            <thead>
                <tr>
                    <th>Członek</th>
                    <th>Rok</th>
                    <th>Kwota</th>
                    <th>Status</th>
                    <th>Data opłacenia</th>
                    <th class="text-end">Akcje</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($fees as $fee)
                    <tr>
                        <td>{{ $fee->member->first_name }} {{ $fee->member->last_name }}</td>
                        <td>{{ $fee->year }}</td>
                        <td>{{ number_format((float) $fee->amount, 2, ',', ' ') }} zł</td>
                        <td>@include('partials.status-badge', ['status' => $fee->status, 'labels' => ['cancelled' => 'anulowana']])</td>
                        <td>{{ $fee->paid_at ? $fee->paid_at->format('d.m.Y') : '-' }}</td>
                        <td class="text-end">
                            <a href="{{ route('fees.show', $fee) }}" class="btn btn-sm btn-outline-secondary">Pokaż</a>
                            <a href="{{ route('fees.edit', $fee) }}" class="btn btn-sm btn-outline-primary">Edytuj</a>
                            @if ($fee->status !== 'paid')
                                <form method="POST" action="{{ route('fees.mark-paid', $fee) }}" class="d-inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-sm btn-outline-success">Oznacz jako opłacone</button>
                                </form>
                            @endif
                            @if ($fee->status !== 'cancelled')
                                <form method="POST" action="{{ route('fees.destroy', $fee) }}" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Anuluj</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-muted">Brak składek.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection