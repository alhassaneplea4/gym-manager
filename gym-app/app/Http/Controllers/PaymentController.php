<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePaymentRequest;
use App\Http\Requests\UpdatePaymentRequest;
use App\Models\Member;
use App\Models\Payment;
use App\Models\Subscription;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Payment::class, 'payment');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $month = request('month');

        $payments = Payment::with(['member', 'subscription'])
            ->when($month, fn ($query) => $query->whereMonth('paid_at', (int) $month))
            ->latest('paid_at')
            ->paginate(12)
            ->appends(request()->query());

        return view('payments.index', compact('payments', 'month'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $members = Member::orderBy('last_name')->get();
        $subscriptions = Subscription::where('status', 'active')->orderByDesc('end_date')->get();

        return view('payments.create', compact('members', 'subscriptions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePaymentRequest $request): RedirectResponse
    {
        Payment::create($request->validated() + ['received_by' => $request->user()->id]);

        return redirect()->route('payments.index')->with('status', 'Paiement enregistré.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment): View
    {
        $payment->load(['member', 'subscription', 'receiver']);

        return view('payments.show', compact('payment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment): View
    {
        $members = Member::orderBy('last_name')->get();
        $subscriptions = Subscription::orderByDesc('end_date')->get();

        return view('payments.edit', compact('payment', 'members', 'subscriptions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePaymentRequest $request, Payment $payment): RedirectResponse
    {
        $payment->update($request->validated());

        return redirect()->route('payments.index')->with('status', 'Paiement mis à jour.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment): RedirectResponse
    {
        $payment->delete();

        return redirect()->route('payments.index')->with('status', 'Paiement supprimé.');
    }
}
