<?php

namespace App\Http\Controllers\panelAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateOrderRequest;
use App\Http\Requests\Admin\UpdateOrderStatusRequest;
use App\Models\Cart\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OrderPanelController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | لیست سفارش‌ها
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        $orders = Order::query()
            ->with(['items', 'successfulPayment', 'user'])
            ->search($request->input('search'))
            ->status($request->input('status'))
            ->betweenDates($request->input('from'), $request->input('to'))
            ->when($request->filled('payment_method'), fn ($q) =>
            $q->where('payment_method', $request->input('payment_method'))
            )
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('panelAdmin.orders.index', compact('orders'));
    }

    /*
    |--------------------------------------------------------------------------
    | لیست سفارش‌های حذف‌شده
    |--------------------------------------------------------------------------
    */
    public function trashed(Request $request)
    {
        $orders = Order::onlyTrashed()
            ->with(['items', 'successfulPayment', 'user'])
            ->search($request->input('search'))
            ->latest('deleted_at')
            ->paginate(20)
            ->withQueryString();

        return view('panelAdmin.orders.trashed', compact('orders'));
    }

    /*
    |--------------------------------------------------------------------------
    | نمایش جزئیات سفارش
    |--------------------------------------------------------------------------
    */
    public function show(Order $order)
    {
        $order->load(['items', 'payments', 'user', 'updatedBy', 'cart']);

        return view('panelAdmin.orders.show', compact('order'));
    }

    /*
    |--------------------------------------------------------------------------
    | فرم ویرایش
    |--------------------------------------------------------------------------
    */
    public function edit(Order $order)
    {
        $order->load('items');

        return view('panelAdmin.orders.edit', compact('order'));
    }

    /*
    |--------------------------------------------------------------------------
    | به‌روزرسانی
    |--------------------------------------------------------------------------
    */
    public function update(UpdateOrderRequest $request, Order $order)
    {
        $order->update($request->validated());

        Log::info('Admin updated order', [
            'order_id' => $order->id,
            'admin_id' => $request->user()->id,
        ]);

        return redirect()
            ->route('admin.orders.show', $order)
            ->with('success', 'سفارش با موفقیت به‌روزرسانی شد.');
    }

    /*
    |--------------------------------------------------------------------------
    | تغییر وضعیت
    |--------------------------------------------------------------------------
    */
    public function updateStatus(UpdateOrderStatusRequest $request, Order $order)
    {
        $validated = $request->validated();

        $order->changeStatus(
            $validated['status'],
            $request->user()->id,
            $validated['note'] ?? null
        );

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'وضعیت سفارش به‌روزرسانی شد.',
                'status'  => $order->status,
                'history' => $order->status_history,
            ]);
        }

        return back()->with('success', 'وضعیت سفارش به‌روزرسانی شد.');
    }

    /*
    |--------------------------------------------------------------------------
    | حذف (Soft Delete)
    |--------------------------------------------------------------------------
    */
    public function destroy(Order $order)
    {
        // چک دستی: سفارش با پرداخت موفق قابل حذف نیست
        if ($order->successfulPayment()->exists()) {
            return back()->with('error', 'سفارش دارای پرداخت موفق قابل حذف نیست.');
        }

        $order->delete();

        return redirect()
            ->route('admin.orders.index')
            ->with('success', 'سفارش به سبد حذف‌شده‌ها منتقل شد.');
    }

    /*
    |--------------------------------------------------------------------------
    | بازگردانی
    |--------------------------------------------------------------------------
    */
    public function restore(int $id)
    {
        $order = Order::onlyTrashed()->findOrFail($id);

        $order->restore();

        return back()->with('success', 'سفارش بازگردانی شد.');
    }

    /*
    |--------------------------------------------------------------------------
    | حذف دائمی
    |--------------------------------------------------------------------------
    */
    public function forceDelete(int $id)
    {
        $order = Order::onlyTrashed()->findOrFail($id);

        if ($order->successfulPayment()->exists()) {
            return back()->with('error', 'سفارش دارای پرداخت موفق قابل حذف دائمی نیست.');
        }

        Log::warning('Admin permanently deleted order', [
            'order_id' => $order->id,
            'admin_id' => auth()->id(),
        ]);

        $order->forceDelete();

        return redirect()
            ->route('admin.orders.trashed')
            ->with('success', 'سفارش برای همیشه حذف شد.');
    }

    /*
    |--------------------------------------------------------------------------
    | خروجی CSV
    |--------------------------------------------------------------------------
    */
    public function export(Request $request)
    {
        $orders = Order::with('items')
            ->search($request->input('search'))
            ->status($request->input('status'))
            ->latest()
            ->get();

        $filename = 'orders-' . now()->format('Ymd-His') . '.csv';

        return response()->streamDownload(function () use ($orders) {
            $out = fopen('php://output', 'w');

            // BOM برای Excel فارسی
            fwrite($out, "\xEF\xBB\xBF");

            fputcsv($out, [
                'شماره سفارش', 'کد رهگیری', 'نام مشتری', 'موبایل',
                'وضعیت', 'روش پرداخت', 'مبلغ کل', 'تاریخ',
            ]);

            foreach ($orders as $o) {
                fputcsv($out, [
                    $o->order_number,
                    $o->tracking_code,
                    $o->customer_name,
                    $o->customer_phone,
                    $o->status,
                    $o->payment_method,
                    $o->total_amount,
                    $o->created_at->format('Y-m-d H:i'),
                ]);
            }

            fclose($out);
        }, $filename);
    }
}
