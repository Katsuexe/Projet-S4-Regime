<?php

namespace App\Models;

use CodeIgniter\Model;

class ActiviteModel extends Model
{
	protected $table = 'activites';
	protected $primaryKey = 'id';
	protected $returnType = 'array';
	protected $useAutoIncrement = true;
	protected $allowedFields = [
		'nom',
		'description',
		'calories_h',
		'duree_min',
	];
	protected $useTimestamps = false;
}

