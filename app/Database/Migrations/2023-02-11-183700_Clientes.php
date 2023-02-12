<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Clientes extends Migration
{
    public function up()
    {
        //Configuração de criação da tabela
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'auto_increment' => true
            ],
            'nome_razaosocial' => [
                'type' => 'VARCHAR',
                'constraint' => 60,
                'null' => false
            ],
            'cpf_cnpj' => [
                'type' => 'VARCHAR',
                'constraint' => 25,
                'null' => false
            ]
        ]);

        //Criando regras de chaves
        $this->forge->addPrimaryKey('id');
        $this->forge->addUniqueKey('cpf_cnpj');

        //Criando a tabela
        $this->forge->createTable('clientes', true);
    }

    public function down()
    {
        //Excluir a tabela
        $this->forge->dropTable('clientes');
    }
}
