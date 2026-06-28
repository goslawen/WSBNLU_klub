<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\Member;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventTest extends TestCase
{
    use RefreshDatabase;

    public function test_events_list_works(): void
    {
        Event::create([
            'name' => 'Trening klubowy',
            'event_date' => '2026-03-20',
            'location' => 'Strzelnica miejska',
            'status' => 'planned',
        ]);

        $response = $this->get(route('events.index'));

        $response->assertOk();
        $response->assertSee('Trening klubowy');
        $response->assertSee('20.03.2026');
    }

    public function test_event_can_be_created(): void
    {
        $response = $this->post(route('events.store'), [
            'name' => 'Zawody klubowe',
            'event_date' => '2026-05-15',
            'location' => 'Strzelnica 50 m',
            'description' => 'Proste zawody dla członków.',
            'status' => 'planned',
        ]);

        $event = Event::where('name', 'Zawody klubowe')->first();

        $this->assertNotNull($event);
        $response->assertRedirect(route('events.show', $event));
        $this->assertDatabaseHas('events', [
            'name' => 'Zawody klubowe',
            'status' => 'planned',
        ]);
    }

    public function test_event_name_is_required(): void
    {
        $response = $this->post(route('events.store'), [
            'event_date' => '2026-05-15',
            'location' => 'Strzelnica 50 m',
            'status' => 'planned',
        ]);

        $response->assertSessionHasErrors(['name']);
    }


    public function test_event_date_before_2000_is_rejected(): void
    {
        $response = $this->post(route('events.store'), [
            'name' => 'Stare wydarzenie',
            'event_date' => '1999-12-31',
            'location' => 'Strzelnica 50 m',
            'status' => 'planned',
        ]);

        $response->assertSessionHasErrors(['event_date']);
    }
    public function test_member_can_be_attached_to_event(): void
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

    public function test_same_member_cannot_be_attached_to_event_twice(): void
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

    public function test_member_can_be_removed_from_event(): void
    {
        $event = $this->createEvent();
        $member = $this->createMember();

        $event->members()->attach($member->id);

        $response = $this->delete(route('events.members.destroy', [$event, $member]));

        $response->assertRedirect(route('events.show', $event));
        $this->assertDatabaseMissing('event_member', [
            'event_id' => $event->id,
            'member_id' => $member->id,
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

    private function createEvent(): Event
    {
        return Event::create([
            'name' => 'Trening testowy',
            'event_date' => '2026-04-10',
            'location' => 'Strzelnica testowa',
            'status' => 'planned',
        ]);
    }

    private function createMember(): Member
    {
        return Member::create([
            'first_name' => 'Jan',
            'last_name' => 'Kowalski',
            'email' => 'jan.event@example.com',
            'joined_at' => '2026-01-01',
            'status' => 'active',
        ]);
    }
}