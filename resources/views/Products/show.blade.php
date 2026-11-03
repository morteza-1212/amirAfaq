@extends('layouts.home')

@section('title', 'سبد خرید')

@section('content')
    <h1 class="text-2xl font-bold mb-6">سبد خرید</h1>

    <div x-data="cartPage()" x-init="load()">

        <div x-show="loading" class="text-center py-10 text-gray-500">در حال بارگذاری...</div>

        <div x-show="!loading && items.length === 0" class="bg-white rounded-xl p-10 text-center">
            <p class="text-gray-500 mb-4">سبد خرید شما خالی است.</p>
            <a href="{{ route('products.index') }}"
               class="inline-block bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                مشاهده محصولات
            </a>
        </div>

        <div x-show="!loading && items.length > 0" class="grid md:grid-cols-3 gap-6">
            <div class="md:col-span-2 space-y-3">
                <template x-for="item in items" :key="item.id">
                    <div class="bg-white rounded-xl p-4 flex items-center gap-4">
                        <div class="w-20 h-20 bg-gray-100 rounded-lg overflow-hidden shrink-0">
                            <img :src="item.image || 'https://placehold.co/100x100?text=No'" class="w-full h-full object-cover">
                        </div>
                        <div class="flex-1">
                            <a :href="'/products/' + item.slug" class="font-medium hover:text-blue-600" x-text="item.name"></a>
                            <p class="text-sm text-gray-500 mt-1" x-text="formatPrice(item.unit_price) + ' تومان'"></p>
                        </div>
                        <div class="flex items-center border rounded-lg">
                            <button @click="updateQty(item, item.quantity - 1)" class="px-2 py-1 hover:bg-gray-100">−</button>
                            <span x-text="item.quantity" class="w-8 text-center text-sm"></span>
                            <button @click="updateQty(item, item.quantity + 1)" class="px-2 py-1 hover:bg-gray-100">+</button>
                        </div>
                        <div class="text-left">
                            <p class="font-bold text-blue-600" x-text="formatPrice(item.total_price)"></p>
                            <button @click="removeItem(item)" class="text-red-500 text-xs mt-1 hover:underline">حذف</button>
                        </div>
                    </div>
                </template>
            </div>

            <div class="md:col-span-1">
                <div class="bg-white rounded-xl p-4 sticky top-20">
                    <h3 class="font-bold mb-4">خلاصه سبد</h3>
                    <div class="flex justify-between mb-2 text-sm">
                        <span>تعداد اقلام:</span>
                        <span x-text="itemsCount"></span>
                    </div>
                    <div class="flex justify-between mb-4 text-sm">
                        <span>مبلغ کل:</span>
                        <span class="font-bold text-blue-600" x-text="formatPrice(subtotal) + ' تومان'"></span>
                    </div>
                    <a href="{{ route('checkout') }}"
                       class="block text-center bg-blue-600 text-white rounded-lg py-3 font-medium hover:bg-blue-700">
                        ادامه خرید و پرداخت
                    </a>
                    <button @click="clearCart()"
                            class="w-full mt-2 text-red-600 text-sm hover:underline">
                        خالی کردن سبد
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function cartPage() {
            return {
                items: [],
                itemsCount: 0,
                subtotal: 0,
                loading: true,

                async load() {
                    try {
                        const res = await fetch('{{ route('cart.index') }}', {
                            headers: { 'Accept': 'application/json' },
                            credentials: 'include',
                        });
                        const data = await res.json();
                        this.items = data.data.items;
                        this.itemsCount = data.data.items_count;
                        this.subtotal = data.data.subtotal;
                    } catch (e) {
                        console.error(e);
                    } finally {
                        this.loading = false;
                    }
                },

                async updateQty(item, qty) {
                    if (qty < 1) return;
                    const res = await fetch('/api/cart/items/' + item.id, {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                        },
                        credentials: 'include',
                        body: JSON.stringify({ quantity: qty })
                    });
                    if (res.ok) this.load();
                },

                async removeItem(item) {
                    const res = await fetch('/api/cart/items/' + item.id, {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                        },
                        credentials: 'include',
                    });
                    if (res.ok) this.load();
                },

                async clearCart() {
                    if (! confirm('سبد خرید خالی شود؟')) return;
                    const res = await fetch('/api/cart/clear', {
                        method: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                        },
                        credentials: 'include',
                    });
                    if (res.ok) this.load();
                },

                formatPrice(n) {
                    return Number(n).toLocaleString('fa-IR');
                }
            }
        }
    </script>
@endpush
