@php
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

    $statusClasses = [
        'active' => 'success',
        'inactive' => 'secondary',
        'available' => 'success',
        'assigned' => 'primary',
        'planned' => 'info',
        'completed' => 'success',
        'cancelled' => 'secondary',
        'unpaid' => 'warning',
        'paid' => 'success',
    ];
@endphp

<span class="badge text-bg-{{ $statusClasses[$status] ?? 'secondary' }}">
    {{ $statusLabels[$status] ?? $status }}
</span>
