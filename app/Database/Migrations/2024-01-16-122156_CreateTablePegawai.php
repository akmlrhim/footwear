<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTablePegawai extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_pegawai' => [
                'type' => 'INT',
                'unsigned' => true,
                'auto_increment' => true
            ],
            'nama_lengkap' => [
                'type' => 'VARCHAR',
                'constraint' => 100
            ],
            'jenis_kelamin' => [
                'type' => 'ENUM("Laki-laki", "Perempuan")
                NOT NULL DEFAULT "Laki-laki"',
            ],
            'alamat' => [
                'type' => 'TEXT',
                'null' => false
            ],
        ]);

        $this->forge->addKey('id_pegawai', true);
        $this->forge->createTable('pegawai');
    }

    public function down()
    {
        $this->forge->dropTable('pegawai');
    }
}
