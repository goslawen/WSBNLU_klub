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
            'status' => 'paid',
            'paid_at' => '2026-02-15',
        ]);

        $response = $this->get(route('fees.index'));

        $response->assertOk();
        $response->assertSee('240,00');
        $response->assertSee('Kowalski');
        $response->assertSee('15.02.2026');
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

    public function test_fee_generation_form_works(): void
    {
        $response = $this->get(route('fees.generate-form'));

        $response->assertOk();
        $response->assertSee('Wygeneruj składki roczne');
    }

    public function test_yearly_fees_can_be_generated_for_active_members(): void
    {
        $firstMember = $this->createMember('jan.generate@example.com');
        $secondMember = $this->createMember('anna.generate@example.com', 'Anna', 'Nowak');

        $response = $this->post(route('fees.generate'), [
            'year' => 2027,
            'amount' => 240,
        ]);

        $response->assertRedirect(route('fees.index'));
        $response->assertSessionHas('success', 'Wygenerowano składki: 2. Pominięto istniejące: 0.');
        $this->assertDatabaseHas('fees', [
            'member_id' => $firstMember->id,
            'year' => 2027,
            'amount' => 240,
            'status' => 'unpaid',
            'paid_at' => null,
        ]);
        $this->assertDatabaseHas('fees', [
            'member_id' => $secondMember->id,
            'year' => 2027,
            'amount' => 240,
            'status' => 'unpaid',
            'paid_at' => null,
        ]);
    }

    public function test_yearly_fees_are_not_generated_for_inactive_members(): void
    {
        $activeMember = $this->createMember('aktywny.generate@example.com');
        $inactiveMember = $this->createMember('nieaktywny.generate@example.com', 'Tomasz', 'Wójcik', 'inactive');

        $this->post(route('fees.generate'), [
            'year' => 2027,
            'amount' => 240,
        ]);

        $this->assertDatabaseHas('fees', [
            'member_id' => $activeMember->id,
            'year' => 2027,
        ]);
        $this->assertDatabaseMissing('fees', [
            'member_id' => $inactiveMember->id,
            'year' => 2027,
        ]);
    }

    public function test_yearly_fee_generation_does_not_create_duplicates(): void
    {
        $member = $this->createMember('duplikat.generate@example.com');
        Fee::create([
            'member_id' => $member->id,
            'year' => 2027,
            'amount' => 200,
            'status' => 'unpaid',
        ]);

        $response = $this->post(route('fees.generate'), [
            'year' => 2027,
            'amount' => 240,
        ]);

        $response->assertRedirect(route('fees.index'));
        $response->assertSessionHas('success', 'Wygenerowano składki: 0. Pominięto istniejące: 1.');
        $this->assertSame(1, Fee::where('member_id', $member->id)->where('year', 2027)->count());
    }

    public function test_negative_amount_is_rejected_for_yearly_fee_generation(): void
    {
        $response = $this->post(route('fees.generate'), [
            'year' => 2027,
            'amount' => -1,
        ]);

        $response->assertSessionHasErrors(['amount']);
    }

    public function test_year_before_2000_is_rejected_for_yearly_fee_generation(): void
    {
        $response = $this->post(route('fees.generate'), [
            'year' => 1999,
            'amount' => 240,
        ]);

        $response->assertSessionHasErrors(['year']);
    }

    private function createMember(
        string $email = 'jan.fee@example.com',
        string $firstName = 'Jan',
        string $lastName = 'Kowalski',
        string $status = 'active'
    ): Member {
        return Member::create([
            'first_name' => $firstName,
            'last_name' => $lastName,
            'email' => $email,
            'joined_at' => '2026-01-01',
            'status' => $status,
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