<?php

namespace Tests\Feature;

use Tests\TestCase;

class WhatsAppConversionFlowTest extends TestCase
{
    public function test_homepage_ctas_use_configured_phone_and_default_message(): void
    {
        config(['services.whatsapp.phone' => '081299887766']);
        config(['services.whatsapp.default_message' => 'Halo, saya ingin konsultasi mengenai Pelatihan & Layanan Pengelolaan Limbah B3 dan Lingkungan Hidup.']);

        $response = $this->get('/');
        $response->assertStatus(200);

        $expectedUrl = 'https://wa.me/6281299887766?text=' . rawurlencode('Halo, saya ingin konsultasi mengenai Pelatihan & Layanan Pengelolaan Limbah B3 dan Lingkungan Hidup.');

        // Hero CTA, Header CTA, Footer CTA, and Floating CTA should all include this URL
        $response->assertSee($expectedUrl, false);
    }

    public function test_homepage_ctas_fallback_gracefully_when_phone_is_missing(): void
    {
        config(['services.whatsapp.phone' => '']);
        config(['services.whatsapp.default_message' => 'Halo, saya ingin konsultasi mengenai Pelatihan & Layanan Pengelolaan Limbah B3 dan Lingkungan Hidup.']);

        $response = $this->get('/');
        $response->assertStatus(200);

        $expectedFallbackUrl = 'https://wa.me/?text=' . rawurlencode('Halo, saya ingin konsultasi mengenai Pelatihan & Layanan Pengelolaan Limbah B3 dan Lingkungan Hidup.');
        $response->assertSee($expectedFallbackUrl, false);

        // Ensure no broken numbers like https://wa.me/62? or https://wa.me/? are emitted
        $response->assertDontSee('https://wa.me/62?', false);
    }

    public function test_homepage_ctas_fallback_gracefully_when_phone_is_invalid(): void
    {
        // Unparseable / invalid short digits
        config(['services.whatsapp.phone' => 'invalid-abc']);
        config(['services.whatsapp.default_message' => 'Halo, saya ingin konsultasi mengenai Pelatihan & Layanan Pengelolaan Limbah B3 dan Lingkungan Hidup.']);

        $response = $this->get('/');
        $response->assertStatus(200);

        $expectedFallbackUrl = 'https://wa.me/?text=' . rawurlencode('Halo, saya ingin konsultasi mengenai Pelatihan & Layanan Pengelolaan Limbah B3 dan Lingkungan Hidup.');
        $response->assertSee($expectedFallbackUrl, false);

        // Test too-short digits (e.g. "123")
        config(['services.whatsapp.phone' => '123']);
        $responseShort = $this->get('/');
        $responseShort->assertStatus(200);
        $responseShort->assertSee($expectedFallbackUrl, false);
        $responseShort->assertDontSee('https://wa.me/123?', false);
    }

    public function test_all_program_cards_on_homepage_produce_program_specific_messages(): void
    {
        config(['services.whatsapp.phone' => '081299887766']);

        $response = $this->get('/');
        $response->assertStatus(200);

        $mudaMessage = rawurlencode('Halo, saya ingin konsultasi mengenai jadwal, biaya, dan persyaratan Training PPPA (Penanggung Jawab Pengendalian Pencemaran Air).');
        $madyaMessage = rawurlencode('Halo, saya ingin konsultasi mengenai jadwal, biaya, dan materi Training Operasional IPAL.');
        $utamaMessage = rawurlencode('Halo, saya ingin konsultasi mengenai jadwal dan syarat pendaftaran Training Sertifikasi PLB3 (Penanggung Jawab Pengelolaan Limbah B3).');

        $response->assertSee('https://wa.me/6281299887766?text=' . $mudaMessage, false);
        $response->assertSee('https://wa.me/6281299887766?text=' . $madyaMessage, false);
        $response->assertSee('https://wa.me/6281299887766?text=' . $utamaMessage, false);
    }

    public function test_program_pages_produce_contextual_messages_across_all_page_ctas(): void
    {
        config(['services.whatsapp.phone' => '085544332211']);

        $programs = [
            [
                'route' => 'program.show',
                'slug' => 'training-plb3',
                'message' => 'Halo, saya ingin konsultasi mengenai jadwal dan syarat pendaftaran Training Sertifikasi PLB3 (Penanggung Jawab Pengelolaan Limbah B3).'
            ],
            [
                'route' => 'program.show',
                'slug' => 'training-pppa',
                'message' => 'Halo, saya ingin konsultasi mengenai jadwal, biaya, dan persyaratan Training PPPA (Penanggung Jawab Pengendalian Pencemaran Air).'
            ],
            [
                'route' => 'program.show',
                'slug' => 'training-ipal',
                'message' => 'Halo, saya ingin konsultasi mengenai jadwal, biaya, dan materi Training Operasional IPAL.'
            ],
        ];

        foreach ($programs as $program) {
            $response = $this->get(route($program['route'], $program['slug']));
            $response->assertStatus(200);

            $encoded = rawurlencode($program['message']);
            $expectedUrl = 'https://wa.me/6285544332211?text=' . $encoded;

            // Page must contain the contextual WhatsApp link
            $response->assertSee($expectedUrl, false);

            // Floating CTA on program page also adopts the contextual message
            $response->assertSee('aria-label="Konsultasi cepat via WhatsApp (buka chat di tab baru)"', false);
        }
    }

    public function test_all_whatsapp_ctas_use_the_same_configuration_source(): void
    {
        // First configuration
        config(['services.whatsapp.phone' => '081234567891']);
        config(['services.whatsapp.default_message' => 'Pesan Tes Pertama']);

        $res1 = $this->get('/');
        $res1->assertStatus(200);
        $res1->assertSee('https://wa.me/6281234567891?text=' . rawurlencode('Pesan Tes Pertama'), false);

        // Dynamically change configuration source
        config(['services.whatsapp.phone' => '089876543210']);
        config(['services.whatsapp.default_message' => 'Pesan Tes Kedua']);

        $res2 = $this->get('/');
        $res2->assertStatus(200);
        $res2->assertSee('https://wa.me/6289876543210?text=' . rawurlencode('Pesan Tes Kedua'), false);
        $res2->assertDontSee('6281234567891', false);
    }

    public function test_floating_cta_has_accessible_markup_and_rel_attributes(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('aria-label="Layanan Bantuan WhatsApp"', false);
        $response->assertSee('target="_blank"', false);
        $response->assertSee('rel="noopener noreferrer"', false);
        $response->assertSee('aria-label="Konsultasi cepat via WhatsApp (buka chat di tab baru)"', false);
    }

    public function test_no_real_contact_numbers_or_secrets_are_exposed(): void
    {
        $pages = ['/', route('program.show', 'training-plb3'), route('program.show', 'training-pppa'), route('program.show', 'training-ipal')];

        foreach ($pages as $url) {
            $response = $this->get($url);
            $response->assertStatus(200);

            // Never expose reference project number
            $response->assertDontSee('8118500177');

            // Never leak env markers
            $response->assertDontSee('WHATSAPP_PHONE=');
            $response->assertDontSee('APP_KEY=');
        }
    }
}
