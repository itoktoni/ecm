<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="shadcn">
<head>
    @include('partials.head')
</head>
<body class="min-h-screen bg-base-200 antialiased">
    <div class="flex min-h-svh flex-col items-center justify-center gap-6 p-6">
        <div class="flex w-full max-w-md flex-col">
            <a href="{{ route('home') }}" class="flex flex-col items-center gap-3 font-medium mb-4">
                @if(!config('company.logo') || !file_exists(public_path(config('company.logo'))))
                    <span class="text-lg font-semibold" style="color: var(--color-primary);">{{ config('company.name', config('app.name', 'Laravel')) }}</span>
                @else
                    <img src="{{ asset(config('company.logo')) }}" alt="{{ config('company.name') }}" class="h-16 w-auto object-contain" />
                @endif
            </a>
            <div class="flex flex-col gap-6">
                {{ $slot }}
            </div>
        </div>
    </div>
</body>
</html>
