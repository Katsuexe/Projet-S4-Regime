<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useAutoIncrement = true;
    protected $allowedFields = [
        'nom',
        'prenom',
        'email',
        'password',
        'genre',
        'is_gold',
        'solde',
    ];
    protected $useTimestamps = false;
}
