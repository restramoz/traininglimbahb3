<?php

namespace App\Http\Controllers;

use App\Services\RegionalService;
use Illuminate\Contracts\View\View;

class ProgramController extends Controller
{
    /**
     * Display the specified program or service page by slug.
     */
    public function show(string $slug): View
    {
        $programs = config('programs', []);

        if (! isset($programs[$slug])) {
            abort(404, 'Layanan atau program pelatihan tidak ditemukan.');
        }

        $program = $programs[$slug];

        // Recommend related programs in the same category or overall
        $relatedPrograms = collect($programs)
            ->filter(fn (array $p, string $key): bool => $key !== $slug)
            ->values()
            ->take(6)
            ->all();

        return view('programs.show', [
            'program' => $program,
            'relatedPrograms' => $relatedPrograms,
            'otherPrograms' => $relatedPrograms,
        ]);
    }

    /**
     * Display a city-specific service detail page preserving regional context.
     *
     * @param string $city      Slug of the city/regency (e.g. "bandung", "kab-bekasi")
     * @param string $program   Service identifier (e.g. "training-plb3", "jasa-pertek-lingkungan")
     */
    public function cityProgram(string $city, string $program, RegionalService $regional): View
    {
        $cityData = $regional->findCity($city);
        abort_if($cityData === null, 404, 'Kota/Kabupaten tidak ditemukan.');

        $programs = config('programs', []);

        // Direct key lookup
        $configKey = isset($programs[$program]) ? $program : null;

        // Fallback mapping for legacy aliases
        if ($configKey === null) {
            $legacyMap = [
                'muda' => 'training-plb3',
                'madya' => 'training-pppa',
                'utama' => 'training-pppu',
                'k3-konstruksi-muda' => 'training-plb3',
                'k3-konstruksi-madya' => 'training-pppa',
                'k3-konstruksi-utama' => 'training-pppu',
            ];
            $configKey = $legacyMap[$program] ?? null;
        }

        abort_if($configKey === null || ! isset($programs[$configKey]), 404, 'Layanan tidak ditemukan.');
        $programData = $programs[$configKey];

        $relatedPrograms = collect($programs)
            ->filter(fn (array $p, string $key): bool => $key !== $configKey)
            ->values()
            ->take(6)
            ->all();

        $waMessage = "Halo, saya dari {$cityData['name']} dan ingin konsultasi mengenai {$programData['title']}.";

        return view('city.program-detail', [
            'city' => $cityData,
            'program' => $programData,
            'relatedPrograms' => $relatedPrograms,
            'otherPrograms' => $relatedPrograms,
            'waMessage' => $waMessage,
        ]);
    }
}
