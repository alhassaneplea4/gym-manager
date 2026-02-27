<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSubscriptionRequest;
use App\Http\Requests\UpdateSubscriptionRequest;
use App\Models\Member;
use App\Models\Subscription;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class SubscriptionController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Subscription::class, 'subscription');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $subscriptions = Subscription::with('member')
            ->latest()
            ->paginate(12);

        return view('subscriptions.index', compact('subscriptions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $members = Member::orderBy('last_name')->get();

        return view('subscriptions.create', compact('members'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSubscriptionRequest $request): RedirectResponse
    {
        Subscription::create($request->validated() + ['created_by' => $request->user()->id]);

        return redirect()->route('subscriptions.index')->with('status', 'Abonnement créé.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Subscription $subscription): View
    {
        $subscription->load('member', 'payments');

        return view('subscriptions.show', compact('subscription'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subscription $subscription): View
    {
        $members = Member::orderBy('last_name')->get();

        return view('subscriptions.edit', compact('subscription', 'members'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSubscriptionRequest $request, Subscription $subscription): RedirectResponse
    {
        $subscription->update($request->validated());

        return redirect()->route('subscriptions.index')->with('status', 'Abonnement mis à jour.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subscription $subscription): RedirectResponse
    {
        $subscription->delete();

        return redirect()->route('subscriptions.index')->with('status', 'Abonnement supprimé.');
    }
}
