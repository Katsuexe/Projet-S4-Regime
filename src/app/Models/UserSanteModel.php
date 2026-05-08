<?php

namespace App\Models;

use CodeIgniter\Model;

class UserSanteModel extends Model
{
    protected $table = 'user_sante';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useAutoIncrement = true;
    protected $allowedFields = [
        'user_id',
        'taille',
        'poids',
        'objectif',
    ];
    protected $useTimestamps = false;
}
