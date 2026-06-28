<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

class EventController extends Controller
{
    public function index(): Response
    {
        return response('Lista wydarzeń');
    }

    public function create(): Response
    {
        return response('Formularz dodawania wydarzenia');
    }

    public function store(): Response
    {
        return response('Zapis wydarzenia');
    }

    public function show(Event $event): Response
    {
        return response('Szczegóły wydarzenia: '.$event->name);
    }

    public function edit(Event $event): Response
    {
        return response('Edycja wydarzenia: '.$event->name);
    }

    public function update(Event $event): Response
    {
        return response('Aktualizacja wydarzenia');
    }

    public function destroy(Event $event): RedirectResponse
    {
        $event->update(['status' => 'cancelled']);

        return redirect()->route('events.index');
    }
}