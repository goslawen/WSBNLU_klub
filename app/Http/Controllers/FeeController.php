<?php

namespace App\Http\Controllers;

use App\Models\Fee;
use App\Models\Member;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class FeeController extends Controller
{
    public function index(): View
    {
        $fees = Fee::query()
            ->with('member')
            ->orderByDesc('year')
            ->orderBy('status')
            ->get();

        return view('fees.index', [
            'fees' => $fees,
        ]);
    }

    public function create(): View
    {
        return view('fees.create', [
            'members' => $this->membersForSelect(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate($this->rules());

        $fee = Fee::create($data);

        return redirect()
            ->route('fees.show', $fee)
            ->with('success', 'Składka została dodana.');
    }

    public function show(Fee $fee): View
    {
        $fee->load('member');

        return view('fees.show', [
            'fee' => $fee,
        ]);
    }

    public function edit(Fee $fee): View
    {
        return view('fees.edit', [
            'fee' => $fee,
            'members' => $this->membersForSelect(),
        ]);
    }

    public function update(Request $request, Fee $fee): RedirectResponse
    {
        $data = $request->validate($this->rules($fee));

        $fee->update($data);

        return redirect()
            ->route('fees.show', $fee)
            ->with('success', 'Składka została zaktualizowana.');
    }

    public function destroy(Fee $fee): RedirectResponse
    {
        $fee->update(['status' => 'cancelled']);

        return redirect()
            ->route('fees.index')
            ->with('success', 'Składka została anulowana.');
    }

    public function markPaid(Fee $fee): RedirectResponse
    {
        $fee->update([
            'status' => 'paid',
            'paid_at' => now(),
        ]);

        return redirect()
            ->route('fees.index')
            ->with('success', 'Składka została oznaczona jako opłacona.');
    }

    public function generateForm(): View
    {
        return view('fees.generate');
    }

    public function generate(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'year' => ['required', 'integer', 'min:2000', 'max:2100'],
            'amount' => ['required', 'numeric', 'min:0'],
        ]);

        $created = 0;
        $skipped = 0;

        $members = Member::query()
            ->where('status', 'active')
            ->get();

        foreach ($members as $member) {
            $exists = Fee::query()
                ->where('member_id', $member->id)
                ->where('year', $data['year'])
                ->exists();

            if ($exists) {
                $skipped++;
                continue;
            }

            Fee::create([
                'member_id' => $member->id,
                'year' => $data['year'],
                'amount' => $data['amount'],
                'status' => 'unpaid',
                'paid_at' => null,
            ]);

            $created++;
        }

        return redirect()
            ->route('fees.index')
            ->with('success', "Wygenerowano składki: {$created}. Pominięto istniejące: {$skipped}.");
    }

    private function rules(?Fee $fee = null): array
    {
        return [
            'member_id' => ['required', Rule::exists('members', 'id')],
            'year' => [
                'required',
                'integer',
                Rule::unique('fees')
                    ->where('member_id', request('member_id'))
                    ->ignore($fee?->id),
            ],
            'amount' => ['required', 'numeric', 'min:0'],
            'status' => ['required', Rule::in(['unpaid', 'paid', 'cancelled'])],
            'paid_at' => ['nullable', 'date'],
        ];
    }

    private function membersForSelect()
    {
        return Member::query()
            ->orderBy('last_name')
            ->orderBy('first_name')
            ->get();
    }
}