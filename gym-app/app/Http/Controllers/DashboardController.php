<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Payment;
use App\Models\Subscription;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        $today = Carbon::today();

        $totalMembers = Member::count();
        $activeMembers = Member::where('status', 'active')->count();
        $monthlyRevenue = Payment::where('status', 'completed')
            ->whereBetween('paid_at', [now()->startOfMonth(), now()->endOfMonth()])
            ->sum('amount');

        $expiringSoon = Subscription::with('member')
            ->where('status', 'active')
            ->whereBetween('end_date', [$today, $today->copy()->addDays(7)])
            ->orderBy('end_date')
            ->take(5)
            ->get();

        $revenueSeries = Payment::query()
            ->selectRaw("DATE_FORMAT(paid_at, '%Y-%m') as month_key, SUM(amount) as total")
            ->where('status', 'completed')
            ->whereBetween('paid_at', [now()->subMonths(5)->startOfMonth(), now()->endOfMonth()])
            ->groupBy('month_key')
            ->orderBy('month_key')
            ->get();

        $chartLabels = $revenueSeries
            ->pluck('month_key')
            ->map(fn (string $month) => Carbon::createFromFormat('Y-m', $month)->translatedFormat('M Y'))
            ->values();
        $chartData = $revenueSeries->pluck('total')->map(fn ($value) => (float) $value)->values();

        return view('dashboard', compact(
            'totalMembers',
            'activeMembers',
            'monthlyRevenue',
            'expiringSoon',
            'chartLabels',
            'chartData'
        ));
    }
}
