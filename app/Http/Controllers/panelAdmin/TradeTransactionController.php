<?php

namespace App\Http\Controllers\panelAdmin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTradeTransactionRequest;
use App\Http\Requests\UpdateTradeTransactionRequest;
use App\Models\TradeTransaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use App\Helpers\JalaliHelper;


class TradeTransactionController extends Controller
{
    /* ============================================================
     |  Index
     ============================================================ */
    public function index(Request $request): View
    {
        $transactions = TradeTransaction::query()
            ->with('translations')
            ->when($request->filled('search'),
                fn ($q) => $q->search($request->string('search')))
            ->when($request->filled('type'),
                fn ($q) => $q->ofType($request->string('type')))
            ->when($request->filled('status'), function ($q) use ($request) {
                $q->where('is_published', $request->string('status') === 'published');
            })
            ->ordered()
            ->paginate(15)
            ->withQueryString();

        return view('panelAdmin.trade.index', compact('transactions'));
    }

    /* ============================================================
     |  Create
     ============================================================ */
    public function create(): View
    {
        return view('panelAdmin.trade.create');
    }

    /* ============================================================
     |  Store
     ============================================================ */
    public function store(StoreTradeTransactionRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $transaction = null;

        DB::transaction(function () use ($request, &$data, &$transaction) {
            if ($request->hasFile('image')) {
                $data['image'] = $request->file('image')->store('trade-transactions', 'public');
            }

            $translations = $data['translations'] ?? [];
            unset($data['translations']);

            // transaction_code در Model به‌صورت خودکار ساخته می‌شود
            $transaction = TradeTransaction::create($data);

            $this->saveTranslations($transaction, $translations);
        });

        return redirect()
            ->route('admin.trade-transaction.index')
            ->with('success', 'پروژه با موفقیت ایجاد شد. کد: ' . $transaction->transaction_code);
    }

    /* ============================================================
     |  Show
     ============================================================ */
    public function show(TradeTransaction $tradeTransaction): View
    {
        $tradeTransaction->load('translations');

        return view('panelAdmin.trade-transactions.show', compact('tradeTransaction'));
    }

    /* ============================================================
     |  Edit
     ============================================================ */
    public function edit(TradeTransaction $tradeTransaction): View
    {
        $tradeTransaction->load('translations');

        return view('panelAdmin.trade.edit', compact('tradeTransaction'));
    }

    /* ============================================================
     |  Update
     ============================================================ */
    public function update(UpdateTradeTransactionRequest $request, TradeTransaction $tradeTransaction): RedirectResponse
    {
        $data = $request->validated();

        DB::transaction(function () use ($request, $tradeTransaction, &$data) {
            // تصویر
            if ($request->hasFile('image')) {
                if ($tradeTransaction->image && Storage::disk('public')->exists($tradeTransaction->image)) {
                    Storage::disk('public')->delete($tradeTransaction->image);
                }
                $data['image'] = $request->file('image')->store('trade-transactions', 'public');
            } else {
                unset($data['image']);
            }

            // code و transaction_code هرگز نباید از ورودی کاربر تغییر کنند
            unset($data['transaction_code']);

            $translations = $data['translations'] ?? [];
            unset($data['translations']);

            $tradeTransaction->update($data);

            $this->saveTranslations($tradeTransaction, $translations);
        });

        return redirect()
            ->route('admin.trade-transaction.index')
            ->with('success', 'پروژه با موفقیت به‌روزرسانی شد.');
    }

    /* ============================================================
     |  Destroy
     ============================================================ */
    public function destroy(TradeTransaction $tradeTransaction): RedirectResponse
    {
        DB::transaction(function () use ($tradeTransaction) {
            if ($tradeTransaction->image && Storage::disk('public')->exists($tradeTransaction->image)) {
                Storage::disk('public')->delete($tradeTransaction->image);
            }

            $tradeTransaction->delete();
        });

        return redirect()
            ->route('admin.trade-transaction.index')
            ->with('success', 'پروژه با موفقیت حذف شد.');
    }

    /* ============================================================
     |  Helper
     ============================================================ */
    protected function saveTranslations(TradeTransaction $transaction, array $translations): void
    {
        foreach ($translations as $locale => $values) {
            if (empty($values['title'])) {
                continue;
            }

            $transaction->translations()->updateOrCreate(
                ['locale' => $locale],
                [
                    'title'               => $values['title'],
                    'product'             => $values['product'] ?? null,
                    'origin_country'      => $values['origin_country'] ?? null,
                    'destination_country' => $values['destination_country'] ?? null,
                    'packaging'           => $values['packaging'] ?? null,
                    'alt_text'            => $values['alt_text'] ?? null,
                    'description'         => $values['description'] ?? null,
                ]
            );
        }
    }

    protected function convertDates(array &$data): void
    {
        if (! empty($data['contract_date'])) {
            $data['contract_date'] = JalaliHelper::toGregorian($data['contract_date']);
        }

        if (! empty($data['delivery_date'])) {
            $data['delivery_date'] = JalaliHelper::toGregorian($data['delivery_date']);
        }
    }
}
