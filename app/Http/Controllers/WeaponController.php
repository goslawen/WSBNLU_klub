<?php

namespace App\Http\Controllers;

use App\Models\Weapon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

class WeaponController extends Controller
{
    public function index(): Response
    {
        return response('Lista broni');
    }

    public function create(): Response
    {
        return response('Formularz dodawania broni');
    }

    public function store(): Response
    {
        return response('Zapis broni');
    }

    public function show(Weapon $weapon): Response
    {
        return response('Szczegóły broni: '.$weapon->name);
    }

    public function edit(Weapon $weapon): Response
    {
        return response('Edycja broni: '.$weapon->name);
    }

    public function update(Weapon $weapon): Response
    {
        return response('Aktualizacja broni');
    }

    public function destroy(Weapon $weapon): RedirectResponse
    {
        return $this->deactivate($weapon);
    }

    public function deactivate(Weapon $weapon): RedirectResponse
    {
        $weapon->update(['status' => 'inactive']);

        return redirect()->route('weapons.index');
    }
}