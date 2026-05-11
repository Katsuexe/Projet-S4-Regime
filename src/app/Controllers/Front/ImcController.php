<?php

namespace App\Controllers\Front;

use App\Controllers\BaseController;
use App\Libraries\ImcCalculator;

class ImcController extends BaseController
{
    public function calculerImc()
    {
        if (! $this->request->isAJAX()) {
            return $this->respondJson(['success' => false, 'message' => 'Requete invalide.'], 400);
        }

        $payload = $this->request->getJSON(true) ?? [];
        $taille = (float) ($payload['taille'] ?? 0);
        $poids = (float) ($payload['poids'] ?? 0);

        if ($taille < 100 || $taille > 250 || $poids < 30 || $poids > 300) {
            return $this->respondJson(['success' => false, 'message' => 'Mensurations invalides.'], 422);
        }

        $imc = ImcCalculator::calculate($poids, $taille);
        $categorie = ImcCalculator::categorie($imc);
        $genre = $this->resolveGenre();
        $ideal = ImcCalculator::imcIdeal($genre, $taille);

        return $this->respondJson([
            'success' => true,
            'imc' => number_format($imc, 1, '.', ''),
            'categorie' => $categorie,
            'couleur' => $this->resolveCouleur($imc),
            'poids_ideal' => number_format((float) $ideal['poids_ideal'], 1, '.', ''),
            'fourchette_ideale' => number_format((float) $ideal['imc_min'], 1, '.', '') . ' - ' . number_format((float) $ideal['imc_max'], 1, '.', ''),
            'imc_min' => number_format((float) $ideal['imc_min'], 1, '.', ''),
            'imc_max' => number_format((float) $ideal['imc_max'], 1, '.', ''),
        ]);
    }

    private function resolveGenre(): string
    {
        $registerStep1 = session('register_step1');

        if (is_array($registerStep1) && ! empty($registerStep1['genre'])) {
            return (string) $registerStep1['genre'];
        }

        return (string) (session('genre') ?? 'homme');
    }

    private function resolveCouleur(float $imc): string
    {
        return match (true) {
            $imc < 18.5 => 'obese',
            $imc < 25 => 'normal',
            $imc < 30 => 'surpoid',
            default => 'obese',
        };
    }

    private function respondJson(array $payload, int $statusCode = 200)
    {
        $payload['csrf'] = service('security')->getCSRFHash();

        return $this->response->setStatusCode($statusCode)->setJSON($payload);
    }
}
