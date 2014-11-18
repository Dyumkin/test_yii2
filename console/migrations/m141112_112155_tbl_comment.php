<?php

use yii\db\Schema;
use yii\db\Migration;

class m141112_112155_tbl_comment extends Migration
{
    public function up()
    {
        $this->createTable('{{%comments_models}}', [
            'id' => Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL PRIMARY KEY',
            'name' => Schema::TYPE_STRING . '(255) NOT NULL',
            'status_id' => 'tinyint(1) NOT NULL DEFAULT 1',
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL'
        ]);
        $this->createIndex('name', '{{%comments_models}}', 'name');
        $this->createIndex('status_id', '{{%comments_models}}', 'status_id');
        $this->createIndex('created_at', '{{%comments_models}}', 'created_at');
        $this->createIndex('updated_at', '{{%comments_models}}', 'updated_at');

        $this->createTable('{{%guest}}', [
            'id' => Schema::TYPE_PK,
            'username' => Schema::TYPE_STRING . ' NOT NULL',
            'email' => Schema::TYPE_STRING . ' NOT NULL UNIQUE KEY',
            'status_id' => 'tinyint(2) NOT NULL DEFAULT 0',
            'is_registration' => 'tinyint(2) NOT NULL DEFAULT 0',
            'server_information' => Schema::TYPE_TEXT
        ]);
        // Comments table
        $this->createTable('{{%comments}}', [
            'id' => Schema::TYPE_PK,
            'parent_id' => Schema::TYPE_INTEGER,
            'model_class' => Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL',
            'model_id' => Schema::TYPE_INTEGER . ' NOT NULL',
            'user_id' => Schema::TYPE_INTEGER,
            'guest_id' => Schema::TYPE_INTEGER,
            'content' => Schema::TYPE_TEXT . ' NOT NULL',
            'status_id' => 'tinyint(2) NOT NULL DEFAULT 0',
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL'
        ]);
        // Indexes
        $this->createIndex('status_id', '{{%comments}}', 'status_id');
        $this->createIndex('created_at', '{{%comments}}', 'created_at');
        $this->createIndex('updated_at', '{{%comments}}', 'updated_at');

        // Foreign Keys
        $this->addForeignKey('FK_comment_parent', '{{%comments}}', 'parent_id', '{{%comments}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('FK_comment_user', '{{%comments}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('FK_comment_guest', '{{%comments}}', 'guest_id', '{{%guest}}', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('FK_comment_model_class', '{{%comments}}', 'model_class', '{{%comments_models}}', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('{{%comments}}');
        $this->dropTable('{{%guest}}');
        $this->dropTable('{{%comments_models}}');
    }
}
