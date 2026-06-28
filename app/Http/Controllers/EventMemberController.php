<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Member;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class EventMemberController extends Controller
{
    public function store(Request $request, Event $event): RedirectResponse
    {
        $memberId = $request->input('member_id');

        if ($memberId) {
            $event->members()->syncWithoutDetaching([$memberId]);
        }

        return redirect()->route('events.show', $event);
    }

    public function destroy(Event $event, Member $member): RedirectResponse
    {
        $event->members()->detach($member->id);

        return redirect()->route('events.show', $event);
    }
}