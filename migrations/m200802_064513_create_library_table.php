<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%library}}`.
 */
class m200802_064513_create_library_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%library}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'type' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%library}}');
    }
}
