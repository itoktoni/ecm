<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="csrf-token" content="{{ csrf_token() }}" />
<meta name="theme-color" content="#000000" />

<title>{{ filled($title ?? null) ? $title.' - '.config('app.name', 'Laravel') : config('app.name', 'Laravel') }}</title>

@php
    $favicon = config('company.logo') && file_exists(public_path(config('company.logo'))) ? config('company.logo') : 'storage/company-logo.png';
    if (!file_exists(public_path($favicon))) $favicon = 'favicon.ico';
    $ext = strtolower(pathinfo($favicon, PATHINFO_EXTENSION));
    $mime = $ext === 'svg' ? 'image/svg+xml' : ($ext === 'jpg' || $ext === 'jpeg' ? 'image/jpeg' : ($ext === 'webp' ? 'image/webp' : 'image/png'));
@endphp
<link rel="icon" href="{{ asset($favicon) }}?v={{ filemtime(public_path($favicon)) }}" type="{{ $mime }}" sizes="any">
<link rel="apple-touch-icon" href="{{ asset($favicon) }}?v={{ filemtime(public_path($favicon)) }}">
<link rel="manifest" href="/manifest.json">

@vite(['resources/css/app.css', 'resources/js/app.js'])

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
