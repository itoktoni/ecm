<?php /** @var App\Models\So $model */ ?>

<x-layouts::app>
    <x-breadcrumb :items="[['url' => '/dashboard', 'label' => 'Home'], ['url' => '', 'label' => ucfirst(module())]]" />
    <div class="content mt-4 lg:mt-0">
        <x-filter :per-page="25" :fields="$fields">
            <x-slot:advanced>
                @foreach ($fields as $key => $advance)
                <x-filter-item :label="$advance" :name="$key"/>
                @endforeach
                <x-button variant="primary" class="btn-block" onclick="applyAdvanced()">Apply</x-button>
                <x-button variant="soft" class="btn-block" onclick="resetAdvanced()">Reset</x-button>
            </x-slot:advanced>
        </x-filter>

        @php
            $currentSort = request('sort.0', '');
            $sortField = str_replace(':desc','',str_replace(':asc','',$currentSort));
            $sortDir = str_contains($currentSort, ':desc') ? 'desc' : 'asc';
        @endphp

        <x-table>
            <x-slot:head>
                <x-table-checkbox :model="$model" onchange="toggleAll(this)" />
                <th>Actions</th>
                <x-table-sort field="so_code" label="So Code" :sortField="$sortField" :sortDir="$sortDir" />
                <x-table-sort field="so_tanggal" label="Tanggal" :sortField="$sortField" :sortDir="$sortDir" />
                <th>Customer</th>
                <th>Status</th>
                <th>PPN</th>
                <th>PPH</th>
                <th>Discount</th>
                <th>Grand Total</th>
            </x-slot:head>
            <x-slot:body>
                @forelse ($data as $table)
                <tr>
                    <x-table-row-checkbox :model="$model" :value="$table->field_primary" />
                    <x-table-action :model="$model" :id="$table->field_primary">
                        @can('penawaran', $model)
                        <a href="{{ moduleRoute('getPenawaran', ['id' => $table->field_primary]) }}" target="_blank" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-surface-container text-on-surface-variant hover:bg-surface-container-high transition-colors">
                            <span class="material-symbols-outlined text-lg">request_quote</span>
                        </a>
                        @endcan
                        @can('suratTugas', $model)
                        <a href="{{ moduleRoute('getSuratTugas', ['id' => $table->field_primary]) }}" target="_blank" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-surface-container text-on-surface-variant hover:bg-surface-container-high transition-colors">
                            <span class="material-symbols-outlined text-lg">assignment_ind</span>
                        </a>
                        @endcan
                        @can('kajiUlang', $model)
                        <a href="{{ moduleRoute('getKajiUlang', ['id' => $table->field_primary]) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-surface-container text-on-surface-variant hover:bg-surface-container-high transition-colors">
                            <span class="material-symbols-outlined text-lg">fact_check</span>
                        </a>
                        @endcan
                        @can('print', $model)
                        <a href="{{ moduleRoute('getPrint', ['id' => $table->field_primary]) }}" target="_blank" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-surface-container text-on-surface-variant hover:bg-surface-container-high transition-colors">
                            <span class="material-symbols-outlined text-lg">print</span>
                        </a>
                        @endcan
                    </x-table-action>
                    <td>{{ $table->so_code }}</td>
                    <td>{{ formatDate($table->so_tanggal) }}</td>
                    <td>{{ $table->customer?->customer_nama ?? '-' }}</td>
                    <td>
                        @if($table->so_status === 'Confirmed')
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Confirmed</span>
                        @elseif($table->so_status === 'Shipped')
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">Shipped</span>
                        @elseif($table->so_status === 'Closed')
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-200 text-gray-700">Closed</span>
                        @else
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                        @endif
                    </td>
                    <td>
                        <div>{{ ucfirst($table->so_ppn) }} ({{ $table->so_ppn_rate }}%)</div>
                        <div class="text-xs text-on-surface-variant">{{ formatAngka((int) round($table->so_ppn_amount), 'Rp ') }}</div>
                    </td>
                    <td>
                        <div>{{ ucfirst($table->so_pph) }} ({{ $table->so_pph_rate }}%)</div>
                        <div class="text-xs text-on-surface-variant">{{ formatAngka((int) round($table->so_pph_amount), 'Rp ') }}</div>
                    </td>
                    <td>{{ formatAngka((int) $table->so_discount, 'Rp ') }}</td>
                    <td class="font-semibold">{{ formatAngka((int) round($table->so_grand_total), 'Rp ') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" class="text-center">No data available.</td>
                </tr>
                @endforelse
            </x-slot:body>
            <x-slot:mobile>
                <x-table-mobile-select :model="$model" :total="$data"/>
                <x-table-mobile-list>
                    @forelse ($data as $table)
                    <x-table-mobile-item :id="$table->field_primary">
                        <x-table-mobile-header title="{{ $table->so_code }}" />
                        <x-table-mobile-text :label="'Tanggal'" :text="formatDate($table->so_tanggal)" />
                        <x-table-mobile-text :label="'Customer'" :text="$table->customer?->customer_nama ?? '-'" />
                        <x-table-mobile-text :label="'Status'" :text="$table->so_status" />
                        <x-table-mobile-text :label="'PPN'" :text="ucfirst($table->so_ppn) . ' (' . $table->so_ppn_rate . '%)'" />
                        <x-table-mobile-text :label="'PPH'" :text="ucfirst($table->so_pph) . ' (' . $table->so_pph_rate . '%)'" />
                        <x-table-mobile-text :label="'Discount'" :text="formatAngka((int) $table->so_discount, 'Rp ')" />
                        <x-table-mobile-text :label="'Grand Total'" :text="formatAngka((int) round($table->so_grand_total), 'Rp ')" />
                        <x-table-mobile-footer :label="$table->field_primary">
                            <x-table-action :model="$model" :id="$table->field_primary">
                                @can('penawaran', $model)
                                <a href="{{ moduleRoute('getPenawaran', ['id' => $table->field_primary]) }}" target="_blank" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-surface-container text-on-surface-variant hover:bg-surface-container-high transition-colors">
                                    <span class="material-symbols-outlined text-lg">request_quote</span>
                                </a>
                                @endcan
                                @can('suratTugas', $model)
                                <a href="{{ moduleRoute('getSuratTugas', ['id' => $table->field_primary]) }}" target="_blank" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-surface-container text-on-surface-variant hover:bg-surface-container-high transition-colors">
                                    <span class="material-symbols-outlined text-lg">assignment_ind</span>
                                </a>
                                @endcan
                                @can('print', $model)
                                <a href="{{ moduleRoute('getPrint', ['id' => $table->field_primary]) }}" target="_blank" class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-surface-container text-on-surface-variant hover:bg-surface-container-high transition-colors">
                                    <span class="material-symbols-outlined text-lg">print</span>
                                </a>
                                @endcan
                            </x-table-action>
                        </x-table-mobile-footer>
                    </x-table-mobile-item>
                    @empty
                    <x-table-mobile-item>
                        <div class="text-center p-4">No data available.</div>
                    </x-table-mobile-item>
                    @endforelse
                </x-table-mobile-list>
            </x-slot:mobile>
        </x-table>

        <x-pagination :paginator="$data" />
        <x-action :model="$model" :action="['create', 'delete']"/>
    </div>

    <input type="hidden" class="module" value="{{ module() }}">
    <script src="/js/table.js"></script>
    <script>initTable('{{ $sortField }}', '{{ $sortDir }}');</script>
</x-layouts::app>
