<?php

namespace codexten\yii\user\migrations;

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user}}`.
 */
class M140007164006Create_user_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string(255)->notNull(),
            'email' => $this->string(255),
            'password_hash' => $this->string(60),
            'auth_key' => $this->string(32),
            'logged_at' => $this->integer(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer
(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%user}}');
    }
}
