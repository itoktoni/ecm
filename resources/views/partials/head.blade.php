<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="csrf-token" content="{{ csrf_token() }}" />
<meta name="theme-color" content="#000000" />

<title>{{ filled($title ?? null) ? $title.' - '.config('app.name', 'Laravel') : config('app.name', 'Laravel') }}</title>

<link rel="icon" href="/favicon.ico" sizes="any">
<link rel="icon" href="/favicon.svg" type="image/svg+xml">
<link rel="apple-touch-icon" href="/apple-touch-icon.png">
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
