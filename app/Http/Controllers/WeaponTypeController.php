<?php

namespace App\Http\Controllers;

use App\Models\WeaponType;
use Illuminate\Http\Response;

class WeaponTypeController extends Controller
{
    public function index(): Response
    {
        return response('Lista typĂłw broni');
    }

    public function create(): Response
    {
        return response('Formularz dodawania typu broni');
    }

    public function store(): Response
    {
        return response('Zapis typu broni');
    }

    public function show(WeaponType $weapon_type): Response
    {
        return response('SzczegĂłĹ‚y typu broni: '.$weapon_type->name);
    }

    public function edit(WeaponType $weapon_type): Response
    {
        return response('Edycja typu broni: '.$weapon_type->name);
    }

    public function update(WeaponType $weapon_type): Response
    {
        return response('Aktualizacja typu broni');
    }

    public function destroy(WeaponType $weapon_type): Response
    {
        return response('Usuwanie typu broni');
    }
}