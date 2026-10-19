<?php

namespace Tests\Feature;

use Tests\TestCase;

class ProgramPagesTest extends TestCase
{
    /**
     * Test that all 13 services and training programs render successfully.
     */
    public function test_all_thirteen_services_render_successfully(): void
    {
        $programs = config('programs', []);
        $this->assertCount(13, $programs, 'There must be exactly 13 approved services.');

        foreach ($programs as $slug => $data) {
            $url = route('program.show', $slug);
            $response = $this->get($url);

            $response->assertStatus(200);
            $response->assertSee($data['hero_heading']);
            $response->assertSee($data['hero_highlight']);
        }
    }

    /**
     * Test canonical and legacy route aliases for programs.
     */
    public function test_program_routes_have_expected_url_paths(): void
    {
        $this->assertEquals('/layanan/training-plb3', parse_url(route('program.show', 'training-plb3'), PHP_URL_PATH));
        $this->assertEquals('/program/training-plb3', parse_url(route('program.legacy.show', 'training-plb3'), PHP_URL_PATH));

        // Legacy route returns 200
        $response = $this->get('/program/training-plb3');
        $response->assertStatus(200);
        $response->assertSee('Training PLB3');
    }

    /**
     * Test distinct meta titles and meta descriptions for services.
     */
    public function test_each_program_has_distinct_page_title_and_meta_description(): void
    {
        $plb3 = $this->get(route('program.show', 'training-plb3'));
        $pppa = $this->get(route('program.show', 'training-pppa'));
        $emisi = $this->get(route('program.show', 'jasa-uji-emisi-lingkungan'));

        $plb3->assertStatus(200);
        $pppa->assertStatus(200);
        $emisi->assertStatus(200);

        $plb3Config = config('programs.training-plb3');
        $pppaConfig = config('programs.training-pppa');
        $emisiConfig = config('programs.jasa-uji-emisi-lingkungan');

        $plb3->assertSee($plb3Config['meta_title']);
        $pppa->assertSee($pppaConfig['meta_title']);
        $emisi->assertSee($emisiConfig['meta_title']);

        $this->assertNotEquals($plb3Config['meta_description'], $pppaConfig['meta_description']);
        $this->assertNotEquals($pppaConfig['meta_description'], $emisiConfig['meta_description']);
    }

    /**
     * Test accessible breadcrumb markup on program detail page.
     */
    public function test_program_pages_include_accessible_breadcrumbs(): void
    {
        $response = $this->get(route('program.show', 'training-plb3'));

        $response->assertStatus(200);
        $response->assertSee('aria-label="Breadcrumb"', false);
        $response->assertSee('itemtype="https://schema.org/BreadcrumbList"', false);
        $response->assertSee('href="' . route('home') . '"', false);
        $response->assertSee('Beranda', false);
        $response->assertSee('aria-current="page"', false);
    }

    /**
     * Test information card sections.
     */
    public function test_program_pages_display_transparent_unverified_info_notice(): void
    {
        $response = $this->get(route('program.show', 'training-plb3'));

        $response->assertStatus(200);
        $response->assertSee('Informasi Penyelenggaraan &amp; Pelaksanaan', false);
        $response->assertSee('Jadwal Pelatihan');
        $response->assertSee('Durasi Program');
        $response->assertSee('Investasi Biaya');
    }

    /**
     * Test WhatsApp CTA formatting and prefilled message.
     */
    public function test_whatsapp_cta_prefills_specific_program_message(): void
    {
        config(['services.whatsapp.phone' => '089988776655']);

        $plb3 = $this->get(route('program.show', 'training-plb3'));
        $plb3->assertStatus(200);
        $expectedMsg = rawurlencode(config('programs.training-plb3.wa_message'));
        $plb3->assertSee('https://wa.me/6289988776655?text=' . $expectedMsg, false);
    }

    /**
     * Test fallback when phone is empty.
     */
    public function test_whatsapp_cta_falls_back_when_phone_is_empty(): void
    {
        config(['services.whatsapp.phone' => '']);

        $response = $this->get(route('program.show', 'training-plb3'));
        $response->assertStatus(200);

        $expectedText = rawurlencode(config('programs.training-plb3.wa_message'));
        $response->assertSee('https://wa.me/?text=' . $expectedText, false);
    }

    /**
     * Test related services links on detail page.
     */
    public function test_each_program_page_links_to_other_programs(): void
    {
        $response = $this->get(route('program.show', 'training-plb3'));
        $response->assertStatus(200);
        $response->assertSee(route('program.show', 'training-pppa'), false);
    }

    /**
     * Test responsive FAQ accordion on service pages.
     */
    public function test_program_pages_have_responsive_faq_section(): void
    {
        $response = $this->get(route('program.show', 'training-plb3'));

        $response->assertStatus(200);
        $response->assertSee('<details', false);
        $response->assertSee('<summary', false);
        $response->assertSee('Pertanyaan Umum Seputar');
    }

    /**
     * Test safety rule: no P3K contamination or fabricated claims.
     */
    public function test_program_pages_have_no_p3k_or_invented_claims(): void
    {
        foreach (['training-plb3', 'training-pppa', 'jasa-uji-emisi-lingkungan'] as $slug) {
            $response = $this->get(route('program.show', $slug));
            $response->assertStatus(200);

            $response->assertDontSee('Pelatihan P3K');
            $response->assertDontSee('Kotak P3K');
            $response->assertDontSee('100% garansi lulus');
            $response->assertDontSee('pasti lulus');
            $response->assertDontSee('tanpa tes');
        }
    }

    /**
     * Test homepage and footer link to programs.
     */
    public function test_homepage_and_footer_link_to_programs(): void
    {
        $home = $this->get(route('home'));

        $home->assertStatus(200);
        $home->assertSee(route('program.show', 'training-plb3'), false);
        $home->assertSee(route('program.show', 'training-pppa'), false);
        $home->assertSee(route('program.show', 'jasa-uji-emisi-lingkungan'), false);
    }
}
