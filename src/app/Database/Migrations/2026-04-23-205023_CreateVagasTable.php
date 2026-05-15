<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateVagasTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'int', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'empresa_id'  => ['type' => 'int', 'constraint' => 11, 'unsigned' => true],
            'titulo' => ['type' => 'varchar', 'constraint' => '255'],
            'categoria' => ['type' => 'varchar', 'constraint' => '100'],
            'tipo_contrato'  => ['type' => 'varchar', 'constraint' => '50'],
            'modalidade' => ['type' => 'varchar', 'constraint' => '50'],
            'data_encerramento' => ['type' => 'date', 'null' => true],
            'quantidade' => ['type' => 'int', 'constraint' => 5],
            'faixa_salarial' => ['type' => 'varchar', 'constraint' => '100', 'null' => true],
            'beneficios' => ['type' => 'text', 'null' => true],
            'localizacao' => ['type' => 'varchar', 'constraint' => '255'],
            'descricao' => ['type' => 'text'],
            'status' => ['type' => 'varchar', 'constraint' => '10', 'default' => 'ativo'],
            'created_at' => ['type' => 'datetime', 'null' => true],
            'updated_at' => ['type' => 'datetime', 'null' => true],
        ]);

        $this->forge->addKey('id', true);

        // FK só aplicada em MySQL (SQLite3 não suporta via forge)
        if ($this->db->DBDriver !== 'SQLite3') {
            $this->forge->addForeignKey('empresa_id', 'empresas', 'id', 'restrict', 'cascade');
        }

        $this->forge->createTable('vagas');
    }

    public function down()
    {
        $this->forge->dropTable('vagas');
    }
}