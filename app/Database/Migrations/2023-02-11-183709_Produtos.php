<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Produtos extends Migration
{
    public function up()
    {
        //Configuração de criação da tabela
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'auto_increment' => true
            ],
            'nomeproduto' => [
                'type' => 'VARCHAR',
                'constraint' => 60,
                'null' => false
            ],
            'valor' => [
                'type' => 'DOUBLE',
                'null' => false
            ],
            'categoria' => [
                'type' => 'varchar',
                'constraint' => 25,
                'null' => false
            ],
            'custo' => [
                'type' => 'DOUBLE',
                'null' => false
            ]
        ]);

        //Criando regras de chaves
        $this->forge->addPrimaryKey('id');
        $this->forge->addUniqueKey('nomeproduto');

        //Criando a tabela
        $this->forge->createTable('produtos', true);
    }

    public function down()
    {
        //Excluir a tabela
        $this->forge->dropTable('produtos');
    }
}
