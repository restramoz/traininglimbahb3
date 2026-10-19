@extends('layouts.app')

@section('title', 'Training & Jasa Pengelolaan Limbah B3 Provinsi ' . $province['name'] . ' — Konsultasi & Layanan Resmi')
@section('meta_description', 'Layanan pelatihan sertifikasi BNSP (PPPA, IPAL, PLB3, dsb) dan jasa konsultansi lingkungan hidup (Uji Emisi, UKL-UPL, Pertek, Rintek, Transportasi Limbah B3) untuk wilayah Provinsi ' . $province['name'] . '.')
@section('wa_message', $waMessage)

@section('content')
    {{-- Breadcrumb --}}
    <div class="bg-navy-950 border-b border-navy-900">
        <x-breadcrumb :items="[
            ['label' => 'Wilayah', 'url' => null],
            ['label' => $province['name'], 'url' => null],
        ]" />
    </div>

    {{-- Hero --}}
    <section class="relative bg-navy-950 text-white overflow-hidden border-b border-navy-800" aria-labelledby="prov-hero-heading">
        <div class="absolute inset-0 opacity-10 pointer-events-none" aria-hidden="true">
            <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
                <defs><pattern id="grid-p" width="40" height="40" patternUnits="userSpaceOnUse"><path d="M 40 0 L 0 0 0 40" fill="none" stroke="#FFF" stroke-width="1"/></pattern></defs>
                <rect width="100%" height="100%" fill="url(#grid-p)" />
            </svg>
        </div>
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14 sm:py-20">
            <div class="max-w-3xl">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-navy-900 border border-emerald-500/40 text-emerald-400 text-xs sm:text-sm font-semibold mb-6">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    Layanan Informasi &amp; Konsultasi Lingkungan Hidup
                </div>
                <h1 id="prov-hero-heading" class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight text-white leading-tight uppercase">
                    Training &amp; Jasa Limbah B3<br><span class="text-emerald-400">Provinsi {{ $province['name'] }}</span>
                </h1>
                <p class="mt-6 text-base sm:text-lg text-concrete-300 leading-relaxed">
                    Pusat informasi konsultasi pelatihan kompetensi BNSP dan jasa teknis pengelolaan limbah B3 serta perizinan lingkungan hidup untuk industri, rumah sakit, dan badan usaha di <strong class="text-white">Provinsi {{ $province['name'] }}</strong>.
                </p>
                <div class="mt-8 flex flex-col sm:flex-row gap-4">
                    <x-wa-cta variant="primary" size="lg" :message="$waMessage" label="Konsultasi Wilayah {{ $province['name'] }}" class="bg-emerald-600 hover:bg-emerald-500 text-white shadow-lg" />
                </div>
                <div class="mt-10 pt-8 border-t border-navy-800/80 grid grid-cols-2 sm:grid-cols-4 gap-6">
                    <div><div class="text-xs text-concrete-400 uppercase tracking-wider">Pulau</div><div class="text-lg font-extrabold text-emerald-400 mt-0.5">{{ $province['island'] }}</div></div>
                    <div><div class="text-xs text-concrete-400 uppercase tracking-wider">Kab/Kota</div><div class="text-lg font-extrabold text-white mt-0.5">{{ $province['total_cities'] }}</div></div>
                    <div><div class="text-xs text-concrete-400 uppercase tracking-wider">Layanan</div><div class="text-lg font-extrabold text-emerald-400 mt-0.5">13 Program</div></div>
                    <div><div class="text-xs text-concrete-400 uppercase tracking-wider">Kepatuhan</div><div class="text-lg font-extrabold text-white mt-0.5">PP 22/2021</div></div>
                </div>
            </div>
        </div>
    </section>

    {{-- Disclaimer --}}
    <section class="py-10 bg-amber-50/80 border-b border-amber-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-start gap-4">
                <svg class="w-6 h-6 text-amber-600 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                <p class="text-sm text-amber-900 leading-relaxed">
                    <strong>Catatan penting:</strong> Halaman ini adalah portal informasi dan konsultasi resmi. Penyelenggaraan pelatihan tatap muka, in-house, jadwal pengujian emisi cerobong, serta penyusunan dokumen persetujuan teknis di kota atau kabupaten dalam Provinsi {{ $province['name'] }} dikoordinasikan secara langsung melalui tim konsultan kami untuk memastikan kepatuhan terhadap instansi DLH setempat.
                </p>
            </div>
        </div>
    </section>

    {{-- Program Links --}}
    <section id="program" class="py-14 sm:py-20 bg-concrete-50 border-b border-concrete-200" aria-labelledby="prov-program-heading">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl mb-12">
                <span class="text-xs font-bold uppercase tracking-wider text-emerald-700 bg-emerald-soft px-3 py-1 rounded-full">13 Layanan Unggulan</span>
                <h2 id="prov-program-heading" class="mt-3 text-2xl sm:text-3xl font-extrabold text-navy-950 tracking-tight">
                    Program Sertifikasi &amp; Jasa Konsultansi di {{ $province['name'] }}
                </h2>
                <p class="mt-4 text-base text-concrete-600">Pilih program sertifikasi kompetensi atau jasa konsultansi lingkungan hidup sesuai kebutuhan instansi dan industri Anda.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($programs as $prog)
                <a href="{{ route('program.show', $prog['slug']) }}" class="group flex flex-col bg-white rounded-xl border border-concrete-200 hover:border-emerald-500 hover:shadow-md transition-all overflow-hidden focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-500">
                    <div class="h-1.5 {{ ($prog['category'] ?? 'training') === 'training' ? 'bg-emerald-500' : 'bg-navy-900' }}"></div>
                    <div class="p-6 flex-1 flex flex-col">
                        <div class="text-xs font-bold uppercase tracking-wider text-emerald-700 mb-1">{{ $prog['category_label'] ?? 'Layanan' }}</div>
                        <h3 class="text-lg font-bold text-navy-950 mb-2 group-hover:text-emerald-700 transition-colors">{{ $prog['title'] }}</h3>
                        <p class="text-xs sm:text-sm text-concrete-600 flex-1 leading-relaxed line-clamp-3">{{ $prog['hero_subheading'] }}</p>
                        <div class="mt-4 pt-4 border-t border-concrete-100 text-xs font-bold text-emerald-700 flex items-center justify-between">
                            <span>Rincian Program</span>
                            <span>&rarr;</span>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Cities in Province --}}
    @if(count($province['cities']) > 0)
    <section id="kota" class="py-14 sm:py-20 bg-white border-b border-concrete-200" aria-labelledby="prov-kota-heading">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h2 id="prov-kota-heading" class="text-2xl font-extrabold text-navy-950 mb-8">
                Kabupaten &amp; Kota di Provinsi {{ $province['name'] }}
            </h2>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3">
                @foreach($province['cities'] as $c)
                <a href="{{ route('regional.city', $c['slug']) }}" class="block px-3 py-2.5 rounded-lg bg-concrete-50 border border-concrete-200 hover:border-emerald-500 hover:bg-emerald-soft text-sm font-medium text-navy-900 hover:text-emerald-700 transition-colors truncate focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-500">
                    {{ $c['name'] }}
                </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- FAQ --}}
    <section id="faq" class="py-14 sm:py-20 bg-concrete-50 border-b border-concrete-200" aria-labelledby="prov-faq-heading">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <span class="text-xs font-bold uppercase tracking-wider text-emerald-700 bg-emerald-soft px-3 py-1 rounded-full">Tanya Jawab</span>
                <h2 id="prov-faq-heading" class="mt-3 text-2xl font-extrabold text-navy-950 tracking-tight">FAQ: Layanan Lingkungan Hidup di {{ $province['name'] }}</h2>
            </div>
            <div class="space-y-4">
                @foreach([
                    [
                        'q' => 'Apakah pelatihan kompetensi BNSP dan jasa lingkungan melayani wilayah Provinsi ' . $province['name'] . '?',
                        'a' => 'Ya, kami melayani konsultasi dan pelaksanaan pelatihan daring/luring serta jasa teknis lingkungan hidup untuk seluruh kota dan kabupaten di Provinsi ' . $province['name'] . '.',
                    ],
                    [
                        'q' => 'Program apa saja yang tersedia untuk kepatuhan lingkungan industri?',
                        'a' => 'Tersedia 7 program sertifikasi kompetensi BNSP (PPPA, IPAL, POIPPU, PLB3, OLB3, PPPU, PCUA) dan 6 jasa konsultansi teknis (Uji Emisi, UKL-UPL, Pertek, Rintek, RKL-RPL, dan Transportasi Limbah B3).',
                    ],
                    [
                        'q' => 'Bagaimana cara mengajukan proposal in-house training atau jasa pertek di ' . $province['name'] . '?',
                        'a' => 'Hubungi konsultan kami melalui WhatsApp. Tim kami akan menyiapkan proposal teknis dan biaya penawaran resmi yang disesuaikan dengan kebutuhan fasilitas usaha Anda.',
                    ],
                ] as $faq)
                <details class="group bg-white rounded-xl border border-concrete-200 p-5 sm:p-6 open:border-emerald-500">
                    <summary class="flex justify-between items-center gap-4 font-bold text-navy-950 cursor-pointer list-none focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-500 rounded">
                        <span>{{ $faq['q'] }}</span>
                        <span class="w-7 h-7 rounded-full bg-concrete-100 flex items-center justify-center shrink-0 group-open:rotate-180 transition-transform">
                            <svg class="w-4 h-4 text-concrete-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/></svg>
                        </span>
                    </summary>
                    <p class="mt-4 pt-4 border-t border-concrete-100 text-sm text-concrete-700 leading-relaxed">{{ $faq['a'] }}</p>
                </details>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Final CTA --}}
    <section class="py-16 sm:py-24 bg-navy-950 text-white" aria-labelledby="prov-cta-heading">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="max-w-3xl mx-auto">
                <h2 id="prov-cta-heading" class="text-2xl sm:text-3xl font-extrabold uppercase tracking-tight">
                    Konsultasi Pelatihan &amp; Jasa Limbah B3<br><span class="text-emerald-400">Provinsi {{ $province['name'] }}</span>
                </h2>
                <p class="mt-4 text-base text-concrete-300 leading-relaxed">
                    Hubungi konsultan kami untuk verifikasi dokumen, pendaftaran batch pelatihan BNSP, atau penjadwalan konsultansi perizinan lingkungan hidup.
                </p>
                <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-4">
                    <x-wa-cta variant="primary" size="lg" :message="$waMessage" label="Konsultasi Sekarang" class="bg-emerald-600 hover:bg-emerald-500 text-white shadow-lg" />
                    <x-button :href="route('home')" variant="outline" size="lg" class="text-white border-concrete-500 hover:bg-navy-900">Kembali ke Beranda</x-button>
                </div>
            </div>
        </div>
    </section>
@endsection
