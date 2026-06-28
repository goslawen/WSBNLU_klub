<?php

namespace App\Http\Controllers;

use App\Models\WeaponType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class WeaponTypeController extends Controller
{
    public function index(): View
    {
        $weaponTypes = WeaponType::query()
            ->orderBy('name')
            ->get();

        return view('weapon-types.index', [
            'weaponTypes' => $weaponTypes,
        ]);
    }

    public function create(): View
    {
        return view('weapon-types.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate($this->rules());

        $weaponType = WeaponType::create($data);

        return redirect()
            ->route('weapon-types.show', $weaponType)
            ->with('success', 'Typ broni został dodany.');
    }

    public function show(WeaponType $weapon_type): View
    {
        $weapon_type->load('weapons');

        return view('weapon-types.show', [
            'weaponType' => $weapon_type,
        ]);
    }

    public function edit(WeaponType $weapon_type): View
    {
        return view('weapon-types.edit', [
            'weaponType' => $weapon_type,
        ]);
    }

    public function update(Request $request, WeaponType $weapon_type): RedirectResponse
    {
        $data = $request->validate($this->rules($weapon_type));

        $weapon_type->update($data);

        return redirect()
            ->route('weapon-types.show', $weapon_type)
            ->with('success', 'Typ broni został zaktualizowany.');
    }

    public function destroy(WeaponType $weapon_type): RedirectResponse
    {
        $weapon_type->delete();

        return redirect()
            ->route('weapon-types.index')
            ->with('success', 'Typ broni został usunięty.');
    }

    private function rules(?WeaponType $weaponType = null): array
    {
        return [
            'name' => ['required', 'string', 'min:3', Rule::unique('weapon_types')->ignore($weaponType?->id)],
            'description' => ['nullable', 'string'],
        ];
    }
}