<?php

namespace Tests\Feature;

use App\Models\Fee;
use App\Models\Member;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FeeTest extends TestCase
{
    use RefreshDatabase;

    public function test_fees_list_works(): void
    {
        $member = $this->createMember();
        Fee::create([
            'member_id' => $member->id,
            'year' => 2026,
            'amount' => 240.00,
            'status' => 'unpaid',
        ]);

        $response = $this->get(route('fees.index'));

        $response->assertOk();
        $response->assertSee('240,00');
        $response->assertSee('Kowalski');
    }

    public function test_fee_can_be_created(): void
    {
        $member = $this->createMember();

        $response = $this->post(route('fees.store'), [
            'member_id' => $member->id,
            'year' => 2026,
            'amount' => 240.00,
            'status' => 'unpaid',
            'paid_at' => null,
        ]);

        $fee = Fee::where('member_id', $member->id)->where('year', 2026)->first();

        $this->assertNotNull($fee);
        $response->assertRedirect(route('fees.show', $fee));
        $this->assertDatabaseHas('fees', [
            'member_id' => $member->id,
            'year' => 2026,
            'status' => 'unpaid',
        ]);
    }

    public function test_member_is_required_for_fee(): void
    {
        $response = $this->post(route('fees.store'), [
            'year' => 2026,
            'amount' => 240.00,
            'status' => 'unpaid',
        ]);

        $response->assertSessionHasErrors(['member_id']);
    }

    public function test_negative_amount_is_rejected(): void
    {
        $member = $this->createMember();

        $response = $this->post(route('fees.store'), [
            'member_id' => $member->id,
            'year' => 2026,
            'amount' => -1,
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

    private function createMember(): Member
    {
        return Member::create([
            'first_name' => 'Jan',
            'last_name' => 'Kowalski',
            'email' => 'jan.fee@example.com',
            'joined_at' => '2026-01-01',
            'status' => 'active',
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