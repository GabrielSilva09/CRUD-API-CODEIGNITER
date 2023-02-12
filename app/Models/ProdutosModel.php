<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdutosModel extends Model
{
    protected $table            = 'produtos';
    protected $primaryKey       = 'id';
    protected $allowedFields    = ['nomeproduto', 'valor', 'categoria', 'custo'];

    // Validation
    protected $validationRules      = [
        'nomeproduto' => 'required|min_length[3]|is_unique[produtos.nomeproduto]'
    ];
}
