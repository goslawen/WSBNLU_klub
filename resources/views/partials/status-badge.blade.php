@php
    $statusColors = [
        'active' => 'success',
        'inactive' => 'secondary',
        'available' => 'success',
        'assigned' => 'primary',
        'planned' => 'primary',
        'completed' => 'success',
        'cancelled' => 'secondary',
        'unpaid' => 'warning',
        'paid' => 'success',
    ];

    $statusLabels = [
        'active' => 'aktywny',
        'inactive' => 'nieaktywny',
        'available' => 'dostępna',
        'assigned' => 'przypisana',
        'planned' => 'planowane',
        'completed' => 'zakończone',
        'cancelled' => 'anulowane',
        'unpaid' => 'nieopłacona',
        'paid' => 'opłacona',
    ];

    $statusLabels = array_replace($statusLabels, $labels ?? []);
@endphp

<span class="badge bg-{{ $statusColors[$status] ?? 'secondary' }}">
    {{ $statusLabels[$status] ?? $status }}
</span>