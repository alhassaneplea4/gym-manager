<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Collection;
use Illuminate\Support\Carbon;
use Illuminate\Http\Response;
use Illuminate\View\View;

class FinancialReportController extends Controller
{
    public function index(): View
    {
        $year = (int) request('year', now()->year);
        [$monthly, $totalRevenue] = $this->buildYearlyReport($year);

        return view('reports.financial', compact('monthly', 'totalRevenue', 'year'));
    }

    public function exportPdf(): Response
    {
        $year = (int) request('year', now()->year);
        [$monthly, $totalRevenue] = $this->buildYearlyReport($year);

        $pdf = Pdf::loadView('reports.financial-pdf', compact('monthly', 'totalRevenue', 'year'));

        return $pdf->download("rapport-financier-{$year}.pdf");
    }

    private function buildYearlyReport(int $year): array
    {
        $monthly = Payment::query()
            ->selectRaw('MONTH(paid_at) as month_number, SUM(amount) as revenue')
            ->where('status', 'completed')
            ->whereYear('paid_at', $year)
            ->groupBy('month_number')
            ->orderBy('month_number')
            ->get()
            ->map(function ($row) {
                $row->month_label = Carbon::create()->month((int) $row->month_number)->translatedFormat('F');

                return $row;
            });

        $totalRevenue = (float) $monthly->sum('revenue');

        return [$monthly, $totalRevenue];
    }
}
