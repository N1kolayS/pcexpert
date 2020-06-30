<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%equipment}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%client}}`
 */
class m200630_113841_create_equipment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%equipment}}', [
            'id' => $this->primaryKey(),
            'created_at' => $this->datetime(),
            'client_id' => $this->integer()->notNull(),
            'kind' => $this->string(),
            'brand' => $this->string(),
            'sample' => $this->string(),
            'serial_number' => $this->string(),
            'description' => $this->text(),
        ]);

        // creates index for column `client_id`
        $this->createIndex(
            '{{%idx-equipment-client_id}}',
            '{{%equipment}}',
            'client_id'
        );

        // add foreign key for table `{{%client}}`
        $this->addForeignKey(
            '{{%fk-equipment-client_id}}',
            '{{%equipment}}',
            'client_id',
            '{{%client}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%client}}`
        $this->dropForeignKey(
            '{{%fk-equipment-client_id}}',
            '{{%equipment}}'
        );

        // drops index for column `client_id`
        $this->dropIndex(
            '{{%idx-equipment-client_id}}',
            '{{%equipment}}'
        );

        $this->dropTable('{{%equipment}}');
    }
}
