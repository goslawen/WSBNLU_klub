<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class MemberController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->string('search')->toString();

        $members = Member::query()
            ->when($search, function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('first_name', 'like', "%{$search}%")
                        ->orWhere('last_name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->get();

        return view('members.index', [
            'members' => $members,
            'search' => $search,
        ]);
    }

    public function create(): View
    {
        return view('members.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate($this->rules());

        $member = Member::create($data);

        return redirect()
            ->route('members.show', $member)
            ->with('success', 'Członek został dodany.');
    }

    public function show(Member $member): View
    {
        return view('members.show', [
            'member' => $member,
        ]);
    }

    public function edit(Member $member): View
    {
        return view('members.edit', [
            'member' => $member,
        ]);
    }

    public function update(Request $request, Member $member): RedirectResponse
    {
        $data = $request->validate($this->rules($member));

        $member->update($data);

        return redirect()
            ->route('members.show', $member)
            ->with('success', 'Dane członka zostały zaktualizowane.');
    }

    public function destroy(Member $member): RedirectResponse
    {
        return $this->deactivate($member);
    }

    public function deactivate(Member $member): RedirectResponse
    {
        $member->update(['status' => 'inactive']);

        return redirect()
            ->route('members.index')
            ->with('success', 'Członek został dezaktywowany.');
    }

    private function rules(?Member $member = null): array
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', Rule::unique('members')->ignore($member?->id)],
            'phone' => ['nullable', 'string', 'max:50'],
            'joined_at' => ['required', 'date'],
            'status' => ['required', Rule::in(['active', 'inactive'])],
        ];
    }
}