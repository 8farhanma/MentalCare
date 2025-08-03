<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUserActivitiesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id_activity' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'id_user' => [
                'type'       => 'INT',
                'constraint' => 11,
            ],
            'activity_description' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id_activity', true);
        // $this->forge->addForeignKey('id_user', 'users', 'id_user', 'CASCADE', 'CASCADE'); // Temporarily disabled
        $this->forge->createTable('user_activities');
    }

    public function down()
    {
        $this->forge->dropTable('user_activities');
    }
}
