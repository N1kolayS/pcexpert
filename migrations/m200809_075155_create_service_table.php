<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%service}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%cat_service}}`
 */
class m200809_075155_create_service_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%service}}', [
            'id' => $this->primaryKey(),
            'category_id' => $this->integer()->notNull(),
            'name' => $this->string(),
            'duration' => $this->string(),
            'price' => $this->decimal(20,2),
            'guarantee' => $this->string()->defaultValue(0),
        ]);

        // creates index for column `category_id`
        $this->createIndex(
            '{{%idx-service-category_id}}',
            '{{%service}}',
            'category_id'
        );

        // add foreign key for table `{{%cat_service}}`
        $this->addForeignKey(
            '{{%fk-service-category_id}}',
            '{{%service}}',
            'category_id',
            '{{%cat_service}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%cat_service}}`
        $this->dropForeignKey(
            '{{%fk-service-category_id}}',
            '{{%service}}'
        );

        // drops index for column `category_id`
        $this->dropIndex(
            '{{%idx-service-category_id}}',
            '{{%service}}'
        );

        $this->dropTable('{{%service}}');
    }
}
