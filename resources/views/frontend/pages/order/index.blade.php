@extends('frontend.layouts.public')
@section('title', 'Order Saya')

@section('content')
<div class="max-w-7xl mx-auto mt-10 px-4 py-16 min-h-screen">

    {{-- Flasher (success / error) --}}
    <script src="/vendor/flasher/flasher.min.js"></script>
    <link href="/vendor/flasher/flasher.min.css" rel="stylesheet" />

    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-headline-lg text-primary">Order Saya</h1>
        <a href="{{ route('order.create') }}"
           class="bg-primary text-on-primary px-6 py-2.5 rounded-lg font-label-md hover:opacity-90 transition">
            Buat Order Baru
        </a>
    </div>

        @if(session('flasher'))
        @php
            $fm = \Illuminate\Support\Arr::first(session('flasher'));
            $ft = session('flasher.success') ? 'success' : 'error';
        @endphp
        <script>document.addEventListener("DOMContentLoaded",function() {
            flasher.{{ $ft }}("{{ json_encode($fm) }}");
        }});</script>
    @endif

    @if(Auth::guard('web')->check())
        @if($orders->isNotEmpty())
            <div class="overflow-x-auto bg-white rounded-xl shadow-sm border border-outline-variant/30">
                <table class="w-full text-sm">
                    <thead class="bg-surface-container-low border-b">
                        <tr>
                            <th class="text-left py-3 px-4 font-label-md text-on-surface">#</th>
                            <th class="text-left py-3 px-4 font-label-md text-on-surface">No Order</th>
                            <th class="text-left py-3 px-4 font-label-md text-on-surface">Tanggal</th>
                            <th class="text-left py-3 px-4 font-label-md text-on-surface">Pemesan</th>
                            <th class="text-right py-3 px-4 font-label-md text-on-surface">Total</th>
                            <th class="text-left py-3 px-4 font-label-md text-on-surface">Status</th>
                            <th class="text-center py-3 px-4 font-label-md text-on-surface">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y">
                        @foreach($orders as $order)
                            <tr class="hover:bg-surface-container-low/50 transition">
                                <td class="py-3 px-4 text-on-surface/60">{{ $loop->iteration }}</td>
                                <td class="py-3 px-4 font-medium text-primary">#{{ $order->order_no }}</td>
                                <td class="py-3 px-4">{{ $order->order_tanggal?->format('d/m/Y') ?? '-' }}</td>
                                <td class="py-3 px-4">
                                    <div class="font-medium">{{ $order->customer_nama }}</div>
                                    <div class="text-xs text-on-surface/60">{{ $order->customer_telepon }}</div>
                                </td>
                                <td class="py-3 px-4 text-right font-medium">Rp {{ number_format($order->order_total, 0, ',', '.') }}</td>
                                <td class="py-3 px-4">
                                    <span class="px-2 py-1 text-xs rounded-full
                                        @if($order->order_status==='completed') bg-green-100 text-green-800
                                        @elseif($order->order_status==='processing'||$order->order_status==='shipping') bg-blue-100 text-blue-800
                                        @elseif($order->order_status==='cancelled') bg-red-100 text-red-800
                                        @else bg-amber-100 text-amber-800 @endif">
                                        {{ $order->getStatusLabel() }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 text-center space-x-2">
                                    <a href="{{ route('order.show', ['order' => $order->order_id]) }}"
                                       class="text-secondary hover:underline text-sm">Detail</a>
                                    <a href="{{ route('order.show', ['order' => $order->order_id]) }}#invoice"
                                       class="text-secondary hover:underline text-sm">Invoice</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-16 bg-white rounded-xl shadow-sm border border-outline-variant/30">
                <span class="material-symbols-outlined text-5xl text-on-surface/20 mb-4">receipt_long</span>
                <p class="text-on-surface/60 mb-6">Anda belum memiliki order.</p>
                <a href="{{ route('order.create') }}"
                   class="bg-primary text-on-primary px-6 py-2.5 rounded-lg font-label-md hover:opacity-90 transition">
                    Pesan Sekarang
                </a>
            </div>
        @endif
    @else
        <div class="text-center py-16 bg-white rounded-xl shadow-sm border border-outline-variant/30">
            <span class="material-symbols-outlined text-5xl text-on-surface/20 mb-4">login</span>
            <p class="text-on-surface/60 mb-6">Silakan login untuk melihat order Anda.</p>
            <a href="{{ route('login') }}"
               class="bg-primary text-on-primary px-6 py-2.5 rounded-lg font-label-md hover:opacity-90 transition">
                Login
            </a>
        </div>
    @endif
</div>
@endsection
