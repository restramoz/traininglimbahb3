<header class="sticky top-0 z-30 bg-navy-950/95 backdrop-blur-md border-b border-navy-800/80 shadow-md">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-20">
            <!-- Brand Logo -->
            <a href="{{ route('home') }}" class="group flex items-center gap-3.5 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-500 focus-visible:ring-offset-2 focus-visible:ring-offset-navy-950 rounded-lg p-1 transition-transform" aria-label="Training Limbah B3 - Beranda">
                <div class="w-11 h-11 rounded-lg bg-navy-900 border border-navy-700/80 flex items-center justify-center text-emerald-400 shadow-inner group-hover:border-emerald-500 transition-colors">
                    <!-- Environmental Leaf & Shield SVG -->
                    <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                        <path d="M12 8c2.5 0 4 1.5 4 4 0 2-1.5 3.5-4 4-2.5-.5-4-2-4-4 0-2.5 1.5-4 4-4z"/>
                    </svg>
                </div>
                <div class="flex flex-col">
                    <span class="text-base sm:text-lg font-bold tracking-tight text-white group-hover:text-emerald-400 transition-colors uppercase">
                        Training <span class="text-emerald-400">Limbah B3</span>
                    </span>
                    <span class="text-xs text-concrete-300 font-medium tracking-wide">
                        Kepatuhan Lingkungan Hidup Nasional
                    </span>
                </div>
            </a>

            <!-- Desktop Navigation -->
            <nav class="hidden lg:flex items-center gap-7" role="navigation" aria-label="Navigasi Utama Desktop">
                <a href="{{ route('home') }}#pelatihan" class="text-sm font-semibold text-concrete-200 hover:text-emerald-400 transition-colors py-1 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-500 rounded">
                    Sertifikasi &amp; Pelatihan
                </a>
                <a href="{{ route('home') }}#jasa" class="text-sm font-semibold text-concrete-200 hover:text-emerald-400 transition-colors py-1 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-500 rounded">
                    Jasa Lingkungan
                </a>
                <a href="{{ route('home') }}#keunggulan" class="text-sm font-semibold text-concrete-200 hover:text-emerald-400 transition-colors py-1 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-500 rounded">
                    Keunggulan
                </a>
                <a href="{{ route('home') }}#faq" class="text-sm font-semibold text-concrete-200 hover:text-emerald-400 transition-colors py-1 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-500 rounded">
                    FAQ
                </a>
                <a href="{{ route('articles.index') }}" class="text-sm font-semibold text-concrete-200 hover:text-emerald-400 transition-colors py-1 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-500 rounded">
                    Artikel
                </a>
                <a href="{{ route('home') }}#wilayah" class="text-sm font-semibold text-concrete-200 hover:text-emerald-400 transition-colors py-1 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-500 rounded">
                    Wilayah
                </a>
            </nav>

            <!-- CTA Actions (Desktop) -->
            <div class="hidden sm:flex items-center gap-3">
                <x-wa-cta variant="primary" size="sm" label="Konsultasi WhatsApp" />
            </div>

            <!-- Mobile Menu Toggle Button -->
            <div class="flex lg:hidden items-center gap-2">
                <button type="button"
                        id="mobile-nav-toggle"
                        aria-controls="mobile-nav-drawer"
                        aria-expanded="false"
                        aria-label="Buka menu navigasi utama"
                        class="p-2.5 rounded-lg text-concrete-200 hover:text-white hover:bg-navy-900 border border-navy-800 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-500">
                    <!-- Icon Hamburger -->
                    <svg id="icon-menu-open" class="w-6 h-6 block" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <!-- Icon Close -->
                    <svg id="icon-menu-close" class="w-6 h-6 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Navigation Drawer -->
    <div id="mobile-nav-drawer"
         class="hidden lg:hidden bg-navy-950 border-b border-navy-800 px-4 pt-2 pb-6 transition-all"
         role="navigation"
         aria-label="Navigasi Utama Seluler">
        <div class="flex flex-col space-y-3 pt-2">
            <a href="{{ route('home') }}#pelatihan" class="mobile-nav-link text-base font-semibold text-concrete-200 hover:text-emerald-400 hover:bg-navy-900 px-3 py-2.5 rounded-md focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-500">
                Sertifikasi &amp; Pelatihan
            </a>
            <a href="{{ route('home') }}#jasa" class="mobile-nav-link text-base font-semibold text-concrete-200 hover:text-emerald-400 hover:bg-navy-900 px-3 py-2.5 rounded-md focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-500">
                Jasa Lingkungan
            </a>
            <a href="{{ route('home') }}#keunggulan" class="mobile-nav-link text-base font-semibold text-concrete-200 hover:text-emerald-400 hover:bg-navy-900 px-3 py-2.5 rounded-md focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-500">
                Keunggulan
            </a>
            <a href="{{ route('home') }}#faq" class="mobile-nav-link text-base font-semibold text-concrete-200 hover:text-emerald-400 hover:bg-navy-900 px-3 py-2.5 rounded-md focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-500">
                FAQ
            </a>
            <a href="{{ route('articles.index') }}" class="mobile-nav-link text-base font-semibold text-concrete-200 hover:text-emerald-400 hover:bg-navy-900 px-3 py-2.5 rounded-md focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-500">
                Artikel
            </a>
            <a href="{{ route('home') }}#wilayah" class="mobile-nav-link text-base font-semibold text-concrete-200 hover:text-emerald-400 hover:bg-navy-900 px-3 py-2.5 rounded-md focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-emerald-500">
                Wilayah
            </a>
            <div class="pt-3 border-t border-navy-800">
                <x-wa-cta variant="primary" size="md" class="w-full justify-center" label="Konsultasi Cepat via WhatsApp" />
            </div>
        </div>
    </div>
</header>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggleBtn = document.getElementById('mobile-nav-toggle');
        const drawer = document.getElementById('mobile-nav-drawer');
        const openIcon = document.getElementById('icon-menu-open');
        const closeIcon = document.getElementById('icon-menu-close');
        const mobileLinks = document.querySelectorAll('.mobile-nav-link');

        if (toggleBtn && drawer) {
            toggleBtn.addEventListener('click', function () {
                const isExpanded = toggleBtn.getAttribute('aria-expanded') === 'true';
                toggleBtn.setAttribute('aria-expanded', !isExpanded);
                drawer.classList.toggle('hidden');
                openIcon.classList.toggle('hidden');
                closeIcon.classList.toggle('hidden');
                toggleBtn.setAttribute('aria-label', isExpanded ? 'Buka menu navigasi utama' : 'Tutup menu navigasi utama');
            });

            mobileLinks.forEach(function (link) {
                link.addEventListener('click', function () {
                    drawer.classList.add('hidden');
                    openIcon.classList.remove('hidden');
                    closeIcon.classList.add('hidden');
                    toggleBtn.setAttribute('aria-expanded', 'false');
                });
            });
        }
    });
</script>
