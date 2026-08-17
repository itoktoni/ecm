@php
    $role = auth()->user()->role ?? 'guest';
    $bottomNav = match ($role) {
        'admin', 'developer' => [
            ['route' => 'dashboard', 'icon' => 'dashboard', 'label' => 'Home'],
            ['route' => 'orders.index', 'icon' => 'shopping_cart_checkout', 'label' => 'Order'],
            ['route' => 'orders.index', 'icon' => 'shopping_cart_checkout', 'label' => 'Order'],
            ['route' => 'wms-so.getTable', 'icon' => 'point_of_sale', 'label' => 'SO'],
            ['route' => 'profile.edit', 'icon' => 'person', 'label' => 'Profil'],
        ],
        'teknisi' => [
            ['route' => 'dashboard', 'icon' => 'home', 'label' => 'Home'],
            ['route' => 'wms-pekerjaan.getTable', 'icon' => 'engineering', 'label' => 'Kerja'],
            ['route' => 'wms-pekerjaan.getTable', 'icon' => 'engineering', 'label' => 'Pekerjaan'],
            ['route' => 'profile.edit', 'icon' => 'person', 'label' => 'Profil'],
            ['route' => 'dashboard', 'icon' => 'grid_view', 'label' => 'Home'],
        ],
        'editor', 'user' => [
            ['route' => 'dashboard', 'icon' => 'home', 'label' => 'Home'],
            ['route' => 'content.getTable', 'icon' => 'library_books', 'label' => 'Konten'],
            ['route' => 'dashboard', 'icon' => 'dashboard', 'label' => 'Home'],
            ['route' => 'profile.edit', 'icon' => 'person', 'label' => 'Profil'],
            ['route' => 'dashboard', 'icon' => 'grid_view', 'label' => 'Home'],
        ],
        default => [
            ['route' => 'dashboard', 'icon' => 'home', 'label' => 'Home'],
            ['route' => 'profile.edit', 'icon' => 'person', 'label' => 'Profil'],
            ['route' => 'dashboard', 'icon' => 'dashboard', 'label' => 'Home'],
            ['route' => 'dashboard', 'icon' => 'grid_view', 'label' => 'Menu'],
            ['route' => 'dashboard', 'icon' => 'settings', 'label' => 'Opsi'],
        ],
    };
@endphp

<nav class="md:hidden fixed bottom-0 left-0 w-full h-16 bg-surface-container-lowest border-t border-outline-variant z-50 shadow-[0_-4px_10px_rgba(0,0,0,0.05)]">
    <div class="flex items-center justify-around h-full px-2">
        @foreach($bottomNav as $index => $item)
            @php
                $routeName = $item['route'];
                $url = route($routeName);
                $isActive = request()->routeIs($routeName) || request()->routeIs($routeName . '.*');
                $isCenter = $index === 2;
            @endphp

            @if($isCenter)
                <div class="flex items-center justify-center flex-1 -mt-4">
                    <a
                        href="{{ $url }}"
                        class="flex items-center justify-center bg-primary text-on-primary w-14 h-14 rounded-2xl shadow-lg ring-4 ring-surface-container-lowest active:scale-90 transition-all"
                    >
                        <span class="material-symbols-outlined text-[28px]">{{ $item['icon'] }}</span>
                    </a>
                </div>
            @else
                <a href="{{ $url }}" class="flex flex-col items-center justify-center transition-all flex-1 {{ $isActive ? 'text-primary opacity-100' : 'text-on-surface-variant opacity-60 hover:opacity-100' }}">
                    <span class="material-symbols-outlined text-[24px]">{{ $item['icon'] }}</span>
                    <span class="text-[10px] font-bold uppercase tracking-tighter">{{ $item['label'] }}</span>
                </a>
            @endif
        @endforeach
    </div>
</nav>
