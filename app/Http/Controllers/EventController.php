<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Member;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class EventController extends Controller
{
    public function index(): View
    {
        $events = Event::query()
            ->orderBy('event_date')
            ->get();

        return view('events.index', [
            'events' => $events,
        ]);
    }

    public function create(): View
    {
        return view('events.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate($this->rules());

        $event = Event::create($data);

        return redirect()
            ->route('events.show', $event)
            ->with('success', 'Wydarzenie zostało dodane.');
    }

    public function show(Event $event): View
    {
        $event->load('members');

        $availableMembers = Member::query()
            ->whereNotIn('id', $event->members->pluck('id'))
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->get();

        return view('events.show', [
            'event' => $event,
            'availableMembers' => $availableMembers,
        ]);
    }

    public function edit(Event $event): View
    {
        return view('events.edit', [
            'event' => $event,
        ]);
    }

    public function update(Request $request, Event $event): RedirectResponse
    {
        $data = $request->validate($this->rules());

        $event->update($data);

        return redirect()
            ->route('events.show', $event)
            ->with('success', 'Wydarzenie zostało zaktualizowane.');
    }

    public function destroy(Event $event): RedirectResponse
    {
        $event->update(['status' => 'cancelled']);

        return redirect()
            ->route('events.index')
            ->with('success', 'Wydarzenie zostało anulowane.');
    }

    private function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'event_date' => ['required', 'date', 'after_or_equal:2000-01-01'],
            'location' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status' => ['required', Rule::in(['planned', 'completed', 'cancelled'])],
        ];
    }
}