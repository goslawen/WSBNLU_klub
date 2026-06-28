<?php

namespace App\Http\Controllers;

use App\Models\Fee;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

class FeeController extends Controller
{
    public function index(): Response
    {
        return response('Lista składek');
    }

    public function create(): Response
    {
        return response('Formularz dodawania składki');
    }

    public function store(): Response
    {
        return response('Zapis składki');
    }

    public function show(Fee $fee): Response
    {
        return response('Szczegóły składki: '.$fee->year);
    }

    public function edit(Fee $fee): Response
    {
        return response('Edycja składki: '.$fee->year);
    }

    public function update(Fee $fee): Response
    {
        return response('Aktualizacja składki');
    }

    public function destroy(Fee $fee): RedirectResponse
    {
        $fee->update(['status' => 'cancelled']);

        return redirect()->route('fees.index');
    }

    public function markPaid(Fee $fee): RedirectResponse
    {
        $fee->update([
            'status' => 'paid',
            'paid_at' => now(),
        ]);

        return redirect()->route('fees.index');
    }
}