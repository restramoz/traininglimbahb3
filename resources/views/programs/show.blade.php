@extends('layouts.app')

@section('title', $program['meta_title'])
@section('meta_description', $program['meta_description'])
@section('wa_message', $program['wa_message'])

@section('content')
    <!-- BREADCRUMB NAVIGATION -->
    <div class="bg-navy-950 border-b border-navy-900">
        <x-breadcrumb :items="[
            ['label' => $program['category_label'] ?? 'Layanan', 'url' => route('home') . (($program['category'] ?? '') === 'service' ? '#jasa' : '#pelatihan')],
            ['label' => $program['title'], 'url' => null],
        ]" />
    </div>

    <!-- HERO SECTION -->
    <section class="relative bg-navy-950 text-white overflow-hidden border-b border-navy-800" aria-labelledby="program-hero-heading">
        <!-- Industrial Grid Pattern Accent -->
        <div class="absolute inset-0 opacity-10 pointer-events-none" aria-hidden="true">
            <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="program-grid-pattern" width="40" height="40" patternUnits="userSpaceOnUse">
                        <path d="M 40 0 L 0 0 0 40" fill="none" stroke="#FFFFFF" stroke-width="1" />
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#program-grid-pattern)" />
            </svg>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14 sm:py-20 lg:py-24">
            <div class="max-w-3xl">
                <!-- Program Badge -->
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-navy-900 border border-emerald-500/40 text-emerald-400 text-xs sm:text-sm font-semibold mb-6 shadow-inner">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span>{{ $program['badge'] }}</span>
                </div>

                <!-- Main Heading -->
                <h1 id="program-hero-heading" class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight text-white leading-tight uppercase">
                    {{ $program['hero_heading'] }} <span class="text-emerald-400">{{ $program['hero_highlight'] }}</span>
                </h1>

                <!-- Subheading -->
                <p class="mt-6 text-base sm:text-lg lg:text-xl text-concrete-300 leading-relaxed">
                    {{ $program['hero_subheading'] }}
                </p>

                <!-- Action Buttons -->
                <div class="mt-8 sm:mt-10 flex flex-col sm:flex-row items-stretch sm:items-center gap-4">
                    <x-wa-cta variant="primary" size="lg" :message="$program['wa_message']" :label="'Konsultasi ' . explode('(', $program['title'])[0]" class="shadow-md bg-emerald-600 hover:bg-emerald-500 text-white" />
                    <x-button href="#informasi-resmi" variant="outline" size="lg" class="text-white border-concrete-500 hover:bg-navy-900">
                        Rincian &amp; Persyaratan
                    </x-button>
                </div>

                <!-- Key Attributes Bar -->
                <div class="mt-12 pt-8 border-t border-navy-800/80 grid grid-cols-2 sm:grid-cols-4 gap-6">
                    <div>
                        <div class="text-xs font-semibold uppercase tracking-wider text-concrete-400">Kategori</div>
                        <div class="text-lg sm:text-xl font-extrabold text-emerald-400 mt-0.5 truncate">{{ $program['level'] }}</div>
                    </div>
                    <div>
                        <div class="text-xs font-semibold uppercase tracking-wider text-concrete-400">Sektor</div>
                        <div class="text-lg sm:text-xl font-extrabold text-white mt-0.5">Lingkungan Hidup</div>
                    </div>
                    <div>
                        <div class="text-xs font-semibold uppercase tracking-wider text-concrete-400">Legalitas</div>
                        <div class="text-lg sm:text-xl font-extrabold text-emerald-400 mt-0.5">PP 22/2021</div>
                    </div>
                    <div>
                        <div class="text-xs font-semibold uppercase tracking-wider text-concrete-400">Layanan</div>
                        <div class="text-lg sm:text-xl font-extrabold text-white mt-0.5">Konsultatif</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 1: PENGENALAN & SASARAN PESERTA -->
    <section id="pengenalan" class="py-14 sm:py-20 bg-concrete-50 border-b border-concrete-200" aria-labelledby="pengenalan-heading">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-14 items-start">
                <!-- Left: Intro Narrative -->
                <div class="lg:col-span-7 space-y-6">
                    <div class="inline-flex items-center gap-2">
                        <span class="text-xs sm:text-sm font-bold uppercase tracking-wider text-emerald-700 bg-emerald-100 border border-emerald-300 px-3 py-1 rounded-full">
                            Tujuan &amp; Ruang Lingkup
                        </span>
                    </div>
                    <h2 id="pengenalan-heading" class="text-2xl sm:text-3xl font-extrabold text-navy-950 tracking-tight">
                        Mengenal Lebih Dekat {{ $program['title'] }}
                    </h2>
                    <p class="text-base sm:text-lg text-concrete-700 leading-relaxed">
                        {{ $program['introduction'] }}
                    </p>
                    <div class="p-5 rounded-xl bg-white border border-concrete-200 shadow-sm">
                        <div class="flex items-start gap-3.5">
                            <div class="w-9 h-9 rounded-lg bg-navy-950 text-emerald-400 flex items-center justify-center shrink-0 mt-0.5">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div class="text-sm text-concrete-700 leading-relaxed">
                                <span class="font-bold text-navy-950 block mb-0.5">Kepatuhan Regulasi Nyata</span>
                                Pendekatan layanan diarahkan pada pemenuhan baku mutu teknis, mitigasi sanksi lingkungan, dan kelengkapan dokumen sah untuk audit PROPER / ISO 14001.
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right: Target Audience Card -->
                <div class="lg:col-span-5">
                    <div class="bg-white rounded-2xl border border-concrete-200 p-6 sm:p-8 shadow-sm">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="w-10 h-10 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-navy-950">Sasaran &amp; Sektor Terkait</h3>
                                <p class="text-xs text-concrete-500">Profil yang relevan untuk program ini</p>
                            </div>
                        </div>

                        <ul class="space-y-3.5" role="list">
                            @foreach ($program['target_audience'] as $audience)
                                <li class="flex items-start gap-3 text-sm text-concrete-700">
                                    <svg class="w-5 h-5 text-emerald-600 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span>{{ $audience }}</span>
                                </li>
                            @endforeach
                        </ul>

                        <div class="mt-6 pt-6 border-t border-concrete-100">
                            <x-wa-cta variant="secondary" size="sm" :message="$program['wa_message']" label="Konsultasikan Kebutuhan Anda" class="w-full justify-center" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 2: RUANG LINGKUP & TANGGUNG JAWAB -->
    <section id="tanggung-jawab" class="py-14 sm:py-20 bg-white border-b border-concrete-200" aria-labelledby="tanggung-jawab-heading">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl mb-12">
                <span class="text-xs sm:text-sm font-bold uppercase tracking-wider text-emerald-700 bg-emerald-100 border border-emerald-300 px-3 py-1 rounded-full">
                    Ruang Lingkup Teknis
                </span>
                <h2 id="tanggung-jawab-heading" class="mt-3 text-2xl sm:text-3xl font-extrabold text-navy-950 tracking-tight">
                    Kompetensi &amp; Output Kerja
                </h2>
                <p class="mt-4 text-base text-concrete-600 leading-relaxed">
                    Gambaran komprehensif mengenai ruang lingkup pelaksanaan teknis dan kepatuhan yang dihasilkan melalui layanan {{ $program['title'] }}.
                </p>
            </div>

            <!-- Deliverables Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($program['roles_and_responsibilities'] as $index => $item)
                    <div class="flex flex-col bg-concrete-50 rounded-xl border border-concrete-200 p-6 hover:border-emerald-500 transition-colors">
                        <div class="w-8 h-8 rounded-lg bg-navy-950 text-emerald-400 flex items-center justify-center font-bold text-sm mb-4">
                            {{ $index + 1 }}
                        </div>
                        <h3 class="text-base font-bold text-navy-950 mb-2">
                            {{ $item['title'] }}
                        </h3>
                        <p class="text-sm text-concrete-600 leading-relaxed flex-1">
                            {{ $item['description'] }}
                        </p>
                    </div>
                @endforeach
            </div>

            <!-- Regulatory Advisory Note -->
            <div class="mt-10 p-6 rounded-2xl bg-amber-50/70 border border-amber-200 text-amber-950">
                <div class="flex items-start gap-3.5">
                    <svg class="w-6 h-6 text-amber-600 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <div class="text-sm space-y-1">
                        <h4 class="font-bold text-amber-900">Perhatian: Kepatuhan Administratif &amp; Verifikasi Resmi</h4>
                        <p class="text-amber-900/90 leading-relaxed">
                            Penyusunan dokumen teknis dan kepesertaan sertifikasi disesuaikan dengan izin usaha (NIB/KBLI) serta regulasi spesifik sektor industri. Calon peserta atau badan usaha dianjurkan mengonfirmasikan data awal fasilitas kepada tim konsultan kami sebelum memulai proses formal.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 3: INFORMASI PELAKSANAAN & TRANSPARANSI DATA -->
    <section id="informasi-resmi" class="py-14 sm:py-20 bg-concrete-50 border-b border-concrete-200" aria-labelledby="informasi-heading">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl mb-12">
                <span class="text-xs sm:text-sm font-bold uppercase tracking-wider text-emerald-700 bg-emerald-100 border border-emerald-300 px-3 py-1 rounded-full">
                    Transparansi Layanan
                </span>
                <h2 id="informasi-heading" class="mt-3 text-2xl sm:text-3xl font-extrabold text-navy-950 tracking-tight">
                    Informasi Penyelenggaraan &amp; Pelaksanaan
                </h2>
                <p class="mt-4 text-base text-concrete-600 leading-relaxed">
                    Kami berkomitmen menyajikan informasi faktual tanpa mengklaim jadwal fiktif atau biaya tanpa konfirmasi resmi. Seluruh rincian diverifikasi langsung melalui tim konsultan kami.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                <!-- Left: Verified Parameters Grid -->
                <div class="lg:col-span-7 space-y-4">
                    <div class="bg-white rounded-2xl border border-concrete-200 overflow-hidden shadow-sm divide-y divide-concrete-100">
                        @foreach ($program['training_info'] as $key => $info)
                            <div class="p-5 sm:p-6 flex flex-col sm:flex-row sm:items-start justify-between gap-3">
                                <div class="sm:w-1/3">
                                    <span class="text-xs font-bold uppercase tracking-wider text-concrete-500 block mb-1">
                                        {{ $info['label'] }}
                                    </span>
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold bg-navy-100 text-navy-900 border border-navy-200">
                                        {{ $info['status'] }}
                                    </span>
                                </div>
                                <div class="sm:w-2/3">
                                    <p class="text-sm text-concrete-700 leading-relaxed">
                                        {{ $info['detail'] }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Transparency Disclaimer Card -->
                    <div class="p-5 rounded-xl bg-concrete-100 border border-concrete-300 text-xs text-concrete-600 leading-relaxed space-y-2">
                        <div class="flex items-center gap-2 font-bold text-navy-950 text-sm">
                            <svg class="w-4 h-4 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span>Komitmen Keterbukaan Informasi Kami</span>
                        </div>
                        <p>
                            Kami tidak menampilkan estimasi biaya fiktif atau klaim akreditasi sepihak. Hubungi tim kami untuk mendapatkan penawaran tertulis formal sebelum registrasi.
                        </p>
                    </div>
                </div>

                <!-- Right: Competency Topics Preview & CTA Card -->
                <div class="lg:col-span-5 space-y-6">
                    <div class="bg-navy-950 text-white rounded-2xl border border-navy-800 p-6 sm:p-8 shadow-md">
                        <h3 class="text-lg font-bold text-white mb-2">
                            Pokok Materi &amp; Tahapan Kerja
                        </h3>
                        <p class="text-xs text-concrete-300 mb-5 leading-relaxed">
                            Cakupan materi dan tahapan teknis mengacu pada standar regulasi lingkungan yang berlaku:
                        </p>

                        <ul class="space-y-3 mb-6" role="list">
                            @foreach ($program['curriculum_topics'] as $topic)
                                <li class="flex items-start gap-2.5 text-xs sm:text-sm text-concrete-200">
                                    <svg class="w-4 h-4 text-emerald-400 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                    </svg>
                                    <span>{{ $topic }}</span>
                                </li>
                            @endforeach
                        </ul>

                        <div class="pt-5 border-t border-navy-800">
                            <x-wa-cta variant="primary" size="md" :message="$program['wa_message']" label="Minta Proposal Resmi via WhatsApp" class="w-full justify-center bg-emerald-600 hover:bg-emerald-500 text-white" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 4: LAYANAN TERKAIT LAINNYA -->
    @if(!empty($otherPrograms))
    <section id="program-lain" class="py-14 sm:py-20 bg-white border-b border-concrete-200" aria-labelledby="program-lain-heading">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-12">
                <span class="text-xs sm:text-sm font-bold uppercase tracking-wider text-emerald-700 bg-emerald-100 border border-emerald-300 px-3 py-1 rounded-full">
                    Layanan Terkait
                </span>
                <h2 id="program-lain-heading" class="mt-3 text-2xl sm:text-3xl font-extrabold text-navy-950 tracking-tight">
                    Layanan Lingkungan Terkait Lainnya
                </h2>
                <p class="mt-4 text-base text-concrete-600">
                    Bandingkan program pelatihan dan jasa konsultansi lainnya untuk memenuhi seluruh aspek kepatuhan lingkungan industri Anda.
                </p>
            </div>

            <!-- Other Programs Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach (array_slice($otherPrograms, 0, 3) as $other)
                    <div class="flex flex-col bg-concrete-50 rounded-2xl border border-concrete-200 p-6 hover:shadow-md transition-shadow">
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white border border-concrete-200 text-emerald-700 text-xs font-bold w-fit mb-4">
                            <span>{{ $other['level'] }}</span>
                        </div>
                        <h3 class="text-lg font-bold text-navy-950 mb-2">
                            {{ $other['title'] }}
                        </h3>
                        <p class="text-sm text-concrete-600 leading-relaxed mb-6 flex-1">
                            {{ Str::limit($other['introduction'], 120) }}
                        </p>
                        <div class="pt-4 border-t border-concrete-200">
                            <x-button :href="route('program.show', $other['slug'])" variant="secondary" size="sm" class="w-full justify-center">
                                Lihat Detail &rarr;
                            </x-button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <!-- SECTION 5: FAQ KHUSUS PROGRAM -->
    <section id="faq" class="py-14 sm:py-20 bg-concrete-50 border-b border-concrete-200" aria-labelledby="faq-heading">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-12">
                <span class="text-xs sm:text-sm font-bold uppercase tracking-wider text-emerald-700 bg-emerald-100 border border-emerald-300 px-3 py-1 rounded-full">
                    Tanya Jawab
                </span>
                <h2 id="faq-heading" class="mt-3 text-2xl sm:text-3xl font-extrabold text-navy-950 tracking-tight">
                    Pertanyaan Umum Seputar {{ $program['title'] }}
                </h2>
                <p class="mt-4 text-base text-concrete-600">
                    Jawaban faktual untuk pertanyaan yang sering diajukan mengenai layanan ini.
                </p>
            </div>

            <div class="space-y-4">
                @foreach ($program['faqs'] as $index => $faq)
                    <details class="group bg-white rounded-xl border border-concrete-200 p-5 sm:p-6 shadow-sm transition-all duration-150 open:border-emerald-500">
                        <summary class="flex items-center justify-between gap-4 font-bold text-navy-950 text-base sm:text-lg cursor-pointer list-none focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-500 rounded">
                            <span>{{ $faq['question'] }}</span>
                            <span class="w-7 h-7 rounded-full bg-concrete-100 flex items-center justify-center shrink-0 group-open:rotate-180 transition-transform duration-200 text-concrete-500">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                                </svg>
                            </span>
                        </summary>
                        <div class="mt-4 pt-4 border-t border-concrete-100 text-sm sm:text-base text-concrete-700 leading-relaxed">
                            {{ $faq['answer'] }}
                        </div>
                    </details>
                @endforeach
            </div>
        </div>
    </section>

    <!-- SECTION 6: FINAL CONVERSION & KONSULTASI -->
    <section id="konsultasi" class="py-16 sm:py-24 bg-navy-950 text-white relative overflow-hidden" aria-labelledby="konsultasi-heading">
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div class="max-w-3xl mx-auto">
                <span class="text-xs sm:text-sm font-bold uppercase tracking-wider text-emerald-400 bg-navy-900 border border-navy-800 px-3.5 py-1.5 rounded-full inline-block mb-6">
                    Layanan Konsultasi Responsif
                </span>
                <h2 id="konsultasi-heading" class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-white tracking-tight uppercase">
                    Konsultasikan Layanan <span class="text-emerald-400">{{ $program['title'] }}</span> Anda
                </h2>
                <p class="mt-4 text-base sm:text-lg text-concrete-300 leading-relaxed">
                    Dapatkan kejelasan jadwal pelaksanaan terdekat, review data teknis awal, dan penawaran proposal resmi dari konsultan kami.
                </p>

                <div class="mt-8 sm:mt-10 flex flex-col sm:flex-row items-center justify-center gap-4">
                    <x-wa-cta variant="primary" size="lg" :message="$program['wa_message']" label="Hubungi Tim Konsultan" class="w-full sm:w-auto shadow-lg bg-emerald-600 hover:bg-emerald-500 text-white" />
                    <x-button :href="route('home')" variant="outline" size="lg" class="w-full sm:w-auto text-white border-concrete-500 hover:bg-navy-900">
                        Kembali ke Beranda
                    </x-button>
                </div>
            </div>
        </div>
    </section>
@endsection
