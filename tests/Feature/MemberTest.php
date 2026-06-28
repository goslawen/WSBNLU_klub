<?php

namespace Tests\Feature;

use App\Models\Member;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MemberTest extends TestCase
{
    use RefreshDatabase;

    public function test_members_list_works(): void
    {
        Member::create([
            'first_name' => 'Jan',
            'last_name' => 'Kowalski',
            'email' => 'jan.test@example.com',
            'joined_at' => '2026-01-01',
            'status' => 'active',
        ]);

        $response = $this->get(route('members.index'));

        $response->assertOk();
        $response->assertSee('Jan');
        $response->assertSee('Kowalski');
    }

    public function test_member_can_be_created(): void
    {
        $response = $this->post(route('members.store'), [
            'first_name' => 'Anna',
            'last_name' => 'Nowak',
            'email' => 'anna.nowak@example.com',
            'phone' => '500100200',
            'joined_at' => '2026-02-10',
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
            'joined_at' => '2026-02-10',
            'status' => 'active',
        ]);

        $response->assertSessionHasErrors(['first_name', 'last_name', 'email']);
    }

    public function test_members_search_works(): void
    {
        Member::create([
            'first_name' => 'Maria',
            'last_name' => 'Wiśniewska',
            'email' => 'maria@example.com',
            'joined_at' => '2026-01-01',
            'status' => 'active',
        ]);

        Member::create([
            'first_name' => 'Piotr',
            'last_name' => 'Zieliński',
            'email' => 'piotr@example.com',
            'joined_at' => '2026-01-01',
            'status' => 'active',
        ]);

        $response = $this->get(route('members.index', ['search' => 'Maria']));

        $response->assertOk();
        $response->assertSee('Maria');
        $response->assertDontSee('Piotr');
    }

    public function test_member_can_be_deactivated(): void
    {
        $member = Member::create([
            'first_name' => 'Tomasz',
            'last_name' => 'Wójcik',
            'email' => 'tomasz@example.com',
            'joined_at' => '2026-01-01',
            'status' => 'active',
        ]);

        $response = $this->patch(route('members.deactivate', $member));

        $response->assertRedirect(route('members.index'));
        $this->assertDatabaseHas('members', [
            'id' => $member->id,
            'status' => 'inactive',
        ]);
    }
}