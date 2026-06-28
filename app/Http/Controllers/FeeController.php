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
        $data = $request->validate($this->rules());

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

    private function rules(): array
    {
        return [
            'member_id' => ['required', Rule::exists('members', 'id')],
            'year' => ['required', 'integer'],
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