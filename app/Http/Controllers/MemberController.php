<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

class MemberController extends Controller
{
    public function index(): Response
    {
        return response('Lista członków');
    }

    public function create(): Response
    {
        return response('Formularz dodawania członka');
    }

    public function store(): Response
    {
        return response('Zapis członka');
    }

    public function show(Member $member): Response
    {
        return response('Szczegóły członka: '.$member->first_name.' '.$member->last_name);
    }

    public function edit(Member $member): Response
    {
        return response('Edycja członka: '.$member->first_name.' '.$member->last_name);
    }

    public function update(Member $member): Response
    {
        return response('Aktualizacja członka');
    }

    public function destroy(Member $member): RedirectResponse
    {
        return $this->deactivate($member);
    }

    public function deactivate(Member $member): RedirectResponse
    {
        $member->update(['status' => 'inactive']);

        return redirect()->route('members.index');
    }
}