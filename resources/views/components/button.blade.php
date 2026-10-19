@props([
    'variant' => 'primary',
    'size' => 'md',
    'href' => null,
    'type' => 'button',
])

@php
    $baseClasses = 'inline-flex items-center justify-center font-semibold rounded-lg transition-colors duration-150 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-safety-500 focus-visible:ring-offset-2 disabled:opacity-50 disabled:pointer-events-none cursor-pointer text-center';

    $sizes = [
        'sm' => 'px-3.5 py-1.5 text-xs sm:text-sm gap-1.5 min-h-[38px]',
        'md' => 'px-5 py-2.5 text-sm sm:text-base gap-2 min-h-[44px]',
        'lg' => 'px-7 py-3 text-base sm:text-lg gap-2.5 min-h-[48px]',
    ];

    $variants = [
        'primary' => 'bg-safety-500 hover:bg-safety-400 text-navy-950 shadow-sm active:bg-safety-600 font-bold',
        'secondary' => 'bg-navy-900 hover:bg-navy-800 text-white shadow-sm border border-navy-800 active:bg-navy-950',
        'outline' => 'bg-transparent hover:bg-concrete-100 text-navy-900 border border-concrete-300 active:bg-concrete-200',
        'white' => 'bg-white hover:bg-concrete-100 text-navy-950 shadow-sm active:bg-concrete-200 font-semibold',
        'wa' => 'bg-wa-500 hover:bg-wa-600 text-white shadow-sm active:bg-wa-700 font-semibold',
    ];

    $sizeClasses = $sizes[$size] ?? $sizes['md'];
    $variantClasses = $variants[$variant] ?? $variants['primary'];
    $classes = "{$baseClasses} {$sizeClasses} {$variantClasses}";
@endphp

@if ($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
        {{ $slot }}
    </button>
@endif
