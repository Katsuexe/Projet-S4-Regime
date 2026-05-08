<?php

namespace App\Models;

use CodeIgniter\Model;

class RegimeModel extends Model
{
	protected $table = 'regimes';
	protected $primaryKey = 'id';
	protected $returnType = 'array';
	protected $useAutoIncrement = true;
	protected $allowedFields = [
		'nom',
		'description',
		'pct_viande',
		'pct_poisson',
		'pct_volaille',
		'delta_poids_min',
		'delta_poids_max',
	];
	protected $useTimestamps = false;
}

