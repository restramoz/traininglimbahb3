<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-concrete-50 text-concrete-800 antialiased">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@hasSection('title')@yield('title') — @endif{{ config('app.name', 'Training Limbah B3') }}</title>
    <meta name="description" content="@yield('meta_description', 'Pusat informasi, pelatihan sertifikasi kompetensi (PPPA, IPAL, PLB3, POIPPU) dan jasa konsultansi lingkungan hidup (Uji Emisi, UKL-UPL, Pertek, Rintek TPS B3) resmi nasional.')">

    <!-- Canonical URL -->
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Open Graph / Meta -->
    <meta property="og:title" content="@hasSection('title')@yield('title') — @endif{{ config('app.name', 'Training Limbah B3') }}">
    <meta property="og:description" content="@yield('meta_description', 'Layanan pelatihan sertifikasi lingkungan dan jasa perizinan pengelolaan limbah B3 resmi di Indonesia.')">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">

    <!-- Theme Color -->
    <meta name="theme-color" content="#0B192C">

    <!-- Styles & Scripts via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @hasSection('robots')
    <meta name="robots" content="@yield('robots')">
    @endif

    @stack('schema')
    @stack('styles')
</head>
<body class="min-h-full flex flex-col bg-concrete-50 text-concrete-800 selection:bg-emerald-600 selection:text-white">
    <!-- Accessible Skip Link -->
    <a href="#main-content" class="sr-only focus:not-sr-only focus:fixed focus:top-4 focus:left-4 z-50 bg-emerald-600 text-white font-bold px-4 py-2 rounded-md shadow-lg outline-none ring-2 ring-navy-950">
        Lewati ke konten utama
    </a>

    <!-- Site Header -->
    <x-header />

    <!-- Main Content Landmark -->
    <main id="main-content" class="flex-grow focus:outline-none" tabindex="-1">
        @if (isset($slot))
            {{ $slot }}
        @else
            @yield('content')
        @endif
    </main>

    <!-- Site Footer -->
    <x-footer />

    <!-- Floating WhatsApp CTA -->
    <x-wa-float :message="View::hasSection('wa_message') ? View::getSection('wa_message') : null" />
</body>
</html>
