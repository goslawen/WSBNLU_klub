<?php

namespace Tests\Feature;

use App\Models\WeaponType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WeaponTypeTest extends TestCase
{
    use RefreshDatabase;

    public function test_weapon_types_list_works(): void
    {
        WeaponType::create([
            'name' => 'Pistolet sportowy',
            'description' => 'Broń krótka do treningu.',
        ]);

        $response = $this->get(route('weapon-types.index'));

        $response->assertOk();
        $response->assertSee('Pistolet sportowy');
    }

    public function test_weapon_type_can_be_created(): void
    {
        $response = $this->post(route('weapon-types.store'), [
            'name' => 'Karabin sportowy',
            'description' => 'Broń długa do strzelania tarczowego.',
        ]);

        $weaponType = WeaponType::where('name', 'Karabin sportowy')->first();

        $this->assertNotNull($weaponType);
        $response->assertRedirect(route('weapon-types.show', $weaponType));
        $this->assertDatabaseHas('weapon_types', [
            'name' => 'Karabin sportowy',
        ]);
    }

    public function test_weapon_type_name_is_required(): void
    {
        $response = $this->post(route('weapon-types.store'), [
            'description' => 'Opis bez nazwy.',
        ]);

        $response->assertSessionHasErrors(['name']);
    }

    public function test_weapon_type_name_must_have_at_least_three_characters(): void
    {
        $response = $this->post(route('weapon-types.store'), [
            'name' => 'AK',
            'description' => 'Za krótka nazwa.',
        ]);

        $response->assertSessionHasErrors(['name']);
    }
}