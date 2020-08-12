<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%cat_service}}`.
 */
class m200809_075009_create_cat_service_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%cat_service}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'sort' => $this->integer()->defaultValue(0),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%cat_service}}');
    }
}
