@props(['items', 'mobile' => false])

@php
    $menu = config('menu.sidebar');
    $allRoutes = collect($menu)->flatMap(fn ($s) => collect($s['items'])->pluck('route'));
    $prefixCounts = $allRoutes->map(fn ($r) => \Illuminate\Support\Str::beforeLast($r, '.'))->countBy();
@endphp

@foreach($menu as $section)
    @if($section['label'])
        <div class="px-4 pt-4 pb-1 mr-2 font-label-caps text-label-caps text-on-surface-variant uppercase tracking-widest">{{ $section['label'] }}</div>
    @endif
    @foreach($section['items'] as $item)
        @php
            $routeName = $item['route'];
            $url = route($routeName);
            $routePrefix = Str::beforeLast($routeName, '.');
            // Prefix match only when this prefix belongs to a single menu item,
            // otherwise siblings (e.g. settings.company & settings.env) both light up.
            $isActive = request()->routeIs($routeName)
                || request()->routeIs($routeName . '.*')
                || (($prefixCounts[$routePrefix] ?? 0) === 1 && request()->routeIs($routePrefix . '.*'));
        @endphp
        <a
            href="{{ $url }}"
            @if($mobile) @click="drawerOpen = false" @endif
            class="flex items-center gap-3 px-4 py-3 mr-2 rounded-xl transition-all {{ $mobile ? '' : 'group' }} {{ $isActive ? 'bg-primary text-on-primary font-semibold' : 'bg-surface-container text-on-surface-variant hover:bg-surface-container-high hover:text-on-surface' }}"
        >
            <span class="material-symbols-outlined {{ $isActive ? 'text-on-primary' : 'text-on-surface-variant' . ($mobile ? '' : ' group-hover:text-on-surface') }}">{{ $item['icon'] }}</span>
            <span class="font-body-sm">{{ $item['label'] }}</span>
        </a>
    @endforeach
@endforeach
