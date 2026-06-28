<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\Fee;
use App\Models\Member;
use App\Models\Weapon;
use App\Models\WeaponType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClubCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_works(): void
    {
        $response = $this->get(route('home'));

        $response->assertOk();
        $response->assertSee('Aplikacja');
    }

    public function test_members_list_works(): void
    {
        $member = $this->createMember('jan.lista@example.com');

        $response = $this->get(route('members.index'));

        $response->assertOk();
        $response->assertSee($member->first_name);
        $response->assertSee($member->last_name);
    }

    public function test_member_can_be_created(): void
    {
        $response = $this->post(route('members.store'), [
            'first_name' => 'Anna',
            'last_name' => 'Nowak',
            'email' => 'anna.nowak@example.com',
            'phone' => '500100200',
            'joined_at' => '2026-01-10',
            'status' => 'active',
        ]);

        $member = Member::where('email', 'anna.nowak@example.com')->first();

        $this->assertNotNull($member);
        $response->assertRedirect(route('members.show', $member));
        $this->assertDatabaseHas('members', [
            'first_name' => 'Anna',
            'last_name' => 'Nowak',
            'email' => 'anna.nowak@example.com',
            'status' => 'active',
        ]);
    }

    public function test_member_required_fields_are_validated(): void
    {
        $response = $this->post(route('members.store'), [
            'phone' => '500100200',
            'joined_at' => '2026-01-10',
            'status' => 'active',
        ]);

        $response->assertSessionHasErrors(['first_name', 'last_name', 'email']);
        $this->assertDatabaseMissing('members', [
            'phone' => '500100200',
        ]);
    }

    public function test_members_search_works(): void
    {
        $this->createMember('maria@example.com', 'Maria', 'Wisniewska');
        $this->createMember('piotr@example.com', 'Piotr', 'Zielinski');

        $response = $this->get(route('members.index', ['search' => 'Maria']));

        $response->assertOk();
        $response->assertSee('Maria');
        $response->assertDontSee('Piotr');
    }

    public function test_member_can_be_deactivated(): void
    {
        $member = $this->createMember('dezaktywacja@example.com');

        $response = $this->delete(route('members.destroy', $member));

        $response->assertRedirect(route('members.index'));
        $this->assertDatabaseHas('members', [
            'id' => $member->id,
            'status' => 'inactive',
        ]);
    }

    public function test_weapon_types_list_works(): void
    {
        $weaponType = $this->createWeaponType('Pistolet');

        $response = $this->get(route('weapon-types.index'));

        $response->assertOk();
        $response->assertSee($weaponType->name);
    }

    public function test_weapon_type_can_be_created(): void
    {
        $response = $this->post(route('weapon-types.store'), [
            'name' => 'Karabin',
            'description' => 'Bron dluga do ewidencji klubowej.',
        ]);

        $weaponType = WeaponType::where('name', 'Karabin')->first();

        $this->assertNotNull($weaponType);
        $response->assertRedirect(route('weapon-types.show', $weaponType));
        $this->assertDatabaseHas('weapon_types', [
            'name' => 'Karabin',
        ]);
    }

    public function test_short_weapon_type_name_is_rejected(): void
    {
        $response = $this->post(route('weapon-types.store'), [
            'name' => 'AK',
            'description' => 'Za krotka nazwa.',
        ]);

        $response->assertSessionHasErrors(['name']);
        $this->assertDatabaseMissing('weapon_types', [
            'name' => 'AK',
        ]);
    }

    public function test_weapon_can_be_created(): void
    {
        $weaponType = $this->createWeaponType();

        $response = $this->post(route('weapons.store'), [
            'weapon_type_id' => $weaponType->id,
            'name' => 'Glock 17',
            'caliber' => '9x19 mm',
            'serial_number' => 'ABC123',
            'status' => 'available',
        ]);

        $weapon = Weapon::where('serial_number', 'ABC123')->first();

        $this->assertNotNull($weapon);
        $response->assertRedirect(route('weapons.show', $weapon));
        $this->assertDatabaseHas('weapons', [
            'weapon_type_id' => $weaponType->id,
            'name' => 'Glock 17',
            'serial_number' => 'ABC123',
            'status' => 'available',
        ]);
    }

    public function test_weapon_type_is_required_for_weapon(): void
    {
        $response = $this->post(route('weapons.store'), [
            'name' => 'CZ 75',
            'caliber' => '9x19 mm',
            'serial_number' => 'NO-TYPE-1',
            'status' => 'available',
        ]);

        $response->assertSessionHasErrors(['weapon_type_id']);
        $this->assertDatabaseMissing('weapons', [
            'serial_number' => 'NO-TYPE-1',
        ]);
    }

    public function test_weapon_can_be_deactivated(): void
    {
        $weapon = $this->createWeapon('DEACT-1');

        $response = $this->delete(route('weapons.destroy', $weapon));

        $response->assertRedirect(route('weapons.index'));
        $this->assertDatabaseHas('weapons', [
            'id' => $weapon->id,
            'status' => 'inactive',
        ]);
    }

    public function test_event_can_be_created(): void
    {
        $response = $this->post(route('events.store'), [
            'name' => 'Trening klubowy',
            'event_date' => '2026-02-15',
            'location' => 'Strzelnica miejska',
            'description' => 'Trening dla czlonkow klubu.',
            'status' => 'planned',
        ]);

        $event = Event::where('name', 'Trening klubowy')->first();

        $this->assertNotNull($event);
        $response->assertRedirect(route('events.show', $event));
        $this->assertDatabaseHas('events', [
            'name' => 'Trening klubowy',
            'status' => 'planned',
        ]);
    }

    public function test_event_can_be_cancelled(): void
    {
        $event = $this->createEvent();

        $response = $this->delete(route('events.destroy', $event));

        $response->assertRedirect(route('events.index'));
        $this->assertDatabaseHas('events', [
            'id' => $event->id,
            'status' => 'cancelled',
        ]);
    }

    public function test_member_can_be_assigned_to_event(): void
    {
        $event = $this->createEvent();
        $member = $this->createMember('uczestnik@example.com');

        $response = $this->post(route('events.members.store', $event), [
            'member_id' => $member->id,
        ]);

        $response->assertRedirect(route('events.show', $event));
        $this->assertDatabaseHas('event_member', [
            'event_id' => $event->id,
            'member_id' => $member->id,
        ]);
    }

    public function test_same_member_cannot_be_assigned_to_event_twice(): void
    {
        $event = $this->createEvent();
        $member = $this->createMember('duplikat@example.com');

        $event->members()->attach($member->id);

        $response = $this->from(route('events.show', $event))
            ->post(route('events.members.store', $event), [
                'member_id' => $member->id,
            ]);

        $response->assertRedirect(route('events.show', $event));
        $response->assertSessionHasErrors(['member_id']);
        $this->assertSame(1, $event->members()->where('members.id', $member->id)->count());
    }

    public function test_member_can_be_removed_from_event(): void
    {
        $event = $this->createEvent();
        $member = $this->createMember('usuniety@example.com');

        $event->members()->attach($member->id);

        $response = $this->delete(route('events.members.destroy', [$event, $member]));

        $response->assertRedirect(route('events.show', $event));
        $this->assertDatabaseMissing('event_member', [
            'event_id' => $event->id,
            'member_id' => $member->id,
        ]);
    }

    public function test_fee_can_be_created(): void
    {
        $member = $this->createMember('skladka@example.com');

        $response = $this->post(route('fees.store'), [
            'member_id' => $member->id,
            'year' => 2026,
            'amount' => 120.00,
            'status' => 'unpaid',
            'paid_at' => null,
        ]);

        $fee = Fee::where('member_id', $member->id)->where('year', 2026)->first();

        $this->assertNotNull($fee);
        $response->assertRedirect(route('fees.show', $fee));
        $this->assertDatabaseHas('fees', [
            'member_id' => $member->id,
            'year' => 2026,
            'amount' => 120.00,
            'status' => 'unpaid',
        ]);
    }

    public function test_negative_fee_amount_is_rejected(): void
    {
        $member = $this->createMember('ujemna@example.com');

        $response = $this->post(route('fees.store'), [
            'member_id' => $member->id,
            'year' => 2026,
            'amount' => -10,
            'status' => 'unpaid',
        ]);

        $response->assertSessionHasErrors(['amount']);
        $this->assertDatabaseMissing('fees', [
            'member_id' => $member->id,
            'amount' => -10,
        ]);
    }

    public function test_fee_can_be_marked_as_paid(): void
    {
        $fee = $this->createFee();

        $response = $this->patch(route('fees.mark-paid', $fee));

        $response->assertRedirect(route('fees.index'));
        $this->assertDatabaseHas('fees', [
            'id' => $fee->id,
            'status' => 'paid',
        ]);

        $this->assertNotNull($fee->fresh()->paid_at);
    }

    public function test_fee_can_be_cancelled(): void
    {
        $fee = $this->createFee();

        $response = $this->delete(route('fees.destroy', $fee));

        $response->assertRedirect(route('fees.index'));
        $this->assertDatabaseHas('fees', [
            'id' => $fee->id,
            'status' => 'cancelled',
        ]);
    }

    private function createMember(
        string $email = 'jan.kowalski@example.com',
        string $firstName = 'Jan',
        string $lastName = 'Kowalski'
    ): Member {
        return Member::create([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $email,
            'phone' => '500100200',
            'joined_at' => '2026-01-01',
            'status' => 'active',
        ]);
    }

    private function createWeaponType(string $name = 'Pistolet'): WeaponType
    {
        return WeaponType::create([
            'name' => $name,
            'description' => 'Typ broni do testow.',
        ]);
    }

    private function createWeapon(string $serialNumber = 'SERIAL-1'): Weapon
    {
        return Weapon::create([
            'weapon_type_id' => $this->createWeaponType()->id,
            'name' => 'Bron testowa',
            'caliber' => '9x19 mm',
            'serial_number' => $serialNumber,
            'status' => 'available',
        ]);
    }

    private function createEvent(): Event
    {
        return Event::create([
            'name' => 'Wydarzenie testowe',
            'event_date' => '2026-03-20',
            'location' => 'Strzelnica testowa',
            'description' => 'Wydarzenie do testow.',
            'status' => 'planned',
        ]);
    }

    private function createFee(): Fee
    {
        return Fee::create([
            'member_id' => $this->createMember('oplaty@example.com')->id,
            'year' => 2026,
            'amount' => 120.00,
            'status' => 'unpaid',
            'paid_at' => null,
        ]);
    }
}
