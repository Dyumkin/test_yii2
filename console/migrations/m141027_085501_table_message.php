<?php

use yii\db\Schema;
use yii\db\Migration;

class m141027_085501_table_message extends Migration
{
    public function up()
    {
        $this->execute('CREATE TABLE source_message (
              id INTEGER PRIMARY KEY AUTO_INCREMENT,
              category VARCHAR(32),
              message TEXT
          );

          CREATE TABLE message (
              id INTEGER,
              language VARCHAR(16),
              translation TEXT,
              PRIMARY KEY (id, language),
              CONSTRAINT fk_message_source_message FOREIGN KEY (id)
                  REFERENCES source_message (id) ON DELETE CASCADE ON UPDATE RESTRICT
          );');
    }

    public function down()
    {
        $this->execute('DROP TABLE message;');
        $this->execute('DROP TABLE source_message;');
    }
}
