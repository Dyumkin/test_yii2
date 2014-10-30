<?php

use yii\db\Schema;
use yii\db\Migration;

class m141029_111644_table_post extends Migration
{
    public function up()
    {
// MySql table options
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        // Blogs table
        $this->createTable('{{%blog}}', [
            'id' => Schema::TYPE_PK,
            'alias' => Schema::TYPE_STRING . '(100) NOT NULL',
            'views' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 0',
            'status_id' => 'tinyint(4) NOT NULL DEFAULT 0',
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL'
        ], $tableOptions);

        // Indexes
        $this->createIndex('status_id', '{{%blog}}', 'status_id');
        $this->createIndex('views', '{{%blog}}', 'views');
        $this->createIndex('created_at', '{{%blog}}', 'created_at');
        $this->createIndex('updated_at', '{{%blog}}', 'updated_at');

        $this->createTable('{{%blog_lang}}', [
            'id' => Schema::TYPE_PK,
            'post_id' => Schema::TYPE_INTEGER,
            'lang_id' => Schema::TYPE_INTEGER,
            'title' => Schema::TYPE_STRING . '(100) NOT NULL',
            'snippet' => Schema::TYPE_TEXT . ' NOT NULL',
            'content' => 'longtext NOT NULL',
        ]);

        $this->addForeignKey('blog_fk', '{{%blog_lang}}', 'post_id', '{{%blog}}', 'id', 'CASCADE', 'NO ACTION');
        $this->addForeignKey('blog_lang_fk', '{{%blog_lang}}', 'lang_id', '{{%lang}}', 'id', 'NO ACTION', 'NO ACTION');
    }

    public function down()
    {
        $this->dropTable('{{%blog_lang}}');
        $this->dropTable('{{%blog}}');
    }
}
