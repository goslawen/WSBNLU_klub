<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\Fee;
use App\Models\Member;
use App\Models\Weapon;
use App\Models\WeaponType;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectRequirementsTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_works(): void
    {
        $response = $this->get(route('home'));

        $response->assertOk();
        $response->assertSee('WSBNLU Klub');
    }

    public function test_members_list_works(): void
    {
        $member = $this->createMember('Jan', 'Kowalski', 'jan.requirements@example.com');

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
            'email' => 'anna.requirements@example.com',
            'phone' => '500100200',
            'joined_at' => '2026-01-15',
            'status' => 'active',
        ]);

        $member = Member::where('email', 'anna.requirements@example.com')->first();

        $this->assertNotNull($member);
        $response->assertRedirect(route('members.show', $member));
        $this->assertDatabaseHas('members', [
            'email' => 'anna.requirements@example.com',
        ]);
    }

    public function test_member_required_fields_are_validated(): void
    {
        $response = $this->post(route('members.store'), [
            'joined_at' => '2026-01-15',
            'status' => 'active',
        ]);

        $response->assertSessionHasErrors(['first_name', 'last_name', 'email']);
    }

    public function test_members_search_works(): void
    {
        $this->createMember('Maria', 'Wisniewska', 'maria.requirements@example.com');
        $this->createMember('Piotr', 'Zielinski', 'piotr.requirements@example.com');

        $response = $this->get(route('members.index', ['search' => 'Maria']));

        $response->assertOk();
        $response->assertSee('Maria');
        $response->assertDontSee('Piotr');
    }

    public function test_weapon_type_can_be_created(): void
    {
        $response = $this->post(route('weapon-types.store'), [
            'name' => 'Karabin testowy',
            'description' => 'Typ broni do testu wymagan.',
        ]);

        $weaponType = WeaponType::where('name', 'Karabin testowy')->first();

        $this->assertNotNull($weaponType);
        $response->assertRedirect(route('weapon-types.show', $weaponType));
    }

    public function test_weapon_can_be_created(): void
    {
        $weaponType = $this->createWeaponType();

        $response = $this->post(route('weapons.store'), [
            'weapon_type_id' => $weaponType->id,
            'name' => 'CZ 457 Test',
            'caliber' => '.22 LR',
            'serial_number' => 'REQ-W-001',
            'status' => 'available',
        ]);

        $weapon = Weapon::where('serial_number', 'REQ-W-001')->first();

        $this->assertNotNull($weapon);
        $response->assertRedirect(route('weapons.show', $weapon));
    }

    public function test_event_can_be_created(): void
    {
        $response = $this->post(route('events.store'), [
            'name' => 'Trening testowy',
            'event_date' => '2026-06-10',
            'location' => 'Strzelnica testowa',
            'description' => 'Wydarzenie do testu wymagan.',
            'status' => 'planned',
        ]);

        $event = Event::where('name', 'Trening testowy')->first();

        $this->assertNotNull($event);
        $response->assertRedirect(route('events.show', $event));
    }

    public function test_member_can_be_assigned_to_event(): void
    {
        $event = $this->createEvent();
        $member = $this->createMember();

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
        $member = $this->createMember();
        $event->members()->attach($member->id);

        $response = $this->from(route('events.show', $event))
            ->post(route('events.members.store', $event), [
                'member_id' => $member->id,
            ]);

        $response->assertRedirect(route('events.show', $event));
        $response->assertSessionHasErrors(['member_id']);
        $this->assertSame(1, $event->members()->where('members.id', $member->id)->count());
    }

    public function test_fee_can_be_created(): void
    {
        $member = $this->createMember();

        $response = $this->post(route('fees.store'), [
            'member_id' => $member->id,
            'year' => 2026,
            'amount' => 240.00,
            'status' => 'unpaid',
        ]);

        $fee = Fee::where('member_id', $member->id)->where('year', 2026)->first();

        $this->assertNotNull($fee);
        $response->assertRedirect(route('fees.show', $fee));
    }

    public function test_fee_with_negative_amount_is_rejected(): void
    {
        $member = $this->createMember();

        $response = $this->post(route('fees.store'), [
            'member_id' => $member->id,
            'year' => 2026,
            'amount' => -10,
            'status' => 'unpaid',
        ]);

        $response->assertSessionHasErrors(['amount']);
    }

    public function test_fee_can_be_marked_as_paid(): void
    {
        $fee = $this->createFee();

        $response = $this->patch(route('fees.mark-paid', $fee));

        $response->assertRedirect(route('fees.index'));
        $fee->refresh();
        $this->assertSame('paid', $fee->status);
        $this->assertNotNull($fee->paid_at);
    }

    private function createMember(
        string $firstName = 'Jan',
        string $lastName = 'Kowalski',
        string $email = 'jan.default@example.com'
    ): Member {
        return Member::create([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $email,
            'joined_at' => '2026-01-01',
            'status' => 'active',
        ]);
    }

    private function createWeaponType(): WeaponType
    {
        return WeaponType::create([
            'name' => 'Pistolet testowy',
            'description' => 'Typ broni do testu.',
        ]);
    }

    private function createEvent(): Event
    {
        return Event::create([
            'name' => 'Wydarzenie testowe',
            'event_date' => '2026-06-10',
            'location' => 'Strzelnica testowa',
            'status' => 'planned',
        ]);
    }

    private function createFee(): Fee
    {
        return Fee::create([
            'member_id' => $this->createMember()->id,
            'year' => 2026,
            'amount' => 240.00,
            'status' => 'unpaid',
        ]);
    }
}