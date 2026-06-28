<?php

namespace Tests\Feature;

use App\Models\Weapon;
use App\Models\WeaponType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WeaponTest extends TestCase
{
    use RefreshDatabase;

    public function test_weapons_list_works(): void
    {
        $weaponType = WeaponType::create([
            'name' => 'Pistolet sportowy',
        ]);

        Weapon::create([
            'weapon_type_id' => $weaponType->id,
            'name' => 'CZ Shadow 2',
            'caliber' => '9x19 mm',
            'serial_number' => 'TEST-P-001',
            'status' => 'available',
        ]);

        $response = $this->get(route('weapons.index'));

        $response->assertOk();
        $response->assertSee('CZ Shadow 2');
        $response->assertSee('Pistolet sportowy');
    }

    public function test_weapon_can_be_created(): void
    {
        $weaponType = WeaponType::create([
            'name' => 'Karabin sportowy',
        ]);

        $response = $this->post(route('weapons.store'), [
            'weapon_type_id' => $weaponType->id,
            'name' => 'CZ 457',
            'caliber' => '.22 LR',
            'serial_number' => 'TEST-K-001',
            'status' => 'available',
        ]);

        $weapon = Weapon::where('serial_number', 'TEST-K-001')->first();

        $this->assertNotNull($weapon);
        $response->assertRedirect(route('weapons.show', $weapon));
        $this->assertDatabaseHas('weapons', [
            'name' => 'CZ 457',
            'serial_number' => 'TEST-K-001',
            'status' => 'available',
        ]);
    }

    public function test_weapon_type_is_required(): void
    {
        $response = $this->post(route('weapons.store'), [
            'name' => 'Mossberg 500',
            'caliber' => '12/76',
            'serial_number' => 'TEST-S-001',
            'status' => 'available',
        ]);

        $response->assertSessionHasErrors(['weapon_type_id']);
    }

    public function test_weapon_serial_number_is_required(): void
    {
        $weaponType = WeaponType::create([
            'name' => 'Strzelba sportowa',
        ]);

        $response = $this->post(route('weapons.store'), [
            'weapon_type_id' => $weaponType->id,
            'name' => 'Mossberg 500',
            'caliber' => '12/76',
            'status' => 'available',
        ]);

        $response->assertSessionHasErrors(['serial_number']);
    }

    public function test_weapon_can_be_deactivated(): void
    {
        $weaponType = WeaponType::create([
            'name' => 'Pistolet centralnego zapłonu',
        ]);

        $weapon = Weapon::create([
            'weapon_type_id' => $weaponType->id,
            'name' => 'Glock 17',
            'caliber' => '9x19 mm',
            'serial_number' => 'TEST-P-002',
            'status' => 'available',
        ]);

        $response = $this->patch(route('weapons.deactivate', $weapon));

        $response->assertRedirect(route('weapons.index'));
        $this->assertDatabaseHas('weapons', [
            'id' => $weapon->id,
            'status' => 'inactive',
        ]);
    }
}