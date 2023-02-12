<?php

namespace App\Models;

use CodeIgniter\Model;

class ClientesModel extends Model
{
    protected $table            = 'clientes';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['nome_razaosocial', 'cpf_cnpj'];

    // Validation
    protected $validationRules      = [
        'cpf_cnpj' => 'required|min_length[10]|is_unique[clientes.cpf_cnpj]'
    ];
}
