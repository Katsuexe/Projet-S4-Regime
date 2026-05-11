<?php


namespace App\Libraries;

class RegimeSuggestor
{
	private const REMISE_GOLD = 0.15;

	public static function applyGoldDiscount(float $prix, bool $isGold): float
	{
		return $isGold ? round($prix * (1 - self::REMISE_GOLD), 2) : $prix;
	}
}

