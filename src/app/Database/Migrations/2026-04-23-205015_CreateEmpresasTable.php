<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateEmpresasTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'=> ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'nome' => ['type' => 'varchar', 'constraint' => '100'],
            'email' => ['type' => 'varchar', 'constraint' => '100', 'unique' => true],
            'senha' => ['type' => 'varchar', 'constraint' => '255'],
            'whatsapp' => ['type' => 'varchar', 'constraint' => '20'],
            'created_at' => ['type' => 'datetime', 'null' => true],
            'updated_at' => ['type' => 'datetime', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('empresas');
    }

    public function down()
    {
        $this->forge->dropTable('empresas');
    }
}