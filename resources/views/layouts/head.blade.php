<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <meta name="notification-enabled" content="{{ config('langkahkecil.notification_enable') ? 'true' : 'false' }}"/>
    @if(config('centrifugo.url'))
    <meta name="centrifugo-url" content="{{ str_replace(['http://', 'https://'], ['ws://', 'wss://'], config('centrifugo.url')) }}/connection/websocket"/>
    @endif
    @auth
    <meta name="user-id" content="{{ auth()->id() }}"/>
    @endauth
    <title>{{ $title ?? 'WMS Portal' }}</title>
    @php
        $faviconHead = config('company.logo') && file_exists(public_path(config('company.logo'))) ? config('company.logo') : 'storage/company-logo.png';
        if (!file_exists(public_path($faviconHead))) $faviconHead = 'favicon.ico';
        $extHead = strtolower(pathinfo($faviconHead, PATHINFO_EXTENSION));
        $mimeHead = $extHead === 'svg' ? 'image/svg+xml' : ($extHead === 'jpg' || $extHead === 'jpeg' ? 'image/jpeg' : ($extHead === 'webp' ? 'image/webp' : 'image/png'));
    @endphp
    <link rel="icon" href="{{ asset($faviconHead) }}?v={{ filemtime(public_path($faviconHead)) }}" type="{{ $mimeHead }}" sizes="any">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=JetBrains+Mono:wght@500&family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/notifications.js'])
    @livewireStyles
    <style>
        :root {
            --color-primary: {{ config('theme.primary') }};
            --color-primary-container: {{ config('theme.primary_container') }};
            --color-secondary: {{ config('theme.secondary') }};
            --color-secondary-container: {{ config('theme.secondary') }};
            --color-on-primary: {{ config('theme.on_primary') }};
            --color-error: {{ config('theme.error') }};
        }
    </style>
    @stack('styles')
</head>
