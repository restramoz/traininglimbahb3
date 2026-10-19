<?php

namespace App\Services;

use App\Models\Article;
use App\Support\WhatsApp;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class OllamaService
{
    protected ?string $apiKey;

    protected ?string $baseUrl;

    protected ?string $model;

    protected int $timeout;

    /**
     * Standard Sertifikasi & Jasa Pengelolaan Limbah B3 dan Lingkungan Hidup core topics.
     *
     * @var array<int, array{name: string, focus: string}>
     */
    public const CORE_TOPICS = [
        [
            'name' => 'Tata Kelola Pengelolaan Limbah B3 Industri Sesuai PP No. 22 Tahun 2021 dan Permen LHK No. 6 Tahun 2021',
            'focus' => 'Penyimpanan, pengemasan, pelabelan, manifest Festronik, neraca limbah B3, dan SOP tanggap darurat tumpahan B3',
        ],
        [
            'name' => 'Peran Penanggung Jawab Pengendalian Pencemaran Air (PPPA) dan Operasional IPAL di Fasilitas Industri',
            'focus' => 'Pengoperasian instalasi pengolahan air limbah, penghitungan beban pencemaran, parameter kunci baku mutu, dan integrasi SPARING',
        ],
        [
            'name' => 'Strategi Pengendalian Pencemaran Udara dan Pemantauan Emisi Cerobong (POIPPU & PPPU)',
            'focus' => 'Pengukuran isokinetik emisi gas buang, pemeliharaan wet scrubber/bag filter, dan kepatuhan Permen LHK No. 11 Tahun 2021',
        ],
        [
            'name' => 'Penyusunan Persetujuan Teknis (Pertek) Air Limbah dan Emisi Gas Buang ke Media Lingkungan',
            'focus' => 'Kajian teknis kapasitas tampung, pemodelan dispersi emisi, pemenuhan persyaratan SLO, dan integrasi persetujuan lingkungan',
        ],
        [
            'name' => 'Penyusunan Rincian Teknis (Rintek) TPS Limbah B3 untuk Industri dan Fasilitas Layanan Kesehatan',
            'focus' => 'Persyaratan rancang bangun TPS B3, ventilasi, eye-wash, simbol & label limbah, serta koordinasi persetujuan dengan DLH setempat',
        ],
        [
            'name' => 'Prosedur Sampling dan Pengujian Laboratorium Lingkungan Terakreditasi KAN',
            'focus' => 'Pengambilan contoh uji air, udara ambien, emisi sumber tidak bergerak, chain of custody, dan pelaporan SIMPEL KLHK',
        ],
    ];

    public function __construct()
    {
        $this->apiKey = config('services.ollama.key');
        $this->baseUrl = config('services.ollama.base_url');
        $this->model = config('services.ollama.model');
        $this->timeout = (int) config('services.ollama.timeout', 60);
    }

    /**
     * Resolve chat endpoint URL safely.
     */
    public function getChatEndpoint(): string
    {
        $base = rtrim((string) $this->baseUrl, '/');

        if (str_ends_with($base, '/api/chat')) {
            return $base;
        }

        return "{$base}/api/chat";
    }

    /**
     * Select a relevant topic automatically based on region and existing articles.
     *
     * @return array{topic: string, focus: string}
     */
    public function pickTopicForRegion(string $cityName, ?string $citySlug = null): array
    {
        $existingTitles = [];
        if ($citySlug) {
            $existingTitles = Article::where('target_city_slug', $citySlug)
                ->pluck('title')
                ->toArray();
        }

        // Find first unused core topic
        foreach (self::CORE_TOPICS as $core) {
            $isUsed = false;
            foreach ($existingTitles as $title) {
                if (stripos($title, $core['name']) !== false) {
                    $isUsed = true;
                    break;
                }
            }

            if (! $isUsed) {
                return [
                    'topic' => "Panduan {$core['name']} untuk Proyek di {$cityName}",
                    'focus' => $core['focus'],
                ];
            }
        }

        // If all core topics are covered, return an advanced operational angle
        $count = count($existingTitles) + 1;

        return [
            'topic' => "Strategi Kepatuhan Regulasi Lingkungan Hidup & Pengelolaan Limbah B3 di {$cityName} (Bagian {$count})",
            'focus' => 'Pemenuhan baku mutu air limbah, emisi cerobong, perizinan Pertek, manifest Festronik B3, dan audit kepatuhan SIMPEL KLHK',
        ];
    }

    /**
     * Resolve word count from direct input (validated as integer 6000-9000).
     */
    public function resolveWordCount(int $wordCount): int
    {
        return $wordCount;
    }

    /**
     * Generate an article draft via Ollama.
     *
     * @param  array<string, mixed>  $params
     * @return array<string, mixed>
     */
    public function generateArticle(array $params): array
    {
        // 1. Verifikasi kelengkapan konfigurasi tanpa memanggil API
        if (empty($this->baseUrl)) {
            return [
                'success' => false,
                'error' => 'Konfigurasi OLLAMA_BASE_URL belum diatur di file .env.',
            ];
        }

        if (empty($this->model)) {
            return [
                'success' => false,
                'error' => 'Konfigurasi OLLAMA_MODEL belum diatur di file .env.',
            ];
        }

        $cityName = trim((string) ($params['city_name'] ?? 'Indonesia'));
        $districtName = ! empty($params['district_name']) ? trim((string) $params['district_name']) : null;
        $citySlug = $params['city_slug'] ?? null;
        $wordCount = $this->resolveWordCount($params['word_count'] ?? 7500);

        // Auto topic selection if not manually provided
        if (empty($params['topic'])) {
            $selected = $this->pickTopicForRegion($cityName, $citySlug);
            $topic = $selected['topic'];
            $focus = $selected['focus'];
        } else {
            $topic = trim((string) $params['topic']);
            $focus = $params['focus'] ?? 'Sertifikasi kompetensi lingkungan dan tata kelola limbah B3 sesuai regulasi KLHK';
        }

        $locationContext = $districtName ? "Kecamatan {$districtName}, {$cityName}" : $cityName;

        $systemPrompt = <<<PROMPT
Anda adalah Lead Specialist Pengelolaan Limbah B3 dan Konsultan Senior Perizinan Lingkungan Hidup di Indonesia.
Tugas Anda adalah menulis artikel edukatif dan otoritatif berstandar industri B2B dalam Bahasa Indonesia formal mengenai Sertifikasi Kompetensi Lingkungan (PPPA, IPAL, PLB3, PPPU, POIPPU, PCUA) dan Jasa Lingkungan Hidup (Uji Emisi, Pertek, Rintek, UKL-UPL, Transportasi Limbah B3). Struktur artikel harus mencakup: Pembuka (intro), Silabus, Materi, Isi Konten, dan Penutup (conclusion).

ATURAN KUALITAS & GAYA PENULISAN:
1. Nada bahasa: Profesional, lugas, mengalir alami, berbobot untuk pengambil keputusan industri (Plant Manager, HSE Manager, Environmental Officer, Direktur Operasional).
2. Dilarang menggunakan filler AI klise seperti "Di era modern saat ini", "Tak dapat dipungkiri", atau kalimat berulang.
3. Rujuk regulasi nyata Indonesia: UU No. 32 Tahun 2009 tentang Perlindungan dan Pengelolaan Lingkungan Hidup, PP No. 22 Tahun 2021 tentang Penyelenggaraan Perlindungan dan Pengelolaan Lingkungan Hidup, Permen LHK No. 6 Tahun 2021 tentang Pengelolaan Limbah B3, Permen LHK No. P.03/2018 (Sertifikasi PPPA), Permen LHK No. P.06/2018 (Sertifikasi PLB3), dan Permen LHK No. 11 Tahun 2021 (Baku Mutu Emisi).
4. Jangan mengarang jadwal tetap, biaya fiktif, alamat kantor palsu, atau klaim akreditasi sepihak. Arahkan konsultasi resmi melalui WhatsApp.
5. Gunakan tag HTML semantik: <h2>, <h3>, <p>, <ul>, <ol>, <li>, <strong>, <blockquote>, <table><thead><tr><th>...</th></tr></thead><tbody><tr><td>...</td></tr></tbody></table>.
6. Panjang target: Sekitar {$wordCount} kata (antara 6.000 hingga 9.000 kata).
7. Buat image_brief terpisah yang siap digunakan oleh desainer di Google Flow untuk menghasilkan gambar fotografi realistis beresolusi tinggi TANPA teks di gambar.

OUTPUT WAJIB:
Kembalikan HANYA dokumen JSON murni tanpa pembungkus markdown ```json ```.
Format skema JSON yang wajib dipatuhi:
{
  "title": "Judul Artikel Informatif dan Otoritatif",
  "slug": "slug-url-ramah-seo",
  "excerpt": "Ringkasan eksekutif 2-3 kalimat mengenai intisari artikel.",
  "content": "<p>Isi artikel lengkap dalam HTML semantik...</p>",
  "seo_title": "SEO Title Max 60 Karakter | Training Limbah B3",
  "meta_description": "Meta description persuasif max 155 karakter.",
  "suggested_faqs": [
    {"q": "Pertanyaan 1...", "a": "Jawaban ringkas 1..."},
    {"q": "Pertanyaan 2...", "a": "Jawaban ringkas 2..."}
  ],
  "image_brief": {
    "concept": "Konsep visual foto fasilitas lingkungan dalam Bahasa Indonesia",
    "english_prompt": "Detailed descriptive photo prompt in English for Google Flow: realistic photography, environmental laboratory or industrial wastewater treatment plant in Indonesia, environmental engineers inspecting water samples and monitoring stack emissions, wearing certified PPE and hardhats, realistic industrial lighting, high detail, no text overlays, 8k",
    "aspect_ratio": "16:9",
    "recommended_alt": "Alt text ramah SEO dalam Bahasa Indonesia"
  }
}
PROMPT;

        $userPrompt = <<<PROMPT
Silakan buat artikel Pengelolaan Limbah B3 & Lingkungan Hidup lengkap dengan rincian berikut:
- Topik Artikel: {$topic}
- Fokus Materi: {$focus}
- Lokasi Target: {$locationContext}
- Target Jumlah Kata: ~{$wordCount} kata (antara 6.000 - 9.000 kata)

Keluarkan HANYA JSON valid.
PROMPT;

        try {
            $endpoint = $this->getChatEndpoint();
            $client = Http::timeout($this->timeout);

            if (! empty($this->apiKey)) {
                $client = $client->withToken($this->apiKey);
            }

            $response = $client->post($endpoint, [
                'model' => $this->model,
                'messages' => [
                    ['role' => 'system', 'content' => $systemPrompt],
                    ['role' => 'user', 'content' => $userPrompt],
                ],
                'stream' => false,
            ]);

            if (! $response->successful()) {
                Log::error('Ollama API error response', [
                    'status' => $response->status(),
                    'endpoint' => $endpoint,
                    'model' => $this->model,
                ]);

                return [
                    'success' => false,
                    'error' => "Ollama merespons dengan status HTTP {$response->status()}: ".Str::limit($response->body(), 200),
                ];
            }

            $data = $response->json();
            $rawContent = $data['message']['content'] ?? '';

            if (empty(trim($rawContent))) {
                return [
                    'success' => false,
                    'error' => 'Ollama mengembalikan respons konten kosong.',
                ];
            }

            $result = $this->parseResponse($rawContent, $topic, $cityName, $wordCount);

            // ---------------------------------------------------------------------
            // Enforce word-count constraints before adding UI elements. Callouts
            // must not influence the word-count validation.
            // ---------------------------------------------------------------------
            $generatedWordCount = $this->countWords($result['content'] ?? '');
            if ($generatedWordCount > 9000) {
                return [
                    'success' => false,
                    'error' => 'Artikel yang dihasilkan melebihi batas maksimum 9.000 kata.',
                ];
            }

            // Robust continuation loop: bounded rounds to reach the minimum word count.
            $maxAttempts = 8;
            $attempt = 0;
            while ($generatedWordCount < 6000 && $attempt < $maxAttempts) {
                $remaining = max(6000 - $generatedWordCount, 300);
                $continuation = $this->requestContinuation($result['content'], $remaining, $cityName);
                if (! $continuation['success']) {
                    return $continuation;
                }
                $result['content'] .= $continuation['content'];
                $generatedWordCount = $this->countWords($result['content']);
                $attempt++;
            }

            if ($generatedWordCount < 6000) {
                return [
                    'success' => false,
                    'error' => 'Artikel yang dihasilkan kurang dari batas minimum 6.000 kata.',
                ];
            }

            if ($generatedWordCount > 9000) {
                return [
                    'success' => false,
                    'error' => 'Artikel yang dihasilkan melebihi batas maksimum 9.000 kata.',
                ];
            }

            // After validation, inject five WhatsApp callouts.
            $result = $this->addWhatsAppCallout($result, $cityName);

            return $result;
        } catch (ConnectionException $e) {
            Log::error('Ollama connection timeout or unreachable: '.$e->getMessage());

            return [
                'success' => false,
                'error' => 'Koneksi ke Ollama gagal atau timeout setelah '.$this->timeout.' detik. Pastikan layanan Ollama aktif dan endpoint dapat dijangkau.',
            ];
        } catch (\Throwable $e) {
            Log::error('OllamaService Exception: '.$e->getMessage());

            return [
                'success' => false,
                'error' => 'Terjadi kesalahan saat memproses permintaan artikel: '.$e->getMessage(),
            ];
        }
    }

    /**
     * Robust JSON parsing and fallback structure.
     *
     * @return array<string, mixed>
     */
    public function parseResponse(string $rawContent, string $fallbackTopic, string $cityName, int $wordCount): array
    {
        $cleaned = trim($rawContent);

        // Strip markdown code fences if present
        if (preg_match('/^```(?:json)?\s*(.*?)\s*```$/s', $cleaned, $matches)) {
            $cleaned = trim($matches[1]);
        } elseif (str_starts_with($cleaned, '```json')) {
            $cleaned = trim(substr($cleaned, 7));
            if (str_ends_with($cleaned, '```')) {
                $cleaned = trim(substr($cleaned, 0, -3));
            }
        } elseif (str_starts_with($cleaned, '```')) {
            $cleaned = trim(substr($cleaned, 3));
            if (str_ends_with($cleaned, '```')) {
                $cleaned = trim(substr($cleaned, 0, -3));
            }
        }

        // Remove stray markdown fences anywhere in the payload (mixed tags/text).
        $cleaned = preg_replace('/```(?:json)?/i', '', $cleaned) ?? $cleaned;
        $cleaned = str_replace('```', '', $cleaned);
        $cleaned = trim($cleaned);

        // Repair invalid JSON escape sequences produced by LaTeX/backslashes.
        $cleaned = $this->repairJsonEscapes($cleaned);

        $decoded = json_decode($cleaned, true);

        // If direct parse failed, extract the first balanced JSON object.
        if (! is_array($decoded)) {
            $json = $this->extractJsonObject($cleaned);
            if ($json !== null) {
                $decoded = json_decode($json, true);
            }
        }

        // Retry after removing trailing commas (common LLM mistake).
        if (! is_array($decoded)) {
            $repaired = preg_replace('/,\s*([}\]])/', '$1', $cleaned) ?? $cleaned;
            $decoded = json_decode($repaired, true);
            if (! is_array($decoded)) {
                $json = $this->extractJsonObject($repaired);
                if ($json !== null) {
                    $decoded = json_decode($json, true);
                }
            }
        }

        if (is_array($decoded) && ! empty($decoded['title'])) {
            $imageBrief = $decoded['image_brief'] ?? [];
            if (! is_array($imageBrief)) {
                $imageBrief = [];
            }

            $concept = $imageBrief['concept'] ?? "Penerapan pengelolaan lingkungan dan tata kelola limbah B3 di {$cityName}";
            $englishPrompt = $imageBrief['english_prompt'] ?? 'Professional documentary photograph of environmental laboratory or wastewater treatment plant in Indonesia, environmental engineers inspecting water samples and monitoring stack emissions, authentic industrial environment, realistic lighting, 8k, no text';
            $aspectRatio = $imageBrief['aspect_ratio'] ?? '16:9';
            $recommendedAlt = $imageBrief['recommended_alt'] ?? "Pelatihan & Pengelolaan Limbah B3 di {$cityName}";

            $rawArticleContent = $this->sanitizeContent((string) ($decoded['content'] ?? ''));

            return [
                'success' => true,
                'title' => (string) $decoded['title'],
                'slug' => ! empty($decoded['slug']) ? Str::slug($decoded['slug']) : Str::slug($decoded['title']),
                'excerpt' => (string) ($decoded['excerpt'] ?? Str::limit(strip_tags($rawArticleContent), 180)),
                'content' => $rawArticleContent,
                'seo_title' => (string) ($decoded['seo_title'] ?? Str::limit($decoded['title'].' | Training Limbah B3', 60)),
                'meta_description' => (string) ($decoded['meta_description'] ?? Str::limit($decoded['excerpt'] ?? '', 155)),
                'suggested_faqs' => is_array($decoded['suggested_faqs'] ?? null) ? $decoded['suggested_faqs'] : [],
                'image_brief' => [
                    'concept' => $concept,
                    'english_prompt' => $englishPrompt,
                    'aspect_ratio' => $aspectRatio,
                    'recommended_alt' => $recommendedAlt,
                ],
            ];
        }

        // Recover HTML content when the model returns imperfect JSON.
        $fallbackContent = $cleaned;

        if (preg_match('/"content"\s*:\s*("(?:\\\\.|[^"\\\\])*")/s', $cleaned, $match)) {
            $extracted = json_decode($match[1], true);
            if (is_string($extracted) && trim($extracted) !== '') {
                $fallbackContent = $extracted;
            }
        }

        if (preg_match('/<\s*(p|h[1-6]|table|thead|tbody|tr|td|th|ul|ol|li|blockquote)\b/i', $fallbackContent)) {
            $fallbackHtml = $this->sanitizeContent($fallbackContent);
        } else {
            $fallbackHtml = '<p>'.nl2br(e($fallbackContent)).'</p>';
        }

        return [
            'success' => true,
            'title' => $fallbackTopic,
            'slug' => Str::slug($fallbackTopic),
            'excerpt' => Str::limit(strip_tags($fallbackHtml), 180),
            'content' => $fallbackHtml,
            'seo_title' => Str::limit("{$fallbackTopic} | Training Limbah B3", 60),
            'meta_description' => Str::limit("Panduan {$fallbackTopic} untuk kepatuhan lingkungan dan pengelolaan limbah B3 di {$cityName}.", 155),
            'suggested_faqs' => [],
            'image_brief' => [
                'concept' => "Pengelolaan limbah B3 dan lingkungan di {$cityName}",
                'english_prompt' => 'Professional photograph of environmental facility in Indonesia, realistic lighting, no text',
                'aspect_ratio' => '16:9',
                'recommended_alt' => "Training Limbah B3 - {$fallbackTopic}",
            ],
        ];
    }

    /**
     * Add context-aware WhatsApp CTA callouts without leaking hardcoded numbers.
     *
     * @param  array<string, mixed>  $result
     * @return array<string, mixed>
     */
    protected function addWhatsAppCallout(array $result, string $cityName): array
    {
        $content = $this->sanitizeContent($result['content'] ?? '');

        // Retrieve configured contacts; fallback to empty array.
        $contacts = config('services.whatsapp.callout_contacts', []);
        // Ensure we have at least one contact to avoid empty URLs.
        if (empty($contacts)) {
            return $result; // silently skip if no contacts configured.
        }

        // Prepare five contacts safely regardless of how many contacts are configured.
        $totalContacts = count($contacts);
        $selected = [];
        for ($i = 0; $i < 5; $i++) {
            $selected[] = $contacts[$i % $totalContacts];
        }

        // Split content by closing paragraph tags to insert between sections.
        $paragraphEnds = [];
        $offset = 0;
        while (($pos = strpos($content, '</p>', $offset)) !== false) {
            $paragraphEnds[] = $pos + 4; // position after </p>
            $offset = $pos + 4;
        }

        // Determine insertion indices – distribute roughly evenly.
        $insertPoints = [];
        $countEnds = count($paragraphEnds);
        for ($i = 0; $i < 5; $i++) {
            if ($countEnds === 0) {
                // No paragraphs – append at the end.
                $insertPoints[] = null;
                continue;
            }
            // Calculate target index proportionally.
            $target = (int) round(($i + 1) * $countEnds / 6);
            $insertPoints[] = $paragraphEnds[$target] ?? end($paragraphEnds);
        }

        // Insert callouts in reverse order so offsets remain valid.
        foreach (array_reverse($insertPoints, true) as $idx => $position) {
            $phone = $selected[$idx];
            $message = "Halo, saya ingin konsultasi mengenai Pelatihan & Layanan Pengelolaan Limbah B3 untuk wilayah {$cityName}.";
            $waUrl = WhatsApp::url($message, $phone);
            $ctaHtml = '<div class="my-6 p-4 rounded-xl bg-concrete-100 border border-emerald-300 flex flex-col sm:flex-row items-center justify-between gap-4 not-prose">'
                .'<div>'
                .'<div class="text-xs font-bold uppercase tracking-wider text-emerald-700">Konsultasi Lingkungan &amp; Limbah B3 '.$cityName.'</div>'
                .'<div class="text-sm font-semibold text-navy-950">Butuh pendampingan sertifikasi BNSP atau persetujuan teknis (Pertek/Rintek)?</div>'
                .'</div>'
                .'<a href="'.$waUrl.'" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-emerald-600 hover:bg-emerald-500 text-white font-semibold text-xs transition shrink-0">'
                .'<span>Konsultasi WhatsApp</span> &rarr;'
                .'</a>'
                .'</div>';

            if ($position !== null) {
                $content = substr_replace($content, $ctaHtml, $position, 0);
            } else {
                $content .= $ctaHtml;
            }
        }

        $result['content'] = $content;
        return $result;
    }

    /**
     * Request a continuation from Ollama for the given partial content.
     * Returns an array with keys: success (bool) and content (string) on success.
     */
    protected function requestContinuation(string $existingContent, int $targetWords, string $cityName): array
    {
        // Build a simple continuation prompt.
        $systemPrompt = "Anda adalah editor artikel lingkungan hidup dan pengelolaan limbah B3 berbahasa Indonesia. Lanjutkan artikel yang diberikan dengan konten baru sekitar {$targetWords} kata. Jangan mengulang paragraf atau judul yang sudah ada. Output HANYA fragmen HTML valid menggunakan tag semantik seperti <h2>, <h3>, <p>, <ul>, <ol>, <li>, <strong>, dan <table> bila relevan. Jangan keluarkan JSON, markdown fence, komentar, atau metadata. Jika tidak dapat memenuhi seluruh target, tetap keluarkan fragmen HTML valid yang bermakna.";
        $userPrompt = "Konten artikel yang sudah ada (gunakan sebagai konteks, jangan salin ulang):\n{$existingContent}\n\nTambahkan bagian lanjutan yang relevan dan substantif sebanyak kira-kira {$targetWords} kata. Fokus pada informasi baru, contoh penerapan lapangan, prosedur, risiko, pengendalian, dan kepatuhan regulasi yang relevan. Kembalikan hanya fragmen HTML tambahan, bukan artikel lengkap.";

        try {
            $endpoint = $this->getChatEndpoint();
            $client = Http::timeout($this->timeout);
            if (! empty($this->apiKey)) {
                $client = $client->withToken($this->apiKey);
            }
            $response = $client->post($endpoint, [
                'model' => $this->model,
                'messages' => [
                    ['role' => 'system', 'content' => $systemPrompt],
                    ['role' => 'user', 'content' => $userPrompt],
                ],
                'stream' => false,
            ]);

            if (! $response->successful()) {
                return ['success' => false, 'error' => 'Continuation request failed with HTTP '.$response->status()];
            }

            $data = $response->json();
            $raw = $data['message']['content'] ?? '';
            if (trim($raw) === '') {
                return ['success' => false, 'error' => 'Empty continuation response'];
            }

            $parsed = $this->parseResponse($raw, $cityName, $cityName, $targetWords);
            if (empty($parsed['content'])) {
                return ['success' => false, 'error' => 'Continuation parsing produced no content'];
            }
            $continuationContent = trim($parsed['content']);
            $addedWords = $this->countWords($continuationContent);

            if ($addedWords === 0) {
                return ['success' => false, 'error' => 'Continuation contains no usable words'];
            }

            // Reject an identical response to avoid repeatedly appending the same content.
            $normalizedExisting = preg_replace('/\s+/u', ' ', strip_tags($existingContent));
            $normalizedContinuation = preg_replace('/\s+/u', ' ', strip_tags($continuationContent));

            if (
                is_string($normalizedExisting)
                && is_string($normalizedContinuation)
                && trim($normalizedContinuation) !== ''
                && str_contains($normalizedExisting, trim($normalizedContinuation))
            ) {
                return ['success' => false, 'error' => 'Continuation repeated existing content'];
            }

            // A shorter valid fragment is acceptable; generateArticle() can request another round.
            return ['success' => true, 'content' => $continuationContent];
        } catch (ConnectionException $e) {
            return ['success' => false, 'error' => 'Continuation connection error: '.$e->getMessage()];
        } catch (\Throwable $e) {
            return ['success' => false, 'error' => 'Continuation exception: '.$e->getMessage()];
        }
    }

    /**
     * Count words in a string while ignoring HTML tags and decoding entities.
     *
     * @param string $content HTML content
     * @return int Number of words
     */
    public function countWords(string $content): int
    {
        // Remove HTML tags
        $text = strip_tags($content);
        // Decode HTML entities (e.g. &amp; -> &)
        $text = html_entity_decode($text, ENT_QUOTES | ENT_HTML5, 'UTF-8');
        // Normalize whitespace and split on word boundaries
        $words = preg_split('/\s+/u', trim($text));
        return $words === false ? 0 : count(array_filter($words, fn($w) => $w !== ''));
    }

    /**
     * Repair invalid JSON escape sequences (e.g. LaTeX backslashes) so that
     * json_decode can parse the payload.
     */
    protected function repairJsonEscapes(string $content): string
    {
        // Pass 1: backslash + 2 or more letters (LaTeX commands) -> escape backslash.
        $content = preg_replace_callback(
            '~\\\\[A-Za-z]{2,}~',
            static fn ($m) => '\\\\' . substr($m[0], 1),
            $content
        ) ?? $content;

        // Pass 2: backslash + single char; keep valid JSON escapes, escape the rest.
        $content = preg_replace_callback(
            '~\\\\(?:u[0-9a-fA-F]{4}|.)~s',
            static function ($m) {
                $esc = $m[0];
                if ($esc === '\\"' || $esc === '\\\\' || $esc === '\\/' ||
                    $esc === '\\b' || $esc === '\\f' || $esc === '\\n' ||
                    $esc === '\\r' || $esc === '\\t') {
                    return $esc;
                }
                if (preg_match('~^\\\\u[0-9a-fA-F]{4}$~', $esc)) {
                    return $esc;
                }
                if (strpos($esc, '\\u') === 0) {
                    return '\\\\' . substr($esc, 1);
                }
                return '\\\\' . substr($esc, 1);
            },
            $content
        ) ?? $content;

        return $content;
    }

    /**
     * Extract the first balanced JSON object from a string that may contain
     * surrounding prose or mixed tags.
     */
    protected function extractJsonObject(string $content): ?string
    {
        $start = strpos($content, '{');
        if ($start === false) {
            return null;
        }

        $depth = 0;
        $inString = false;
        $escape = false;
        $len = strlen($content);
        for ($i = $start; $i < $len; $i++) {
            $ch = $content[$i];
            if ($inString) {
                if ($escape) {
                    $escape = false;
                } elseif ($ch === '\\') {
                    $escape = true;
                } elseif ($ch === '"') {
                    $inString = false;
                }
            } else {
                if ($ch === '"') {
                    $inString = true;
                } elseif ($ch === '{') {
                    $depth++;
                } elseif ($ch === '}') {
                    $depth--;
                    if ($depth === 0) {
                        return substr($content, $start, $i - $start + 1);
                    }
                }
            }
        }

        return null;
    }

    protected function sanitizeContent(string $content): string
    {
        // ---------------------------------------------------------------
        // Phase 1: Strip block-level LaTeX math environments
        // e.g. \[ ... \], $$...$$, \begin{equation}...\end{equation}
        // ---------------------------------------------------------------
        $content = preg_replace('/\\\\\[[\s\S]*?\\\\\]/u', '', $content) ?? $content;
        $content = preg_replace('/\$\$[\s\S]*?\$\$/u', '', $content) ?? $content;
        $content = preg_replace('/\\\\begin\{[^}]+\}[\s\S]*?\\\\end\{[^}]+\}/u', '', $content) ?? $content;

        // ---------------------------------------------------------------
        // Phase 2: Convert inline LaTeX math $...$ to readable plain text
        // ---------------------------------------------------------------
        $content = preg_replace_callback('/\$([^$\n]+?)\$/u', function ($m) {
            $inner = $m[1];
            $inner = preg_replace('/\\\\text\{([^}]*)\}/u', '$1', $inner) ?? $inner;
            $inner = preg_replace('/\\\\mathrm\{([^}]*)\}/u', '$1', $inner) ?? $inner;
            $inner = preg_replace('/\\\\mathbf\{([^}]*)\}/u', '$1', $inner) ?? $inner;
            $inner = preg_replace('/\\\\frac\{([^}]*)\}\{([^}]*)\}/u', '$1/$2', $inner) ?? $inner;
            $inner = str_replace(
                ['\\rightarrow', '\\leftarrow', '\\Rightarrow', '\\Leftarrow', '\\leftrightarrow',
                 '\\times', '\\cdot', '\\pm', '\\leq', '\\geq', '\\neq', '\\approx',
                 '\\sum', '\\prod', '\\int', '\\infty',
                 '\\alpha', '\\beta', '\\gamma', '\\delta', '\\Delta', '\\sigma',
                 '\\mu', '\\lambda', '\\pi', '\\theta', '\\phi', '\\Sigma',
                 '_', '^', '\\', '{', '}'],
                ['→', '←', '⇒', '⇐', '↔',
                 '×', '·', '±', '≤', '≥', '≠', '≈',
                 '∑', '∏', '∫', '∞',
                 'α', 'β', 'γ', 'δ', 'Δ', 'σ',
                 'μ', 'λ', 'π', 'θ', 'φ', 'Σ',
                 '', '', '', '', ''],
                $inner
            );
            $inner = trim($inner);
            return $inner !== '' ? $inner : '';
        }, $content) ?? $content;

        // ---------------------------------------------------------------
        // Phase 3: Strip LaTeX commands with braces — extract inner text
        // \text{...}, \textbf{...}, \emph{...} etc.
        // ---------------------------------------------------------------
        $content = preg_replace_callback(
            '/\\\\(?:text|textbf|textit|emph|mathbf|mathrm|mathit|mathbb|mathcal|mathsf|operatorname)\{([^}]*)\}/u',
            fn ($m) => $m[1],
            $content
        ) ?? $content;

        // \frac{a}{b} \u2192 a/b
        $content = preg_replace_callback(
            '/\\\\frac\{([^}]*)\}\{([^}]*)\}/u',
            fn ($m) => $m[1] . '/' . $m[2],
            $content
        ) ?? $content;

        // Remaining \command{...} wrappers \u2014 extract inner text
        $content = preg_replace('/\\\\[a-zA-Z]+\{([^}]*)\}/u', '$1', $content) ?? $content;

        // ---------------------------------------------------------------
        // Phase 4: Replace common standalone LaTeX symbols
        // ---------------------------------------------------------------
        $content = str_replace(
            ['\\rightarrow', '\\leftarrow', '\\Rightarrow', '\\Leftarrow', '\\leftrightarrow',
             '\\times', '\\cdot', '\\leq', '\\geq', '\\neq', '\\approx',
             '\\infty', '\\pm', '\\alpha', '\\beta', '\\gamma', '\\delta',
             '\\Delta', '\\sigma', '\\mu', '\\lambda', '\\pi', '\\theta', '\\phi', '\\Sigma'],
            ['→', '←', '⇒', '⇐', '↔',
             '×', '·', '≤', '≥', '≠', '≈',
             '∞', '±', 'α', 'β', 'γ', 'δ',
             'Δ', 'σ', 'μ', 'λ', 'π', 'θ', 'φ', 'Σ'],
            $content
        );

        // ---------------------------------------------------------------
        // Phase 5: Remove any remaining bare LaTeX backslash commands
        // ---------------------------------------------------------------
        $content = preg_replace('/\\\\[a-zA-Z]+\b/u', '', $content) ?? $content;

        // ---------------------------------------------------------------
        // Phase 6: Remove stray dollar signs and leftover curly braces
        // ---------------------------------------------------------------
        $content = str_replace(['$', '{', '}'], '', $content);

        // ---------------------------------------------------------------
        // Phase 7: Normalize excess whitespace (preserve HTML tags)
        // ---------------------------------------------------------------
        $content = preg_replace('/[ \t]{2,}/', ' ', $content) ?? $content;

        return $content;
    }
}
