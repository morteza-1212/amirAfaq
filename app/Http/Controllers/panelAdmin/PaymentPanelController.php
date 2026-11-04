<?php

namespace App\Http\Controllers\panelAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RefundPaymentRequest;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentPanelController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | لیست پرداخت‌ها
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        $payments = Payment::query()
            ->with(['order', 'verifiedBy', 'refundedBy'])
            ->search($request->input('search'))
            ->when($request->filled('status'), fn ($q) =>
            $q->where('status', $request->input('status'))
            )
            ->when($request->filled('gateway'), fn ($q) =>
            $q->where('gateway', $request->input('gateway'))
            )
            ->when($request->filled('from'), fn ($q) =>
            $q->whereDate('created_at', '>=', $request->input('from'))
            )
            ->when($request->filled('to'), fn ($q) =>
            $q->whereDate('created_at', '<=', $request->input('to'))
            )
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('panelAdmin.payments.index', compact('payments'));
    }

    /*
    |--------------------------------------------------------------------------
    | نمایش جزئیات پرداخت
    |--------------------------------------------------------------------------
    */
    public function show(Payment $payment)
    {
        $payment->load(['order.items', 'verifiedBy', 'refundedBy']);

        return view('panelAdmin.payments.show', compact('payment'));
    }

    /*
    |--------------------------------------------------------------------------
    | تایید دستی پرداخت
    |--------------------------------------------------------------------------
    */
    public function verify(Request $request, Payment $payment)
    {
        if ($payment->status !== 'pending') {
            return back()->with('error', 'فقط پرداخت‌های در انتظار قابل تایید هستند.');
        }

        $payment->update([
            'status'      => 'success',
            'paid_at'     => now(),
            'verified_by' => $request->user()->id,
            'metadata'    => array_merge($payment->metadata ?? [], [
                'verified_manually_at' => now()->toIso8601String(),
                'verified_by'          => $request->user()->id,
            ]),
        ]);

        $payment->order->changeStatus(
            'paid',
            $request->user()->id,
            'تایید دستی پرداخت توسط ادمین'
        );

        Log::info('Payment verified manually', [
            'payment_id' => $payment->id,
            'admin_id'   => $request->user()->id,
        ]);

        return back()->with('success', 'پرداخت با موفقیت تایید شد.');
    }

    /*
    |--------------------------------------------------------------------------
    | بازگشت وجه
    |--------------------------------------------------------------------------
    */
    public function refund(RefundPaymentRequest $request, Payment $payment)
    {
        if (! $payment->isRefundable()) {
            return back()->with('error', 'این پرداخت قابل بازگشت نیست.');
        }

        try {
            $payment->refund(
                $request->user()->id,
                $request->input('note')
            );

            Log::info('Payment refunded', [
                'payment_id' => $payment->id,
                'admin_id'   => $request->user()->id,
            ]);

            return back()->with('success', 'بازگشت وجه ثبت شد.');

        } catch (\RuntimeException $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /*
    |--------------------------------------------------------------------------
    | حذف پرداخت
    |--------------------------------------------------------------------------
    */
    public function destroy(Payment $payment)
    {
        if ($payment->isSuccessful()) {
            return back()->with('error', 'پرداخت موفق قابل حذف نیست.');
        }

        $payment->delete();

        return redirect()
            ->route('admin.payments.index')
            ->with('success', 'پرداخت حذف شد.');
    }
}
