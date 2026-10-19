@extends('layouts.app')

@section('title', 'Layanan Pelatihan & Konsultasi Pengelolaan Limbah B3')
@section('meta_description', 'Portal resmi pelatihan sertifikasi kompetensi lingkungan (PPPA, IPAL, PLB3, POIPPU) dan jasa konsultansi lingkungan hidup (Uji Emisi, UKL-UPL, Pertek, Rintek TPS B3) di Indonesia.')

@section('content')
@php
    $regionalService = resolve(App\Services\RegionalService::class);
    $provinces = $regionalService->getAllProvinces();
    $allPrograms = config('programs', []);

    $trainings = collect($allPrograms)->filter(fn($p) => ($p['category'] ?? '') === 'training')->all();
    $services = collect($allPrograms)->filter(fn($p) => ($p['category'] ?? '') === 'service')->all();
@endphp

    <!-- HERO SECTION -->
    <section class="relative bg-navy-950 text-white overflow-hidden border-b border-navy-800" aria-labelledby="hero-heading">
        <!-- Subtle Environmental Leaf/Grid Pattern Accent -->
        <div class="absolute inset-0 opacity-10 pointer-events-none" aria-hidden="true">
            <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg">
                <defs>
                    <pattern id="grid-pattern" width="40" height="40" patternUnits="userSpaceOnUse">
                        <path d="M 40 0 L 0 0 0 40" fill="none" stroke="#FFFFFF" stroke-width="1" />
                    </pattern>
                </defs>
                <rect width="100%" height="100%" fill="url(#grid-pattern)" />
            </svg>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 sm:py-24 lg:py-28">
            <div class="max-w-3xl">
                <!-- Badge -->
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-navy-900 border border-emerald-500/40 text-emerald-400 text-xs sm:text-sm font-semibold mb-6 shadow-inner">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    Kepatuhan Regulasi PP No. 22/2021 &amp; Permen LHK No. 6/2021
                </div>

                <!-- Main Heading -->
                <h1 id="hero-heading" class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight text-white leading-tight uppercase">
                    Kepatuhan Lingkungan &amp; <span class="text-emerald-400">Pengelolaan Limbah B3</span>
                </h1>

                <!-- Subheading -->
                <p class="mt-6 text-base sm:text-lg lg:text-xl text-concrete-300 leading-relaxed">
                    Tingkatkan kompetensi personil industri Anda melalui sertifikasi profesi resmi dan pastikan kepatuhan perizinan lingkungan terintegrasi dari hulu hingga hilir.
                </p>

                <!-- Actions -->
                <div class="mt-8 sm:mt-10 flex flex-col sm:flex-row items-stretch sm:items-center gap-4">
                    <x-wa-cta variant="primary" size="lg" label="Konsultasi Program via WhatsApp" class="shadow-md bg-emerald-600 hover:bg-emerald-500 text-white" />
                    <x-button href="#pelatihan" variant="outline" size="lg" class="text-white border-concrete-500 hover:bg-navy-900">
                        Lihat 13 Layanan Lengkap
                    </x-button>
                </div>

                <!-- Value Highlights Grid -->
                <div class="mt-12 pt-8 border-t border-navy-800/80 grid grid-cols-2 sm:grid-cols-4 gap-6">
                    <div>
                        <div class="text-2xl sm:text-3xl font-extrabold text-emerald-400">7 Pelatihan</div>
                        <div class="text-xs sm:text-sm text-concrete-300 mt-1 font-medium">PPPA, IPAL, PLB3, POIPPU</div>
                    </div>
                    <div>
                        <div class="text-2xl sm:text-3xl font-extrabold text-white">6 Jasa Lab</div>
                        <div class="text-xs sm:text-sm text-concrete-300 mt-1 font-medium">Uji Emisi, UKL-UPL, Pertek</div>
                    </div>
                    <div>
                        <div class="text-2xl sm:text-3xl font-extrabold text-emerald-400">KAN / BNSP</div>
                        <div class="text-xs sm:text-sm text-concrete-300 mt-1 font-medium">Standar Regulasi KLHK</div>
                    </div>
                    <div>
                        <div class="text-2xl sm:text-3xl font-extrabold text-white">Nasional</div>
                        <div class="text-xs sm:text-sm text-concrete-300 mt-1 font-medium">Layanan 38 Provinsi</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SECTION 1: SERTIFIKASI & PELATIHAN (7 PROGRAMS) -->
    <section id="pelatihan" class="py-16 sm:py-24 bg-concrete-50" aria-labelledby="pelatihan-heading">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-14">
                <span class="text-xs sm:text-sm font-bold uppercase tracking-wider text-emerald-700 bg-emerald-100 px-3 py-1 rounded-full border border-emerald-300">
                    Sertifikasi &amp; Pelatihan
                </span>
                <h2 id="pelatihan-heading" class="mt-3 text-2xl sm:text-3xl lg:text-4xl font-extrabold text-navy-950 tracking-tight">
                    7 Program Pelatihan Kompetensi Lingkungan Hidup
                </h2>
                <p class="mt-4 text-base text-concrete-600">
                    Program pembinaan teknis dan persiapan uji kompetensi profesi BNSP bidang lingkungan hidup dan limbah B3.
                </p>
            </div>

            <!-- Training Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 items-stretch">
                @foreach($trainings as $slug => $item)
                    <div class="flex flex-col bg-white rounded-xl border border-concrete-200 shadow-sm hover:shadow-md transition-shadow overflow-hidden group">
                        <div class="h-2 bg-emerald-600"></div>
                        <div class="p-6 sm:p-7 flex-1 flex flex-col">
                            <div class="flex items-center justify-between text-xs font-bold uppercase tracking-wider text-emerald-700 mb-2">
                                <span>{{ $item['level'] }}</span>
                                <span class="text-[10px] bg-concrete-100 text-concrete-600 px-2 py-0.5 rounded">SKKNI</span>
                            </div>
                            <h3 class="text-xl font-bold text-navy-950 mb-3 group-hover:text-emerald-700 transition-colors">
                                {{ $item['title'] }}
                            </h3>
                            <p class="text-sm text-concrete-600 leading-relaxed mb-6">
                                {{ Str::limit($item['introduction'], 140) }}
                            </p>
                            
                            <div class="mt-auto pt-4 border-t border-concrete-100 space-y-2 mb-6">
                                <div class="text-xs font-semibold text-navy-900 uppercase tracking-wider">Cakupan Materi Utama:</div>
                                <ul class="text-xs text-concrete-700 space-y-1.5" role="list">
                                    @foreach(array_slice($item['curriculum_topics'], 0, 3) as $topic)
                                        <li class="flex items-start gap-2">
                                            <svg class="w-4 h-4 text-emerald-600 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                            <span>{{ Str::limit($topic, 50) }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                            <div class="space-y-2.5">
                                <x-wa-cta variant="secondary" size="md" :message="$item['wa_message']" :label="'Konsultasi ' . explode('(', $item['title'])[0]" class="w-full justify-center" />
                                <a href="{{ route('program.show', $slug) }}" class="inline-flex items-center justify-center w-full text-xs font-bold text-navy-900 hover:text-emerald-700 transition-colors py-1 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-500 rounded">
                                    Detail Silabus &amp; Persyaratan &rarr;
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- SECTION 2: JASA KONSULTANSI & PENGUJIAN (6 SERVICES) -->
    <section id="jasa" class="py-16 sm:py-24 bg-white border-t border-concrete-200" aria-labelledby="jasa-heading">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-14">
                <span class="text-xs sm:text-sm font-bold uppercase tracking-wider text-emerald-700 bg-emerald-100 px-3 py-1 rounded-full border border-emerald-300">
                    Layanan Konsultansi &amp; Lab
                </span>
                <h2 id="jasa-heading" class="mt-3 text-2xl sm:text-3xl lg:text-4xl font-extrabold text-navy-950 tracking-tight">
                    6 Jasa Konsultansi &amp; Pengujian Lingkungan Hidup
                </h2>
                <p class="mt-4 text-base text-concrete-600">
                    Layanan pengurusan izin teknis lingkungan, uji laboratorium terakreditasi KAN, dan pengangkutan limbah B3 berizin resmi.
                </p>
            </div>

            <!-- Service Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 items-stretch">
                @foreach($services as $slug => $item)
                    <div class="flex flex-col bg-concrete-50 rounded-xl border border-concrete-200 shadow-sm hover:shadow-md transition-shadow overflow-hidden group">
                        <div class="h-2 bg-navy-900"></div>
                        <div class="p-6 sm:p-7 flex-1 flex flex-col">
                            <div class="text-xs font-bold uppercase tracking-wider text-navy-700 mb-2">
                                {{ $item['level'] }}
                            </div>
                            <h3 class="text-xl font-bold text-navy-950 mb-3 group-hover:text-emerald-700 transition-colors">
                                {{ $item['title'] }}
                            </h3>
                            <p class="text-sm text-concrete-600 leading-relaxed mb-6">
                                {{ Str::limit($item['introduction'], 140) }}
                            </p>
                            
                            <div class="mt-auto pt-4 border-t border-concrete-200 space-y-2 mb-6">
                                <div class="text-xs font-semibold text-navy-900 uppercase tracking-wider">Ruang Lingkup Kerja:</div>
                                <ul class="text-xs text-concrete-700 space-y-1.5" role="list">
                                    @foreach(array_slice($item['roles_and_responsibilities'], 0, 3) as $deliverable)
                                        <li class="flex items-start gap-2">
                                            <svg class="w-4 h-4 text-emerald-600 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4"/></svg>
                                            <span>{{ $deliverable['title'] }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>

                            <div class="space-y-2.5">
                                <x-wa-cta variant="primary" size="md" :message="$item['wa_message']" label="Minta Proposal Penawaran" class="w-full justify-center" />
                                <a href="{{ route('program.show', $slug) }}" class="inline-flex items-center justify-center w-full text-xs font-bold text-navy-900 hover:text-emerald-700 transition-colors py-1 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-500 rounded">
                                    Lihat Detail Layanan &rarr;
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- KEUNGGULAN SECTION -->
    <section id="keunggulan" class="py-16 sm:py-24 bg-concrete-100 border-t border-concrete-200" aria-labelledby="keunggulan-heading">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-14">
                <span class="text-xs sm:text-sm font-bold uppercase tracking-wider text-emerald-700 bg-emerald-100 px-3 py-1 rounded-full border border-emerald-300">
                    Mengapa Memilih Kami
                </span>
                <h2 id="keunggulan-heading" class="mt-3 text-2xl sm:text-3xl lg:text-4xl font-extrabold text-navy-950 tracking-tight">
                    Keunggulan Layanan Training &amp; Konsultansi Limbah B3
                </h2>
                <p class="mt-4 text-base text-concrete-600">
                    Kombinasi legalitas izin resmi, laboratorium uji terakreditasi KAN, dan instruktur berpengalaman di bidang tata kelola lingkungan industri.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Pillar 1 -->
                <div class="p-6 rounded-xl bg-white border border-concrete-200 shadow-sm">
                    <div class="w-12 h-12 rounded-lg bg-navy-950 text-emerald-400 flex items-center justify-center mb-5">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>
                    <h3 class="text-base font-bold text-navy-950 mb-2">Regulasi Resmi KLHK</h3>
                    <p class="text-sm text-concrete-600 leading-relaxed">
                        Seluruh kurikulum dan dokumen teknis mengacu pada PP 22/2021, Permen LHK 6/2021, dan standar kompetensi BNSP.
                    </p>
                </div>

                <!-- Pillar 2 -->
                <div class="p-6 rounded-xl bg-white border border-concrete-200 shadow-sm">
                    <div class="w-12 h-12 rounded-lg bg-navy-950 text-emerald-400 flex items-center justify-center mb-5">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                        </svg>
                    </div>
                    <h3 class="text-base font-bold text-navy-950 mb-2">Laboratorium Terakreditasi KAN</h3>
                    <p class="text-sm text-concrete-600 leading-relaxed">
                        Hasil uji emisi cerobong, air limbah, dan udara ambien sah dan diakui untuk pelaporan SIMPEL KLHK.
                    </p>
                </div>

                <!-- Pillar 3 -->
                <div class="p-6 rounded-xl bg-white border border-concrete-200 shadow-sm">
                    <div class="w-12 h-12 rounded-lg bg-navy-950 text-emerald-400 flex items-center justify-center mb-5">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-base font-bold text-navy-950 mb-2">Manifes Digital FESTRONIK</h3>
                    <p class="text-sm text-concrete-600 leading-relaxed">
                        Layanan transportasi limbah B3 terintegrasi sistem manifes elektronik resmi KLHK dengan sertifikat pemusnahan (CoD).
                    </p>
                </div>

                <!-- Pillar 4 -->
                <div class="p-6 rounded-xl bg-white border border-concrete-200 shadow-sm">
                    <div class="w-12 h-12 rounded-lg bg-navy-950 text-emerald-400 flex items-center justify-center mb-5">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" />
                        </svg>
                    </div>
                    <h3 class="text-base font-bold text-navy-950 mb-2">Pendampingan Sampai Tuntas</h3>
                    <p class="text-sm text-concrete-600 leading-relaxed">
                        Asistensi penyusunan dokumen hingga sidang teknis dinas lingkungan hidup dan terbitnya persetujuan resmi.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ SECTION -->
    <section id="faq" class="py-16 sm:py-24 bg-white border-t border-concrete-200" aria-labelledby="faq-heading">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <span class="text-xs sm:text-sm font-bold uppercase tracking-wider text-emerald-700 bg-emerald-100 px-3 py-1 rounded-full border border-emerald-300">
                    Tanya Jawab
                </span>
                <h2 id="faq-heading" class="mt-3 text-2xl sm:text-3xl font-extrabold text-navy-950 tracking-tight">
                    Pertanyaan yang Sering Diajukan
                </h2>
                <p class="mt-3 text-sm sm:text-base text-concrete-600">
                    Seputar pelatihan sertifikasi lingkungan dan jasa perizinan pengelolaan limbah B3.
                </p>
            </div>

            <div class="space-y-4">
                <details class="group bg-concrete-50 rounded-lg border border-concrete-200 p-5 open:ring-1 open:ring-navy-900 transition-all">
                    <summary class="font-bold text-navy-950 cursor-pointer list-none flex items-center justify-between focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-500 rounded">
                        <span>Apakah setiap industri penghasil limbah B3 wajib memiliki personel bersertifikat PLB3?</span>
                        <svg class="w-5 h-5 text-concrete-500 group-open:rotate-180 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </summary>
                    <p class="mt-3 text-sm text-concrete-600 leading-relaxed">
                        Berdasarkan Permen LHK No. P.06/2018 dan ketentuan PP No. 22/2021, penanggung jawab usaha dan/atau kegiatan yang menghasilkan limbah B3 wajib menunjuk personel yang memiliki sertifikat kompetensi Penanggung Jawab Pengelolaan Limbah B3 (PLB3) untuk menjamin pemenuhan standar penyimpanan dan pelaporan.
                    </p>
                </details>

                <details class="group bg-concrete-50 rounded-lg border border-concrete-200 p-5 open:ring-1 open:ring-navy-900 transition-all">
                    <summary class="font-bold text-navy-950 cursor-pointer list-none flex items-center justify-between focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-500 rounded">
                        <span>Apa perbedaan izin TPS Limbah B3 lama dengan Rincian Teknis (Rintek) saat ini?</span>
                        <svg class="w-5 h-5 text-concrete-500 group-open:rotate-180 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </summary>
                    <p class="mt-3 text-sm text-concrete-600 leading-relaxed">
                        Di bawah PP No. 22/2021, izin TPS B3 tidak lagi berdiri sendiri sebagai izin terpisah, melainkan bertransformasi menjadi dokumen Rincian Teknis (Rintek) yang diintegrasikan langsung ke dalam Persetujuan Lingkungan perusahaan (AMDAL atau UKL-UPL).
                    </p>
                </details>

                <details class="group bg-concrete-50 rounded-lg border border-concrete-200 p-5 open:ring-1 open:ring-navy-900 transition-all">
                    <summary class="font-bold text-navy-950 cursor-pointer list-none flex items-center justify-between focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-500 rounded">
                        <span>Berapa periode wajib pengujian emisi cerobong dan air limbah?</span>
                        <svg class="w-5 h-5 text-concrete-500 group-open:rotate-180 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </summary>
                    <p class="mt-3 text-sm text-concrete-600 leading-relaxed">
                        Pengujian emisi cerobong (genset, boiler, proses) umumnya dilakukan setiap 6 bulan sekali (semesteran), sedangkan pengujian efluen air limbah industri ke badan air umumnya dilakukan setiap bulan atau triwulanan sesuai matriks RKL-RPL dan Persetujuan Teknis (Pertek) yang berlaku.
                    </p>
                </details>

                <details class="group bg-concrete-50 rounded-lg border border-concrete-200 p-5 open:ring-1 open:ring-navy-900 transition-all">
                    <summary class="font-bold text-navy-950 cursor-pointer list-none flex items-center justify-between focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-500 rounded">
                        <span>Bagaimana legalitas penyerahan limbah B3 kepada pihak ketiga?</span>
                        <svg class="w-5 h-5 text-concrete-500 group-open:rotate-180 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </summary>
                    <p class="mt-3 text-sm text-concrete-600 leading-relaxed">
                        Pengangkutan limbah B3 wajib menggunakan transporter yang memiliki izin Ditjen Perhubungan Darat dan rekomendasi KLHK. Setiap pengangkutan wajib disertai bukti manifes elektronik FESTRONIK yang tercatat resmi di Kementerian Lingkungan Hidup dan Kehutanan.
                    </p>
                </details>
            </div>
        </div>
    </section>

    <!-- FINAL CTA BANNER -->
    <section id="kontak" class="bg-navy-950 text-white py-16 sm:py-20 border-t border-navy-800 relative overflow-hidden" aria-labelledby="cta-heading">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <span class="inline-block px-3 py-1 text-xs font-bold uppercase tracking-wider text-emerald-400 bg-navy-900 rounded-full border border-navy-700 mb-4">
                Konsultasi &amp; Penawaran Layanan
            </span>
            <h2 id="cta-heading" class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-white tracking-tight uppercase">
                Pastikan Kepatuhan Lingkungan Industri Anda Hari Ini
            </h2>
            <p class="mt-4 text-base sm:text-lg text-concrete-300 max-w-2xl mx-auto leading-relaxed">
                Hubungi tim konsultan kami via WhatsApp untuk konsultasi jadwal batch pelatihan, penawaran uji laboratorium, atau pendampingan izin lingkungan.
            </p>
            <div class="mt-8 flex flex-col sm:flex-row items-center justify-center gap-4">
                <x-wa-cta variant="primary" size="lg" label="Konsultasi via WhatsApp Sekarang" class="shadow-lg bg-emerald-600 hover:bg-emerald-500 text-white" />
            </div>
        </div>
    </section>

    <!-- REGION DIRECTORY SECTION -->
    <section id="wilayah" class="py-14 bg-concrete-50 border-t border-concrete-200" aria-label="Jelajahi Wilayah">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <span class="text-xs font-bold uppercase tracking-wider text-emerald-700 bg-emerald-100 px-3 py-1 rounded-full border border-emerald-300">
                    Jangkauan Wilayah
                </span>
                <h2 class="text-2xl font-extrabold text-navy-950 mt-2">Layanan Pengelolaan Lingkungan di 38 Provinsi</h2>
                <p class="text-sm text-concrete-600 mt-1">Kami melayani pelatihan publik daring dan bimbingan teknis on-site di seluruh Indonesia.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach($provinces as $prov)
                    <a href="{{ route('regional.province', $prov['slug']) }}" class="block p-4 bg-white rounded-lg border border-concrete-200 hover:border-emerald-500 hover:shadow-sm transition group">
                        <div class="flex items-center justify-between">
                            <span class="font-bold text-sm text-navy-950 group-hover:text-emerald-700 transition-colors">{{ $prov['name'] }}</span>
                            @if(!empty($prov['total_cities']))
                                <span class="text-[11px] text-concrete-500 bg-concrete-100 px-2 py-0.5 rounded">{{ $prov['total_cities'] }} Kab/Kota</span>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
@endsection
