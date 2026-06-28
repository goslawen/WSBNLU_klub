<?php

namespace App\Http\Controllers;

use App\Models\Weapon;
use App\Models\WeaponType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class WeaponController extends Controller
{
    public function index(): View
    {
        $weapons = Weapon::query()
            ->with('weaponType')
            ->orderBy('name')
            ->get();

        return view('weapons.index', [
            'weapons' => $weapons,
        ]);
    }

    public function create(): View
    {
        return view('weapons.create', [
            'weaponTypes' => WeaponType::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate($this->rules());

        $weapon = Weapon::create($data);

        return redirect()
            ->route('weapons.show', $weapon)
            ->with('success', 'Broń została dodana.');
    }

    public function show(Weapon $weapon): View
    {
        $weapon->load('weaponType');

        return view('weapons.show', [
            'weapon' => $weapon,
        ]);
    }

    public function edit(Weapon $weapon): View
    {
        return view('weapons.edit', [
            'weapon' => $weapon,
            'weaponTypes' => WeaponType::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Weapon $weapon): RedirectResponse
    {
        $data = $request->validate($this->rules($weapon));

        $weapon->update($data);

        return redirect()
            ->route('weapons.show', $weapon)
            ->with('success', 'Dane broni zostały zaktualizowane.');
    }

    public function destroy(Weapon $weapon): RedirectResponse
    {
        return $this->deactivate($weapon);
    }

    public function deactivate(Weapon $weapon): RedirectResponse
    {
        $weapon->update(['status' => 'inactive']);

        return redirect()
            ->route('weapons.index')
            ->with('success', 'Broń została dezaktywowana.');
    }

    private function rules(?Weapon $weapon = null): array
    {
        return [
            'weapon_type_id' => ['required', Rule::exists('weapon_types', 'id')],
            'name' => ['required', 'string', 'max:255'],
            'caliber' => ['required', 'string', 'max:100'],
            'serial_number' => ['required', 'string', Rule::unique('weapons')->ignore($weapon?->id)],
            'status' => ['required', Rule::in(['available', 'assigned', 'inactive'])],
        ];
    }
}