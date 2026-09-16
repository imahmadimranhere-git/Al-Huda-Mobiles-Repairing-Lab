<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Repair;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    // Build all report data for a given date range, reused by both the
    // on-screen view and the PDF export so the two always match.
    private function buildReportData(Request $request): array
    {
        $from = $request->filled('from') ? $request->date('from')->startOfDay() : now()->subDays(30)->startOfDay();
        $to = $request->filled('to') ? $request->date('to')->endOfDay() : now()->endOfDay();

        // ---- Repairs ----
        $repairsQuery = Repair::whereBetween('created_at', [$from, $to]);

        $repairsByStatus = (clone $repairsQuery)
            ->selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $totalRepairs = (clone $repairsQuery)->count();
        $repairRevenue = (clone $repairsQuery)->whereNotNull('final_cost')->sum('final_cost');
        $completedRepairs = (clone $repairsQuery)->where('status', 'completed')->count();

        // ---- Orders / Shop ----
        $ordersQuery = Order::whereBetween('created_at', [$from, $to]);

        $ordersByStatus = (clone $ordersQuery)
            ->selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $totalOrders = (clone $ordersQuery)->count();
        $orderRevenue = (clone $ordersQuery)->where('status', 'completed')->sum('total');

        // ---- New customers in range ----
        $newCustomers = User::whereHas('role', fn ($q) => $q->where('slug', 'user'))
            ->whereBetween('created_at', [$from, $to])
            ->count();

        return [
            'from' => $from,
            'to' => $to,
            'totalRepairs' => $totalRepairs,
            'completedRepairs' => $completedRepairs,
            'repairRevenue' => $repairRevenue,
            'repairsByStatus' => $repairsByStatus,
            'totalOrders' => $totalOrders,
            'orderRevenue' => $orderRevenue,
            'ordersByStatus' => $ordersByStatus,
            'newCustomers' => $newCustomers,
            'totalRevenue' => $repairRevenue + $orderRevenue,
        ];
    }

    public function index(Request $request)
    {
        abort_unless(auth()->user()->isAdmin(), 403, 'Access denied.');

        $data = $this->buildReportData($request);

        return view('admin.reports.index', $data);
    }

    public function pdf(Request $request)
    {
        abort_unless(auth()->user()->isAdmin(), 403, 'Access denied.');

        $data = $this->buildReportData($request);

        $pdf = Pdf::loadView('admin.reports.pdf', $data);

        return $pdf->download('report-' . now()->format('Y-m-d') . '.pdf');
    }
}