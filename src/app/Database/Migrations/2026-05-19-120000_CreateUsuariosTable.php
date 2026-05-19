<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsuariosTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'            => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'nome_completo' => ['type' => 'VARCHAR', 'constraint' => 150],
            'email'         => ['type' => 'VARCHAR', 'constraint' => 100],
            'cpf'           => ['type' => 'VARCHAR', 'constraint' => 11],
            'senha'         => ['type' => 'VARCHAR', 'constraint' => 255],
            'estado'        => ['type' => 'CHAR', 'constraint' => 2],
            'categoria'     => ['type' => 'VARCHAR', 'constraint' => 100],
            'tipo_contrato' => ['type' => 'VARCHAR', 'constraint' => 50],
            'modalidade'    => ['type' => 'VARCHAR', 'constraint' => 50],
            'created_at'    => ['type' => 'DATETIME', 'null' => true],
            'updated_at'    => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('email');
        $this->forge->addUniqueKey('cpf');
        $this->forge->createTable('usuarios');
    }

    public function down()
    {
        $this->forge->dropTable('usuarios');
    }
}
