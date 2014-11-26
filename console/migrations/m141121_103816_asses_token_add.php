<?php

use yii\db\Schema;
use yii\db\Migration;

class m141121_103816_asses_token_add extends Migration
{
    public function up()
    {
        $this->addColumn('{{%user}}','access_token', Schema::TYPE_STRING);
    }

    public function down()
    {
        $this->dropColumn('{{%user}}','access_token');
    }
}
