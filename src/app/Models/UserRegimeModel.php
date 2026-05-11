<?php

namespace App\Models;

use CodeIgniter\Model;

class UserRegimeModel extends Model
{
    protected $table = 'user_regimes';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useAutoIncrement = true;
    protected $allowedFields = [
        'user_id',
        'regime_id',
        'regime_duree_id',
        'activite_id',
        'prix_paye',
        'gold_remise',
        'date_debut',
    ];
    protected $useTimestamps = false;
}
