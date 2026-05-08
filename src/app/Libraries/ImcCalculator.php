<?php

namespace App\Libraries;

class ImcCalculator
{
    public static function calculate(float $poidsKg, float $tailleCm): float
    {
        $tailleM = $tailleCm / 100;

        return round($poidsKg / ($tailleM ** 2), 2);
    }

    public static function categorie(float $imc): string
    {
        return match (true) {
            $imc < 18.5 => 'Insuffisance ponderale',
            $imc < 25.0 => 'Poids normal',
            $imc < 30.0 => 'Surpoids',
            default => 'Obesite',
        };
    }

    public static function imcIdeal(string $genre, float $tailleCm): array
    {
        $ideal = $genre === 'homme'
            ? $tailleCm - 100 - (($tailleCm - 150) / 4)
            : $tailleCm - 100 - (($tailleCm - 150) / 2.5);

        $tailleM = $tailleCm / 100;

        return [
            'poids_ideal' => round($ideal, 1),
            'imc_min'     => round(18.5 * $tailleM ** 2, 1),
            'imc_max'     => round(24.9 * $tailleM ** 2, 1),
        ];
    }
}
