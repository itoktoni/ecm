<?php /** @var \App\Models\Order $model */ ?>
<x-layouts::app>
    <x-breadcrumb :items="[['url' => '/dashboard', 'label' => 'Home'], ['url' => '', 'label' => 'Order Masuk']]" />
    <div class="content mt-4 lg:mt-0">
        @include('pages.wms.order._flash')

        <x-filter :per-page="25" :fields="$fields" :search-placeholder="'Cari No Order / Pemesan...'" />

        @php
            $currentSort = request('sort.0', '');
            $sortField = str_replace(':desc', '', str_replace(':asc', '', $currentSort));
            $sortDir = str_contains($currentSort, ':desc') ? 'desc' : 'asc';
        @endphp

        <x-table>
            <x-slot:head>
                <th class="w-12"></th>
                <th>Actions</th>
                <x-table-sort field="order_no" label="No Order" :sortField="$sortField" :sortDir="$sortDir" />
                <x-table-sort field="order_tanggal" label="Tanggal" :sortField="$sortField" :sortDir="$sortDir" />
                <th>Pemesan</th>
                <x-table-sort field="order_subtotal" label="Penawaran" :sortField="$sortField" :sortDir="$sortDir" />
                <x-table-sort field="order_total" label="Harga Fix" :sortField="$sortField" :sortDir="$sortDir" />
                <th>Status</th>
                <th>SO</th>
            </x-slot:head>

            <x-slot:body>
                @forelse ($data as $table)
                <tr>
                    <td class="w-12"></td>
                    <x-table-action :model="$model" :id="$table->order_id">
                        <a href="{{ route('orders.show', $table->order_id) }}" title="Detail"
                           class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-surface-container text-on-surface-variant hover:bg-surface-container-high transition-colors">
                            <span class="material-symbols-outlined text-lg">visibility</span>
                        </a>
                        @if(! $table->order_so_id)
                        <form method="POST" action="{{ route('orders.to-so', $table->order_id) }}" title="Convert to SO"
                              onsubmit="return confirm('Konversi order ini menjadi Sales Order (SO)?');" class="inline">
                            @csrf
                            <button type="submit"
                                    class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-primary/10 text-primary hover:bg-primary/20 transition-colors">
                                <span class="material-symbols-outlined text-lg">point_of_sale</span>
                            </button>
                        </form>
                        @endif
                    </x-table-action>
                    <td class="font-medium text-primary">#{{ $table->order_no }}</td>
                    <td>{{ formatDate($table->order_tanggal) }}</td>
                    <td>{{ $table->customer_nama ?? '-' }}</td>
                    <td>Rp {{ number_format($table->order_subtotal, 0, ',', '.') }}</td>
                    <td class="font-medium text-primary">Rp {{ number_format($table->order_total, 0, ',', '.') }}</td>
                    <td>
                        @if($table->order_status === 'completed')
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-medium rounded-full border border-green-200 bg-green-50 text-green-700">
                                <span class="w-1.5 h-1.5 rounded-full bg-current"></span> Selesai
                            </span>
                        @elseif(in_array($table->order_status, ['processing','shipping']))
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-medium rounded-full border border-blue-200 bg-blue-50 text-blue-700">
                                <span class="w-1.5 h-1.5 rounded-full bg-current"></span> {{ $table->getStatusLabel() }}
                            </span>
                        @elseif($table->order_status === 'cancelled')
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-medium rounded-full border border-red-200 bg-red-50 text-red-700">
                                <span class="w-1.5 h-1.5 rounded-full bg-current"></span> Dibatalkan
                            </span>
                        @else
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 text-xs font-medium rounded-full border border-amber-200 bg-amber-50 text-amber-700">
                                <span class="w-1.5 h-1.5 rounded-full bg-current"></span> {{ $table->getStatusLabel() }}
                            </span>
                        @endif
                    </td>
                    <td>
                        @if($table->order_so_id)
                            <a href="{{ route('wms-so.getUpdate', ['id' => $table->so?->so_id ?? $table->order_so_id]) }}"
                               class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-medium rounded-full border border-primary/30 bg-primary/5 text-primary hover:bg-primary/10 transition-colors">
                                <span class="material-symbols-outlined text-sm">point_of_sale</span> #{{ $table->so?->so_code ?? $table->order_so_id }}
                            </a>
                        @else
                            <span class="inline-flex items-center px-2 py-0.5 text-xs text-on-surface/40 border border-outline-variant/50 rounded-full">-</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center py-8 text-on-surface/50">No data available.</td>
                </tr>
                @endforelse
            </x-slot:body>
            <x-slot:mobile>
                <x-table-mobile-select :model="$model" :total="$data" />
                <x-table-mobile-list>
                    @forelse ($data as $table)
                    @php $st = $table->order_status; @endphp
                    <x-table-mobile-item :id="$table->order_id">
                        <div class="flex items-center justify-between gap-2">
                            <x-table-mobile-header :title="'#'.$table->order_no" />
                            <span class="px-2.5 py-1 text-xs font-medium rounded-full border {{ $st==='completed' ? 'border-green-200 bg-green-50 text-green-700' : (in_array($st,['processing','shipping']) ? 'border-blue-200 bg-blue-50 text-blue-700' : ($st==='cancelled' ? 'border-red-200 bg-red-50 text-red-700' : 'border-amber-200 bg-amber-50 text-amber-700')) }}">
                                {{ $table->getStatusLabel() }}
                            </span>
                        </div>
                        <div class="mt-2 space-y-0.5">
                            <x-table-mobile-text :text="$table->customer_nama ?? '-'" size="sm" />
                            <x-table-mobile-text :text="'Tanggal: '.formatDate($table->order_tanggal)" size="xs" class="text-on-surface-variant" />
                        </div>
                        <div class="flex items-center justify-between mt-2">
                            <x-table-mobile-text :text="'Penawaran: Rp '.number_format($table->order_subtotal,0,',','.')" size="xs" />
                            <x-table-mobile-text :text="'Fix: Rp '.number_format($table->order_total,0,',','.')" size="lg" :color="'primary'" />
                        </div>
                        @if($table->order_so_id)
                            <div class="mt-1">
                                <a href="{{ route('wms-so.getUpdate', ['id' => $table->so?->so_id ?? $table->order_so_id]) }}"
                                   class="inline-flex items-center gap-1 text-xs font-medium text-primary">
                                    <span class="material-symbols-outlined text-sm">point_of_sale</span> SO: #{{ $table->so?->so_code ?? $table->order_so_id }}
                                </a>
                            </div>
                        @endif
                        <x-table-mobile-footer :label="$table->customer_telepon ?: 'Order'">
                            <a href="{{ route('orders.show', $table->order_id) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-surface-container text-on-surface-variant hover:bg-surface-container-high transition-colors">
                                <span class="material-symbols-outlined text-lg">visibility</span>
                            </a>
                            @if(! $table->order_so_id)
                            <form method="POST" action="{{ route('orders.to-so', $table->order_id) }}" onsubmit="return confirm('Konversi order ini menjadi Sales Order (SO)?');">
                                @csrf
                                <button type="submit" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-primary/10 text-primary hover:bg-primary/20 transition-colors">
                                    <span class="material-symbols-outlined text-lg">point_of_sale</span>
                                </button>
                            </form>
                            @endif
                        </x-table-mobile-footer>
                    </x-table-mobile-item>
                    @empty
                    <x-table-mobile-item><div class="text-center p-4 text-on-surface/50">No data available.</div></x-table-mobile-item>
                    @endforelse
                </x-table-mobile-list>
            </x-slot:mobile>
        </x-table>

        <x-pagination :paginator="$data" />

        <input type="hidden" class="module" value="{{ module() }}">
        <script src="/js/table.js?v=3"></script>
        <script>
            initTable('{{ $sortField }}', '{{ $sortDir }}');
        </script>
    </div>
</x-layouts::app>
