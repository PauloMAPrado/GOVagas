<?php

namespace App\Models;

use CodeIgniter\Model;

class EmpresaModel extends Model
{
    protected $table = 'empresas';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nome', 'email', 'senha', 'whatsapp', 'created_at', 'updated_at'];
    protected $useTimestamps = true;
}
