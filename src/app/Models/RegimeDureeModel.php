<?php

namespace App\Models;

use CodeIgniter\Model;

class RegimeDureeModel extends Model
{
	protected $table = 'regime_durees';
	protected $primaryKey = 'id';
	protected $returnType = 'array';
	protected $useAutoIncrement = true;
	protected $allowedFields = [
		'regime_id',
		'duree_jours',
		'prix',
	];
	protected $useTimestamps = false;
}

