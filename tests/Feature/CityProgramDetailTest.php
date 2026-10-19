<?php

namespace Tests\Feature;

use Tests\TestCase;

class CityProgramDetailTest extends TestCase
{
    /**
     * Ensure all three program levels render complete canonical content with personalized city context.
     */
    public function test_all_three_programs_render_canonical_content_with_city_context(): void
    {
        // 1. Muda in Bandung
        $responseMuda = $this->get(route('city.program.detail', ['city' => 'bandung', 'program' => 'muda']));
        $responseMuda->assertStatus(200);
        $responseMuda->assertSee('Training PLB3 (Pengelolaan Limbah B3) — Kota Bandung');
        $responseMuda->assertSee('Pengelolaan Limbah B3');
        $content = $responseMuda->getContent();
        $expected = 'Training Penanggung Jawab Pengelolaan Limbah B3 (PLB3) dirancang untuk membekali profesional dengan penguasaan hukum, teknis, dan administratif pengelolaan limbah B3. Peserta mempelajari tata cara perolehan Rincian Teknis TPS Limbah B3, simbol dan label B3, neraca masa simpan (90/180/365 hari), pembuatan kontrak kerja sama dengan transporter dan pemusnah berizin, serta pelaporan elektronik FESTRONIK &amp; SIRAJA/SIMPEL KLHK.';
        $this->assertTrue(strpos($content, $expected) !== false, "Expected string not found in response. Expected: {$expected}");
        $content = $responseMuda->getContent();
        $expected = 'Penyusunan Rincian Teknis (Rintek) TPS Limbah B3';
        $this->assertTrue(strpos($content, $expected) !== false, "Expected string not found in response. Expected: {$expected}");
        $content = $responseMuda->getContent();
        $expected = 'Pengawasan Identifikasi &amp; Pelabelan Limbah B3';
        $this->assertTrue(strpos($content, $expected) !== false, "Expected string not found in response. Expected: {$expected}");
        $content = $responseMuda->getContent();
        $expected = 'Pengendalian Masa Simpan &amp; Neraca Limbah B3';
        $this->assertTrue(strpos($content, $expected) !== false, "Expected string not found in response. Expected: {$expected}");
        $content = $responseMuda->getContent();
        $expected = 'Verifikasi Legalitas Transporter &amp; Pemusnah Pihak Ketiga';
        $this->assertTrue(strpos($content, $expected) !== false, "Expected string not found in response. Expected: {$expected}");
        $content = $responseMuda->getContent();
        $expected = 'Sistem Manifes Elektronik (FESTRONIK) &amp; SIMPEL';
        $this->assertTrue(strpos($content, $expected) !== false, "Expected string not found in response. Expected: {$expected}");
        $content = $responseMuda->getContent();
        $expected = 'Konten detail program belum tersedia.';
        $this->assertFalse(strpos($content, $expected) !== false, "Unexpected string found in response. Expected: {$expected}");

        // 2. Madya in Malang
        $responseMadya = $this->get(route('city.program.detail', ['city' => 'malang', 'program' => 'madya']));
        $responseMadya->assertStatus(200);
        $responseMadya->assertSee('Training PPPA (Pengendalian Pencemaran Air) — Kota Malang');
        $responseMadya->assertSee('Pengendalian Pencemaran Air');
        $content = $responseMadya->getContent();
        $expected = 'Training Penanggung Jawab Pengendalian Pencemaran Air (PPPA) dirancang berdasarkan Standar Kompetensi Kerja Nasional Indonesia (SKKNI) dan Peraturan Menteri LHK No. P.03/2018. Program ini membekali manajer lingkungan dan supervisor IPAL dengan kemampuan menilai potensi beban pencemaran air, mengawasi operasional instalasi, merencanakan mitigasi keadaan darurat, dan memastikan pemenuhan baku mutu limbah cair industri.';
        if (strpos($content, $expected) === false) {
            dd('Expected string not found in Madya response. Content snippet: '.substr($content, 0, 5000));
        }
        $this->assertTrue(strpos($content, $expected) !== false, "Expected string not found in response. Expected: {$expected}");
        $content = $responseMadya->getContent();
        $expected = 'Identifikasi Sumber &amp; Karakteristik Air Limbah';
        $this->assertTrue(strpos($content, $expected) !== false, "Expected string not found in response. Expected: {$expected}");
        $content = $responseMadya->getContent();
        $expected = 'Perencanaan &amp; Supervisi Instalasi IPAL';
        $this->assertTrue(strpos($content, $expected) !== false, "Expected string not found in response. Expected: {$expected}");
        $content = $responseMadya->getContent();
        $expected = 'Kepatuhan Regulasi &amp; Pemenuhan Baku Mutu';
        $this->assertTrue(strpos($content, $expected) !== false, "Expected string not found in response. Expected: {$expected}");
        $content = $responseMadya->getContent();
        $expected = 'Mitigasi Tanggap Darurat Pencemaran Air';
        $this->assertTrue(strpos($content, $expected) !== false, "Expected string not found in response. Expected: {$expected}");
        $content = $responseMadya->getContent();
        $expected = 'Pelaporan Berkala ke SIMPEL KLHK';
        $this->assertTrue(strpos($content, $expected) !== false, "Expected string not found in response. Expected: {$expected}");
        $content = $responseMadya->getContent();
        $expected = 'Konten detail program belum tersedia.';
        $this->assertFalse(strpos($content, $expected) !== false, "Unexpected string found in response. Expected: {$expected}");

        // 3. Utama in Kabupaten Malang
        $responseUtama = $this->get(route('city.program.detail', ['city' => 'kab-malang', 'program' => 'utama']));
        $responseUtama->assertStatus(200);
        $responseUtama->assertSee('Training PPPU (Pengendalian Pencemaran Udara) — Kabupaten Malang');
        $responseUtama->assertSee('Pengendalian Pencemaran Udara');
        $content = $responseUtama->getContent();
        $expected = 'Training Penanggung Jawab Pengendalian Pencemaran Udara (PPPU) ditujukan bagi profesional yang memegang tanggung jawab strategis pengendalian emisi gas buang di industri. Program ini membahas penentuan titik cerobong emisi, inventarisasi gas rumah kaca (GRK), pemenuhan Permen LHK No. 11/2021, integrasi sistem pemantauan emisi kontinu (CEMS/SISPEK), dan strategi pencegahan polusi udara.';
        if (strpos($content, $expected) === false) {
            dd('Expected string not found in Utama response. Content snippet: '.substr($content, 0, 5000));
        }
        $this->assertTrue(strpos($content, $expected) !== false, "Expected string not found in response. Expected: {$expected}");
        $content = $responseUtama->getContent();
        $expected = 'Inventarisasi Emisi Sumber Tidak Bergerak';
        $this->assertTrue(strpos($content, $expected) !== false, "Expected string not found in response. Expected: {$expected}");
        $content = $responseUtama->getContent();
        $expected = 'Perencanaan Persetujuan Teknis (Pertek) Emisi';
        $this->assertTrue(strpos($content, $expected) !== false, "Expected string not found in response. Expected: {$expected}");
        $content = $responseUtama->getContent();
        $expected = 'Pengawasan Sistem Pemantauan Kontinu (CEMS / SISPEK)';
        $this->assertTrue(strpos($content, $expected) !== false, "Expected string not found in response. Expected: {$expected}");
        $content = $responseUtama->getContent();
        $expected = 'Perencanaan Mitigasi &amp; Efisiensi Bahan Bakar';
        $this->assertTrue(strpos($content, $expected) !== false, "Expected string not found in response. Expected: {$expected}");
        $content = $responseUtama->getContent();
        $expected = 'Pelaporan Berkala SIMPEL Udara';
        $this->assertTrue(strpos($content, $expected) !== false, "Expected string not found in response. Expected: {$expected}");
        $content = $responseUtama->getContent();
        $expected = 'Konten detail program belum tersedia.';
        $this->assertFalse(strpos($content, $expected) !== false, "Unexpected string found in response. Expected: {$expected}");
    }

    /**
     * Ensure full program slugs (e.g. k3-konstruksi-muda) also resolve properly.
     */
    public function test_full_program_slugs_resolve_correctly(): void
    {
        $response = $this->get(route('city.program.detail', ['city' => 'bandung', 'program' => 'k3-konstruksi-muda']));
        $response->assertStatus(200);
        $response->assertSee('Training PPPA (Pengendalian Pencemaran Air) — Kota Bandung');
    }

    /**
     * Invalid city slug should return 404.
     */
    public function test_invalid_city_returns_404(): void
    {
        $response = $this->get(route('city.program.detail', ['city' => 'nonexistent-city', 'program' => 'muda']));
        $response->assertStatus(404);
    }

    /**
     * Invalid program slug should return 404.
     */
    public function test_invalid_program_returns_404(): void
    {
        $response = $this->get(route('city.program.detail', ['city' => 'bandung', 'program' => 'invalid']));
        $response->assertStatus(404);
    }
}
