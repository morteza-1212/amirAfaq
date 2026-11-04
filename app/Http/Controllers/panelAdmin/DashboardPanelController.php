<?php

namespace App\Http\Controllers\panelAdmin;

use App\Http\Controllers\Controller;
use App\Models\Cart\Order;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;

class DashboardPanelController extends Controller
{
    public function index()
    {
        $stats = [
            'orders_total'     => Order::count(),
            'orders_pending'   => Order::pending()->count(),
            'orders_paid'      => Order::paid()->count(),
            'orders_processing'=> Order::status('processing')->count(),
            'orders_shipped'   => Order::shipped()->count(),
            'orders_delivered' => Order::delivered()->count(),
            'orders_cancelled' => Order::cancelled()->count(),
            'revenue_total'    => Order::paid()->sum('total_amount'),
            'revenue_today'    => Order::paid()->whereDate('created_at', today())->sum('total_amount'),
            'payments_total'   => Payment::count(),
            'payments_success' => Payment::success()->count(),
            'payments_failed'  => Payment::failed()->count(),
            'payments_refunded'=> Payment::refunded()->count(),
        ];

        $recentOrders = Order::with('successfulPayment')
            ->latest()
            ->limit(10)
            ->get();

        $recentPayments = Payment::with('order')
            ->latest()
            ->limit(10)
            ->get();

        $chart = Order::paid()
            ->where('created_at', '>=', now()->subDays(7))
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total_amount) as total'),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('panelAdmin.dashboard', compact(
            'stats', 'recentOrders', 'recentPayments', 'chart'
        ));
    }
}
