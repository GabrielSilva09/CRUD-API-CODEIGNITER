<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Pedidos extends Migration
{
    public function up()
    {
        //Configuração de criação da tabela
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'auto_increment' => true
            ],
            'cliente_id' => [
                'type' => 'INT',
            ],
            'produto_id' => [
                'type' => 'INT'
            ],
            'valorpedido' => [
                'type' => 'DOUBLE',
                'null' => false
            ],
            'formapagamento' => [
                'type' => 'varchar',
                'constraint' => 60,
                'null' => false
            ],
            'status' => [
                'type' => 'varchar',
                'constraint' => 40,
                'null' => false
            ]
        ]);

        //Criando regras de chaves
        $this->forge->addForeignKey('cliente_id', 'clientes', 'id');
        $this->forge->addForeignKey('produto_id', 'produtos', 'id');
        $this->forge->addPrimaryKey('id');

        //Criando a tabela
        $this->forge->createTable('pedidos', true);
    }

    public function down()
    {
        //Excluir a tabela
        $this->forge->dropTable('pedidos');
    }
}
