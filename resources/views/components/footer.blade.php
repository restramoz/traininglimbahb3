<footer class="bg-navy-950 text-concrete-300 border-t border-navy-800" role="contentinfo" aria-label="Informasi Kaki Halaman">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-12 pb-24 sm:py-12 lg:py-16">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">
            <!-- Col 1: Identity -->
            <div class="space-y-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-navy-900 border border-navy-700 flex items-center justify-center text-emerald-400 shadow-inner">
                        <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                            <path d="M12 8c2.5 0 4 1.5 4 4 0 2-1.5 3.5-4 4-2.5-.5-4-2-4-4 0-2.5 1.5-4 4-4z"/>
                        </svg>
                    </div>
                    <span class="text-base font-bold text-white tracking-tight uppercase">
                        Training <span class="text-emerald-400">Limbah B3</span>
                    </span>
                </div>
                <p class="text-sm text-concrete-300 leading-relaxed">
                    Pusat layanan informasi bimbingan sertifikasi kompetensi lingkungan hidup dan jasa konsultansi pengelolaan limbah B3 berstandar regulasi nasional di seluruh Indonesia.
                </p>
                <div class="pt-1">
                    <x-wa-cta variant="wa" size="sm" label="Konsultasi WhatsApp" />
                </div>
            </div>

            <!-- Col 2: Training Programs -->
            <div class="space-y-4">
                <h3 class="text-xs font-bold text-white uppercase tracking-wider">
                    Sertifikasi &amp; Pelatihan
                </h3>
                <ul class="space-y-2 text-xs sm:text-sm" role="list">
                    <li>
                        <a href="{{ route('program.show', 'training-plb3') }}" class="hover:text-emerald-400 transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-500 rounded">
                            Training PLB3 (Penanggung Jawab B3)
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('program.show', 'training-olb3') }}" class="hover:text-emerald-400 transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-500 rounded">
                            Training OLB3 (Operator TPS B3)
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('program.show', 'training-pppa') }}" class="hover:text-emerald-400 transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-500 rounded">
                            Training PPPA (Pengendali Air Limbah)
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('program.show', 'training-ipal') }}" class="hover:text-emerald-400 transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-500 rounded">
                            Training IPAL (Operator WWTP)
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('program.show', 'training-pppu') }}" class="hover:text-emerald-400 transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-500 rounded">
                            Training PPPU (Pengendali Emisi Udara)
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('program.show', 'training-poippu') }}" class="hover:text-emerald-400 transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-500 rounded">
                            Training POIPPU (Operator Udara)
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('program.show', 'training-pcua') }}" class="hover:text-emerald-400 transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-500 rounded">
                            Training PCUA (Udara Ambien)
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Col 3: Consulting & Testing Services -->
            <div class="space-y-4">
                <h3 class="text-xs font-bold text-white uppercase tracking-wider">
                    Jasa Konsultansi &amp; Lab
                </h3>
                <ul class="space-y-2 text-xs sm:text-sm" role="list">
                    <li>
                        <a href="{{ route('program.show', 'jasa-uji-emisi-lingkungan') }}" class="hover:text-emerald-400 transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-500 rounded">
                            Jasa Uji Emisi Lingkungan (KAN)
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('program.show', 'jasa-ukl-upl') }}" class="hover:text-emerald-400 transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-500 rounded">
                            Jasa Penyusunan UKL-UPL
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('program.show', 'jasa-pertek-lingkungan') }}" class="hover:text-emerald-400 transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-500 rounded">
                            Jasa Pertek Lingkungan (Air &amp; Udara)
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('program.show', 'jasa-rintek-lingkungan') }}" class="hover:text-emerald-400 transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-500 rounded">
                            Jasa Rintek TPS Limbah B3
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('program.show', 'jasa-rkl-rpl-lingkungan') }}" class="hover:text-emerald-400 transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-500 rounded">
                            Jasa Laporan RKL-RPL Semesteran
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('program.show', 'jasa-transportasi-pengelolaan-limbah-b3') }}" class="hover:text-emerald-400 transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-500 rounded">
                            Transportasi &amp; Pengelolaan Limbah B3
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Col 4: Regulatory Commitment -->
            <div class="space-y-4">
                <h3 class="text-xs font-bold text-white uppercase tracking-wider">
                    Kepatuhan Regulasi
                </h3>
                <p class="text-xs text-concrete-300 leading-relaxed">
                    Mendukung industri memenuhi standar lingkungan hidup sesuai <span class="text-concrete-100 font-semibold">PP No. 22 Tahun 2021</span> dan <span class="text-concrete-100 font-semibold">Permen LHK No. 6 Tahun 2021</span> guna mencegah sanksi hukum dan meraih peringkat PROPER optimal.
                </p>
                <div class="flex items-center gap-2 text-xs text-concrete-300 pt-1">
                    <span class="inline-block w-2 h-2 rounded-full bg-emerald-400"></span>
                    <span>Konsultasi online responsif setiap hari kerja</span>
                </div>
            </div>
        </div>

        <!-- Bottom bar -->
        <div class="mt-12 pt-8 border-t border-navy-900 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-concrete-500">
            <p>
                &copy; {{ date('Y') }} Training Limbah B3. Seluruh hak cipta dilindungi.
            </p>
            <p class="text-concrete-500">
                Pusat Pelatihan &amp; Jasa Konsultansi Pengelolaan Lingkungan Hidup
            </p>
        </div>
    </div>
</footer>
