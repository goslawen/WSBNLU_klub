<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Fee;
use App\Models\Member;
use App\Models\Weapon;
use App\Models\WeaponType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $members = collect([
            [
                'first_name' => 'Jan',
                'last_name' => 'Kowalski',
                'email' => 'jan.kowalski@example.com',
                'phone' => '500100200',
                'joined_at' => '2021-03-15',
                'status' => 'active',
            ],
            [
                'first_name' => 'Anna',
                'last_name' => 'Nowak',
                'email' => 'anna.nowak@example.com',
                'phone' => '501200300',
                'joined_at' => '2022-05-10',
                'status' => 'active',
            ],
            [
                'first_name' => 'Piotr',
                'last_name' => 'Zieliński',
                'email' => 'piotr.zielinski@example.com',
                'phone' => '502300400',
                'joined_at' => '2020-09-01',
                'status' => 'active',
            ],
            [
                'first_name' => 'Maria',
                'last_name' => 'Wiśniewska',
                'email' => 'maria.wisniewska@example.com',
                'phone' => '503400500',
                'joined_at' => '2023-01-20',
                'status' => 'active',
            ],
            [
                'first_name' => 'Tomasz',
                'last_name' => 'Wójcik',
                'email' => 'tomasz.wojcik@example.com',
                'phone' => null,
                'joined_at' => '2019-11-05',
                'status' => 'inactive',
            ],
        ])->map(fn (array $data) => Member::create($data));

        $weaponTypes = collect([
            [
                'name' => 'Pistolet sportowy',
                'description' => 'Broń krótka używana do treningu strzeleckiego.',
            ],
            [
                'name' => 'Karabin bocznego zapłonu',
                'description' => 'Karabin sportowy do strzelania na dystansie 50 metrów.',
            ],
            [
                'name' => 'Strzelba gładkolufowa',
                'description' => 'Broń przeznaczona do konkurencji dynamicznych i treningu.',
            ],
        ])->map(fn (array $data) => WeaponType::create($data));

        Weapon::insert([
            [
                'weapon_type_id' => $weaponTypes[0]->id,
                'name' => 'CZ Shadow 2',
                'caliber' => '9x19 mm',
                'serial_number' => 'WSB-P-001',
                'status' => 'available',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'weapon_type_id' => $weaponTypes[0]->id,
                'name' => 'Glock 17',
                'caliber' => '9x19 mm',
                'serial_number' => 'WSB-P-002',
                'status' => 'assigned',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'weapon_type_id' => $weaponTypes[1]->id,
                'name' => 'Anschutz 1903',
                'caliber' => '.22 LR',
                'serial_number' => 'WSB-K-001',
                'status' => 'available',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'weapon_type_id' => $weaponTypes[1]->id,
                'name' => 'CZ 457',
                'caliber' => '.22 LR',
                'serial_number' => 'WSB-K-002',
                'status' => 'inactive',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'weapon_type_id' => $weaponTypes[2]->id,
                'name' => 'Mossberg 500',
                'caliber' => '12/76',
                'serial_number' => 'WSB-S-001',
                'status' => 'available',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        $events = collect([
            [
                'name' => 'Trening pistoletowy',
                'event_date' => '2026-04-12',
                'location' => 'Strzelnica miejska, stanowiska 1-5',
                'description' => 'Podstawowy trening celności z broni krótkiej.',
                'status' => 'planned',
            ],
            [
                'name' => 'Zawody klubowe w karabinie',
                'event_date' => '2026-03-02',
                'location' => 'Strzelnica 50 m',
                'description' => 'Wewnętrzne zawody klubowe dla członków.',
                'status' => 'completed',
            ],
            [
                'name' => 'Spotkanie kolekcjonerskie',
                'event_date' => '2026-02-10',
                'location' => 'Sala klubowa',
                'description' => 'Prezentacja wybranych egzemplarzy broni kolekcjonerskiej.',
                'status' => 'cancelled',
            ],
        ])->map(fn (array $data) => Event::create($data));

        Fee::insert([
            [
                'member_id' => $members[0]->id,
                'year' => 2026,
                'amount' => 240.00,
                'status' => 'paid',
                'paid_at' => '2026-01-15',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'member_id' => $members[1]->id,
                'year' => 2026,
                'amount' => 240.00,
                'status' => 'paid',
                'paid_at' => '2026-01-20',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'member_id' => $members[2]->id,
                'year' => 2026,
                'amount' => 240.00,
                'status' => 'unpaid',
                'paid_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'member_id' => $members[3]->id,
                'year' => 2026,
                'amount' => 240.00,
                'status' => 'unpaid',
                'paid_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'member_id' => $members[4]->id,
                'year' => 2026,
                'amount' => 240.00,
                'status' => 'cancelled',
                'paid_at' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'member_id' => $members[0]->id,
                'year' => 2025,
                'amount' => 220.00,
                'status' => 'paid',
                'paid_at' => '2025-01-18',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        $events[0]->members()->attach([$members[0]->id, $members[1]->id, $members[2]->id]);
        $events[1]->members()->attach([$members[0]->id, $members[3]->id]);
        $events[2]->members()->attach([$members[4]->id]);
    }
}
