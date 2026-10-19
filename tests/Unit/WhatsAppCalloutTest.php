<?php

namespace Tests\Unit;

use App\Services\OllamaService;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

/**
 * Verify that the addWhatsAppCallout() method injects exactly five callouts
 * and that the configured contact numbers are used.
 */
class WhatsAppCalloutTest extends TestCase
{
    protected function getService(): OllamaService
    {
        return new OllamaService();
    }

    public function test_inserts_five_callouts_with_configured_contacts(): void
    {
        // Ensure the config contains the expected contacts.
        Config::set('services.whatsapp.callout_contacts', [
            '08118500177',
            '081399810272',
            '087894580806',
            '087894580649',
        ]);

        $service = $this->getService();
        // Prepare a simple HTML content with three paragraphs.
        $result = [
            'content' => "<p>Paragraf pertama.</p><p>Paragraf kedua.</p><p>Paragraf ketiga.</p>",
        ];

        // Use reflection to access the protected method.
        $ref = new \ReflectionMethod($service, 'addWhatsAppCallout');
        $ref->setAccessible(true);
        $updated = $ref->invoke($service, $result, 'TestCity');

        $content = $updated['content'];
        // Count occurrences of the callout wrapper class.
        $calloutCount = substr_count($content, 'bg-concrete-100');
        $this->assertEquals(5, $calloutCount, 'Expected exactly five WhatsApp callouts');

        // Verify that each configured contact appears at least once in a wa.me URL.
        foreach (Config::get('services.whatsapp.callout_contacts') as $phone) {
            $normalized = preg_replace('/[^0-9]/', '', $phone);
            // The service normalizes leading 0 to 62.
            if (str_starts_with($normalized, '0')) {
                $normalized = '62' . substr($normalized, 1);
            }
            $this->assertStringContainsString($normalized, $content);
        }
    }
}
