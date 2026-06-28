<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Member;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EventMemberController extends Controller
{
    public function store(Request $request, Event $event): RedirectResponse
    {
        $data = $request->validate([
            'member_id' => [
                'required',
                Rule::exists('members', 'id'),
                Rule::unique('event_member', 'member_id')->where('event_id', $event->id),
            ],
        ]);

        $event->members()->attach($data['member_id']);

        return redirect()
            ->route('events.show', $event)
            ->with('success', 'Członek został przypisany do wydarzenia.');
    }

    public function destroy(Event $event, Member $member): RedirectResponse
    {
        $event->members()->detach($member->id);

        return redirect()
            ->route('events.show', $event)
            ->with('success', 'Członek został usunięty z wydarzenia.');
    }
}